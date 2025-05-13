<?php

namespace App\CoffeeMachine\Domain\Entity;

use App\CoffeeMachine\Infrastructure\Repository\CoffeeMachineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoffeeMachineRepository::class)]
class CoffeeMachine
{
    private const int STEP_PREPARATION_TIME = 5;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private CoffeeMachineStatus $status;

    #[ORM\Column]
    private \DateTimeImmutable $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): CoffeeMachineStatus
    {
        return $this->status;
    }

    public function setStatus(CoffeeMachineStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function start(): void
    {
        $this->status = CoffeeMachineStatus::STARTING;
        $this->updatedAt = new \DateTimeImmutable('now');
    }

    public function ready(): void
    {
        $this->status = CoffeeMachineStatus::READY;
        $this->updatedAt = new \DateTimeImmutable('now');
    }

    public function shutdown(): void
    {
        $this->status = CoffeeMachineStatus::SHUTDOWN;
        $this->updatedAt = new \DateTimeImmutable('now');
    }

    public function stop(): void
    {
        $this->status = CoffeeMachineStatus::OFF;
        $this->updatedAt = new \DateTimeImmutable('now');
    }

    public function isStarted(): bool
    {
        return $this->status->value === CoffeeMachineStatus::READY->value;
    }

    public function isStopped(): bool
    {
        return $this->status->value === CoffeeMachineStatus::OFF->value;
    }

    public function canTakeOrder(): bool
    {
        return $this->status->value === CoffeeMachineStatus::READY->value
            || $this->status->value === CoffeeMachineStatus::RUNNING->value;
    }

    public function startCoffee(): void
    {
        $this->status = CoffeeMachineStatus::RUNNING;
        $this->updatedAt = new \DateTimeImmutable('now');
    }

    public function finishCoffee(): void
    {
        $this->status = CoffeeMachineStatus::READY;
        $this->updatedAt = new \DateTimeImmutable('now');
    }

    public function isUp(): bool
    {
        return $this->status->value === CoffeeMachineStatus::READY->value
            || $this->status->value === CoffeeMachineStatus::RUNNING->value;
    }

    public function getStepPreparationTime(): int
    {
        return self::STEP_PREPARATION_TIME;
    }
}
