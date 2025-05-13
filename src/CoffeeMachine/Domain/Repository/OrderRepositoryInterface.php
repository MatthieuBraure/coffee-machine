<?php

namespace App\CoffeeMachine\Domain\Repository;

use App\CoffeeMachine\Domain\Entity\Order;

interface OrderRepositoryInterface
{
    public function get(int $id): Order;

    public function save(Order $entity): void;
}
