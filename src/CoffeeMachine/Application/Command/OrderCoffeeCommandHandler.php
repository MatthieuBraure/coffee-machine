<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Command;

use App\CoffeeMachine\Application\Event\OrderCreatedEvent;
use App\CoffeeMachine\Application\Exception\MachineCannotTakeOrderException;
use App\CoffeeMachine\Domain\Entity\Order;
use App\CoffeeMachine\Domain\Repository\CoffeeMachineRepositoryInterface;
use App\CoffeeMachine\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Infrastructure\EventBusInterface;

class OrderCoffeeCommandHandler
{
    public function __construct(
        private readonly CoffeeMachineRepositoryInterface $coffeeMachineRepository,
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(OrderCoffeeCommand $command): void
    {
        $coffeeMachine = $this->coffeeMachineRepository->get();
        if (false === $coffeeMachine->canTakeOrder()) {
            throw new MachineCannotTakeOrderException();
        }

        $order = new Order(
            coffeeIntensity: $command->intensity,
            coffeeSize: $command->size,
        );
        $this->orderRepository->save($order);
        $this->eventBus->dispatchEvent(new OrderCreatedEvent($order->getId()));
    }
}
