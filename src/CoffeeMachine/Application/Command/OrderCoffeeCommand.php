<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Command;

use App\CoffeeMachine\Domain\Entity\CoffeeSize;
use Symfony\Component\Validator\Constraints as Assert;

class OrderCoffeeCommand
{
    public CoffeeSize $size;
    #[Assert\Range(min: 1, max: 10)]
    public int $intensity;
}
