<?php

namespace App\CoffeeMachine\Domain\Repository;

use App\CoffeeMachine\Domain\Entity\CoffeeMachine;

interface CoffeeMachineRepositoryInterface
{
    public function get(): CoffeeMachine;

    public function save(CoffeeMachine $entity): void;
}
