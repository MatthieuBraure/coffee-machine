<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\View;

class CoffeeMachineView
{
    public function __construct(public string $status, public \DateTimeImmutable $updatedAt)
    {
    }
}
