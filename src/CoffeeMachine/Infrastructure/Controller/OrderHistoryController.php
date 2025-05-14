<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Infrastructure\Controller;

use App\CoffeeMachine\Application\Query\CompletedOrderQuery;
use App\CoffeeMachine\Application\View\OrderView;
use App\Shared\Infrastructure\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderHistoryController extends AbstractController
{
    public function __construct(private readonly QueryBusInterface $queryBus)
    {
    }

    #[Route('/order/history', name: 'order_history')]
    public function index(): Response
    {
        $orders = $this->queryBus->handle(new CompletedOrderQuery());

        $ordersByDay = [];
        /** @var OrderView $order */
        foreach ($orders as $order) {
            $day = $order->updatedAt->format('d-m-Y');
            if (!isset($ordersByDay[$day])) {
                $ordersByDay[$day] = [];
            }
            $ordersByDay[$day][] = $order;
        }

        return $this->render('order_history.html.twig', [
            'ordersByDay' => $ordersByDay,
        ]);
    }
}
