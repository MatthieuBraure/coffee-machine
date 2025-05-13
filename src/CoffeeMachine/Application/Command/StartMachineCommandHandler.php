<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Command;

use App\CoffeeMachine\Application\Event\MachineStartedEvent;
use App\CoffeeMachine\Domain\Repository\CoffeeMachineRepositoryInterface;
use App\Shared\Infrastructure\EventBusInterface;

class StartMachineCommandHandler
{
    public function __construct(
        private readonly CoffeeMachineRepositoryInterface $coffeeMachineRepository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(StartMachineCommand $command): void
    {
        $machine = $this->coffeeMachineRepository->get();
        if (!$machine->isStopped()) {
            throw new \RuntimeException('Machine is not stopped');
        }

        $machine->start();
        $this->coffeeMachineRepository->save($machine);
        $this->eventBus->dispatchEvent(new MachineStartedEvent($machine->getId()));
    }
}
