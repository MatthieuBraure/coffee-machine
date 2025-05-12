<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Event;

use App\CoffeeMachine\Domain\Repository\CoffeeMachineRepositoryInterface;

class MachineStoppedEventHandler
{
    private const int SHUTDOWN_TIME = 5;

    public function __construct(private readonly CoffeeMachineRepositoryInterface $coffeeMachineRepository)
    {
    }

    public function __invoke(MachineStoppedEvent $event): void
    {
        $machine = $this->coffeeMachineRepository->get($event->machineId);
        sleep(self::SHUTDOWN_TIME);
        $machine->stop();
        $this->coffeeMachineRepository->save($machine);
    }
}
