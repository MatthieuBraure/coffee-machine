<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

class SymfonyMessengerBus implements CommandBusInterface, QueryBusInterface, EventBusInterface
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

    public function dispatchEvent(object $event): void
    {
        $envelope = Envelope::wrap($event, [
            // See https://symfony.com/doc/current/messenger/message-recorder.html
            new DispatchAfterCurrentBusStamp(),
        ]);

        $this->messageBus->dispatch($envelope);
    }

    public function getMessageBus(): MessageBusInterface
    {
        return $this->messageBus;
    }
}
