<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Infrastructure\Controller;

use App\CoffeeMachine\Application\Command\OrderCoffeeCommand;
use App\CoffeeMachine\Application\Query\CompletedOrderQuery;
use App\CoffeeMachine\Application\Query\PendingOrderQuery;
use App\CoffeeMachine\Application\Query\ProcessingOrderQuery;
use App\CoffeeMachine\Domain\Entity\CoffeeSize;
use App\CoffeeMachine\Infrastructure\Exception\ValidationException;
use App\Shared\Infrastructure\CommandBusInterface;
use App\Shared\Infrastructure\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Routing\Attribute\Route;

class CoffeeController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    #[Route('/api/coffee/order', name: 'api_coffee_order', methods: ['PUT'])]
    public function stop(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent(), true);
            $command = new OrderCoffeeCommand();
            $command->size = CoffeeSize::from($data['size']);
            $command->intensity = $data['intensity'];

            $this->commandBus->handle($command);

            return new JsonResponse(['message' => 'ok'], Response::HTTP_CREATED);
        } catch (ValidationFailedException $exception) {
            throw new ValidationException($exception->getViolations());
        }
    }

    #[Route('/api/coffee/pending', name: 'api_coffee_pending', methods: ['GET'])]
    public function pending(): Response
    {
        return new JsonResponse($this->queryBus->handle(new PendingOrderQuery()));
    }

    #[Route('/api/coffee/completed', name: 'api_coffee_completed', methods: ['GET'])]
    public function complete(): Response
    {
        return new JsonResponse($this->queryBus->handle(new CompletedOrderQuery()));
    }

    #[Route('/api/coffee/processing', name: 'api_coffee_processing', methods: ['GET'])]
    public function processing(): Response
    {
        return new JsonResponse($this->queryBus->handle(new ProcessingOrderQuery()));
    }
}
