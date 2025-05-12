<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Command;

use App\CoffeeMachine\Application\Event\MachineStoppedEvent;
use App\CoffeeMachine\Domain\Repository\CoffeeMachineRepositoryInterface;
use App\Shared\Infrastructure\CommandBusInterface;

class StopMachineCommandHandler
{
    public function __construct(
        private readonly CoffeeMachineRepositoryInterface $coffeeMachineRepository,
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    public function __invoke(StopMachineCommand $command): void
    {
        $machine = $this->coffeeMachineRepository->get();

        $machine->shutdown();
        $this->coffeeMachineRepository->save($machine);

        $this->commandBus->dispatchEvent(new MachineStoppedEvent($machine->getId()));
    }
}
