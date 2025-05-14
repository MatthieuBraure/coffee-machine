<?php

namespace App\CoffeeMachine\Domain\Repository;

use App\CoffeeMachine\Domain\Entity\Order;

interface OrderRepositoryInterface
{
    public function get(int $id): ?Order;

    public function save(Order $entity): void;

    /**
     * @return array<Order>
     */
    public function getPending(): array;

    /**
     * @return array<Order>
     */
    public function getCompleted(): array;

    public function getProcessing(): ?Order;

    public function refresh(Order $entity): void;
}
