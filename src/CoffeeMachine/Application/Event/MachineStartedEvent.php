<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Event;

class MachineStartedEvent
{
    public function __construct(public int $machineId)
    {
    }
}
