<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Query;

use App\CoffeeMachine\Application\View\OrderView;
use App\CoffeeMachine\Domain\Repository\OrderRepositoryInterface;

class ProcessingOrderQueryHandler
{
    public function __construct(private readonly OrderRepositoryInterface $orderRepository)
    {
    }

    public function __invoke(ProcessingOrderQuery $query): ?OrderView
    {
        $processingOrder = $this->orderRepository->getProcessing();

        return $processingOrder ? new OrderView(
            size: $processingOrder->getSize(),
            intensity: $processingOrder->getIntensity(),
            createdAt: $processingOrder->getCreatedAt(),
            updatedAt: $processingOrder->getUpdatedAt(),
            status: $processingOrder->getStatus(),
        ) : null;
    }
}
