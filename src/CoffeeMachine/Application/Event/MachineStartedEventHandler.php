<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Event;

use App\CoffeeMachine\Domain\Repository\CoffeeMachineRepositoryInterface;

class MachineStartedEventHandler
{
    private const int STARTUP_TIME = 10;

    public function __construct(private readonly CoffeeMachineRepositoryInterface $coffeeMachineRepository)
    {
    }

    public function __invoke(MachineStartedEvent $event): void
    {
        $machine = $this->coffeeMachineRepository->get($event->machineId);
        sleep(self::STARTUP_TIME);
        $machine->ready();
        $this->coffeeMachineRepository->save($machine);
    }
}
