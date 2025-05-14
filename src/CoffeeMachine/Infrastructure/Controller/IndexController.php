<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Infrastructure\Controller;

use App\CoffeeMachine\Application\Query\StatusQuery;
use App\CoffeeMachine\Domain\Entity\CoffeeSize;
use App\Shared\Infrastructure\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    public function __construct(private readonly QueryBusInterface $queryBus)
    {
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $machine = $this->queryBus->handle(new StatusQuery());

        return $this->render('index.html.twig', [
            'machine' => $machine,
            'coffeeSizes' => CoffeeSize::cases(),
        ]);
    }
}
