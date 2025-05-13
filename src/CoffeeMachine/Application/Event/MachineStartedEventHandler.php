<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Event;

use App\CoffeeMachine\Domain\Repository\CoffeeMachineRepositoryInterface;
use App\Shared\Infrastructure\EventBusInterface;

class MachineStartedEventHandler
{
    private const int STARTUP_TIME = 10;

    public function __construct(
        private readonly CoffeeMachineRepositoryInterface $coffeeMachineRepository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(MachineStartedEvent $event): void
    {
        $machine = $this->coffeeMachineRepository->get($event->machineId);
        sleep(self::STARTUP_TIME);
        $machine->ready();
        $this->coffeeMachineRepository->save($machine);
        $this->eventBus->dispatchEvent(new MachineReadyEvent());
    }
}
