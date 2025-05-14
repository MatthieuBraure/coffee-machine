<?php

namespace App\CoffeeMachine\Infrastructure\Repository;

use App\CoffeeMachine\Domain\Entity\Order;
use App\CoffeeMachine\Domain\Entity\OrderStatus;
use App\CoffeeMachine\Domain\Repository\OrderRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 */
class OrderRepository extends ServiceEntityRepository implements OrderRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function get(int $id): ?Order
    {
        return $this->find($id);
    }

    public function save(Order $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function getPending(): array
    {
        return $this->createQueryBuilder('o')
            ->where('o.status = :status')
            ->setParameter('status', OrderStatus::PENDING)
            ->orderBy('o.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getCompleted(): array
    {
        return $this->createQueryBuilder('o')
            ->where('o.status = :status')
            ->setParameter('status', OrderStatus::DONE)
            ->orderBy('o.updatedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getProcessing(): ?Order
    {
        return $this->createQueryBuilder('o')
            ->where('o.status = :status')
            ->setParameter('status', OrderStatus::PROCESSING)
            ->orderBy('o.updatedAt', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function refresh(Order $entity): void
    {
        $this->getEntityManager()->refresh($entity);
    }
}
