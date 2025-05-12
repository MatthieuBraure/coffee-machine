<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Query;

use App\CoffeeMachine\Application\View\CoffeeMachineView;
use App\CoffeeMachine\Domain\Repository\CoffeeMachineRepositoryInterface;

class StatusQueryHandler
{
    public function __construct(private readonly CoffeeMachineRepositoryInterface $coffeeMachineRepository)
    {
    }

    public function __invoke(StatusQuery $query): CoffeeMachineView
    {
        $coffeeMachine = $this->coffeeMachineRepository->get();

        return new CoffeeMachineView(
            status: $coffeeMachine->getStatus()->value,
            updatedAt: $coffeeMachine->getUpdatedAt(),
        );
    }
}
