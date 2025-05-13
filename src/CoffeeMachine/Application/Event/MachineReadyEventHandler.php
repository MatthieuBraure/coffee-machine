<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Event;

use App\CoffeeMachine\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Infrastructure\EventBusInterface;

class MachineReadyEventHandler
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly EventBusInterface $eventBus)
    {
    }

    public function __invoke(MachineReadyEvent $event): void
    {
        $pendingOrders = $this->orderRepository->getPending();
        foreach ($pendingOrders as $order) {
            $this->eventBus->dispatchEvent(new OrderCreatedEvent($order->getId()));
        }

        if (null !== $order = $this->orderRepository->getProcessing()) {
            $order->cancel();
            $this->orderRepository->save($order);
        }
    }
}
