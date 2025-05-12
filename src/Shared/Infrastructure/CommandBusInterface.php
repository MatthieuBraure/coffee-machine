<?php

namespace App\Shared\Infrastructure;

interface CommandBusInterface
{
    public function handle(object $query): mixed;

    public function dispatchEvent(object $event): void;
}
