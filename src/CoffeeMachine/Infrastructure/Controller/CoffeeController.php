<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Infrastructure\Controller;

use App\CoffeeMachine\Application\Command\OrderCoffeeCommand;
use App\CoffeeMachine\Domain\Entity\CoffeeSize;
use App\CoffeeMachine\Infrastructure\Exception\ValidationException;
use App\Shared\Infrastructure\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Routing\Attribute\Route;

class CoffeeController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus)
    {
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
}
