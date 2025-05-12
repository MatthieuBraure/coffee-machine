<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Infrastructure\Controller;

use App\CoffeeMachine\Application\Command\StartMachineCommand;
use App\CoffeeMachine\Application\Command\StopMachineCommand;
use App\CoffeeMachine\Application\Query\StatusQuery;
use App\CoffeeMachine\Infrastructure\Exception\ValidationException;
use App\Shared\Infrastructure\CommandBusInterface;
use App\Shared\Infrastructure\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Routing\Attribute\Route;

class CoffeeMachineController extends AbstractController
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly CommandBusInterface $commandBus)
    {
    }

    #[Route('/api/coffee-machine/status', name: 'api_coffee_machine')]
    public function status(): Response
    {
        return new JsonResponse($this->queryBus->handle(new StatusQuery()));
    }

    #[Route('/api/coffee-machine/start', name: 'api_coffee_machine_start', methods: ['POST'])]
    public function start(): Response
    {
        try {
            $this->commandBus->handle(new StartMachineCommand());

            return new JsonResponse(['status' => 'ok']);
        } catch (ValidationFailedException $exception) {
            throw new ValidationException($exception->getViolations());
        }
    }

    #[Route('/api/coffee-machine/stop', name: 'api_coffee_machine_stop', methods: ['POST'])]
    public function stop(): Response
    {
        try {
            $this->commandBus->handle(new StopMachineCommand());

            return new JsonResponse(['status' => 'ok']);
        } catch (ValidationFailedException $exception) {
            throw new ValidationException($exception->getViolations());
        }
    }
}
