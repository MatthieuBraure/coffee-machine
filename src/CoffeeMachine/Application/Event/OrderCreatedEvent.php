<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Event;

class OrderCreatedEvent
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
