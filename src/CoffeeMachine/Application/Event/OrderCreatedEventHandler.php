<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Event;

use App\CoffeeMachine\Domain\Entity\CoffeeSize;
use App\CoffeeMachine\Domain\Repository\CoffeeMachineRepositoryInterface;
use App\CoffeeMachine\Domain\Repository\OrderRepositoryInterface;
use Doctrine\DBAL\Connection;

class OrderCreatedEventHandler
{
    public function __construct(
        private readonly CoffeeMachineRepositoryInterface $coffeeMachineRepository,
        private readonly OrderRepositoryInterface $orderRepository,
        private Connection $connection,
    ) {
    }

    public function __invoke(OrderCreatedEvent $event): void
    {
        $machine = $this->coffeeMachineRepository->get();
        if (!$machine->isStarted()) {
            // We lost this coffee, maybe we could retry later
            return;
        }
        $order = $this->orderRepository->get($event->id);
        $order->start();
        $this->orderRepository->save($order);
        $machine->startCoffee();
        $this->coffeeMachineRepository->save($machine);
        foreach (CoffeeSize::cases() as $size) {
            sleep($machine->getStepPreparationTime());
            if ($order->getSize() === $size) {
                break;
            }

            $this->coffeeMachineRepository->refresh($machine);
            if (false === $machine->isUp()) {
                // Someone stop the machine, we lost this coffee
                return;
            }
        }

        $machine->finishCoffee();
        $this->coffeeMachineRepository->save($machine);
        $order->finish();
        $this->orderRepository->save($order);
    }
}
