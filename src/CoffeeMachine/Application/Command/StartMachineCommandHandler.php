<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Command;

use App\CoffeeMachine\Domain\Repository\CoffeeMachineRepositoryInterface;

class StartMachineCommandHandler
{
    public function __construct(private readonly CoffeeMachineRepositoryInterface $coffeeMachineRepository)
    {
    }

    public function __invoke(StartMachineCommand $command): void
    {
        $machine = $this->coffeeMachineRepository->get();
        if (!$machine->isStopped()) {
            throw new \RuntimeException('Machine is not started');
        }

        $machine->start();
        $this->coffeeMachineRepository->save($machine);
    }
}
