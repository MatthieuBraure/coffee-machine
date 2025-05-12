<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyMessengerBus implements CommandBusInterface, QueryBusInterface
{
    use HandleTrait {
        handle as doHandle;
    }

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function handle(object $query): mixed
    {
        try {
            return $this->doHandle($query);
        } catch (HandlerFailedException $exception) {
            $previous = $exception->getPrevious();

            if (null === $previous) {
                throw $exception;
            }

            throw $previous;
        }
    }

    public function getMessageBus(): MessageBusInterface
    {
        return $this->messageBus;
    }
}
