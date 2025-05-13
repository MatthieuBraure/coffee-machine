<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\View;

use App\CoffeeMachine\Domain\Entity\CoffeeSize;
use App\CoffeeMachine\Domain\Entity\OrderStatus;

class OrderView
{
    public function __construct(
        public CoffeeSize $size,
        public int $intensity,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
        public OrderStatus $status,
    ) {
    }
}
