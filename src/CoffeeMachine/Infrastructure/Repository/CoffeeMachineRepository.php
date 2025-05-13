<?php

namespace App\CoffeeMachine\Infrastructure\Repository;

use App\CoffeeMachine\Domain\Entity\CoffeeMachine;
use App\CoffeeMachine\Domain\Repository\CoffeeMachineRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CoffeeMachine>
 */
class CoffeeMachineRepository extends ServiceEntityRepository implements CoffeeMachineRepositoryInterface
{
    private const int MACHINE_ID = 1;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoffeeMachine::class);
    }

    public function get(?int $id = null): CoffeeMachine
    {
        $id = $id ?? self::MACHINE_ID;

        return $this->find($id);
    }

    public function save(CoffeeMachine $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function refresh(CoffeeMachine $entity): void
    {
        $this->getEntityManager()->refresh($entity);
    }
}
