<?php

namespace App\CoffeeMachine\Domain\Repository;

use App\CoffeeMachine\Domain\Entity\Order;

interface OrderRepositoryInterface
{
    public function save(Order $entity): void;
}
