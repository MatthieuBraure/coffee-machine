<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Query;

use App\CoffeeMachine\Application\View\OrderView;
use App\CoffeeMachine\Domain\Entity\Order;
use App\CoffeeMachine\Domain\Repository\OrderRepositoryInterface;

class CompletedOrderQueryHandler
{
    public function __construct(private readonly OrderRepositoryInterface $orderRepository)
    {
    }

    /**
     * @return array<OrderView>
     */
    public function __invoke(CompletedOrderQuery $query): array
    {
        $completedCoffees = $this->orderRepository->getCompleted();

        return array_map(fn (Order $order) => new OrderView(
            size: $order->getSize(),
            intensity: $order->getIntensity(),
            createdAt: $order->getCreatedAt(),
            updatedAt: $order->getUpdatedAt(),
            status: $order->getStatus(),
        ), $completedCoffees);
    }
}
