<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Event;

use App\CoffeeMachine\Domain\Entity\CoffeeSize;
use App\CoffeeMachine\Domain\Repository\CoffeeMachineRepositoryInterface;
use App\CoffeeMachine\Domain\Repository\OrderRepositoryInterface;

class OrderCreatedEventHandler
{
    public function __construct(
        private readonly CoffeeMachineRepositoryInterface $coffeeMachineRepository,
        private readonly OrderRepositoryInterface $orderRepository,
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
        if (null === $order || true === $order->isCanceled()) {
            return;
        }

        $order->start();
        $this->orderRepository->save($order);
        $machine->startCoffee();
        $this->coffeeMachineRepository->save($machine);
        foreach (CoffeeSize::cases() as $size) {
            sleep($machine->getStepPreparationTime());
            $this->coffeeMachineRepository->refresh($machine);
            if (false === $machine->isUp()) {
                // Someone stop the machine, we lost this coffee
                return;
            }

            if ($order->getSize() === $size) {
                break;
            }

            $this->orderRepository->refresh($order);
            if (true === $order->isCanceled()) {
                $machine->finishCoffee();
                $this->coffeeMachineRepository->save($machine);

                return;
            }
        }
        $machine->finishCoffee();
        $this->coffeeMachineRepository->save($machine);
        $order->finish();
        $this->orderRepository->save($order);
    }
}
