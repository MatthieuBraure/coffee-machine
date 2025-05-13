<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Domain\Entity;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case CANCELED = 'canceled';
    case DONE = 'done';
}
