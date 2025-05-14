<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Command;

use App\CoffeeMachine\Domain\Repository\OrderRepositoryInterface;

class CancelCoffeeCommandHandler
{
    public function __construct(private readonly OrderRepositoryInterface $orderRepository)
    {
    }

    public function __invoke(CancelCoffeeCommand $command): void
    {
        $coffee = $this->orderRepository->get($command->orderId);
        if (null !== $coffee) {
            $coffee->cancel();
            $this->orderRepository->save($coffee);
        }
    }
}
