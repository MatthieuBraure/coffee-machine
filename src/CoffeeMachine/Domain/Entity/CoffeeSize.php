<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Domain\Entity;

enum CoffeeSize: string
{
    case REGULAR = 'regular';
    case RISTRETTO = 'ristretto';
    case EXPRESSO = 'expresso';
    case DOPIO = 'dopio';
    case LUNGO = 'lungo';
}
