<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Command;

use App\CoffeeMachine\Domain\Repository\CoffeeMachineRepositoryInterface;

class StopMachineCommandHandler
{
    public function __construct(private readonly CoffeeMachineRepositoryInterface $coffeeMachineRepository)
    {
    }

    public function __invoke(StopMachineCommand $command): void
    {
        $machine = $this->coffeeMachineRepository->get();

        $machine->stop();
        $this->coffeeMachineRepository->save($machine);
    }
}
