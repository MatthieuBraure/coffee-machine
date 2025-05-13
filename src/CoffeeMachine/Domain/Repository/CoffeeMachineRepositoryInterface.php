<?php

namespace App\CoffeeMachine\Domain\Repository;

use App\CoffeeMachine\Domain\Entity\CoffeeMachine;

interface CoffeeMachineRepositoryInterface
{
    public function get(?int $id = null): CoffeeMachine;

    public function save(CoffeeMachine $entity): void;

    public function refresh(CoffeeMachine $entity): void;
}
