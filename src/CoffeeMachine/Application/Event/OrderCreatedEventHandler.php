<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Event;

class OrderCreatedEventHandler
{
    public function __invoke(OrderCreatedEvent $event): void
    {
    }
}
