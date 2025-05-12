<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Domain\Entity;

enum CoffeeMachineStatus: string
{
    case OFF = 'off';
    case STARTING = 'starting';
    case READY = 'ready';
    case RUNNING = 'running';
    case SHUTDOWN = 'shutdown';
}
