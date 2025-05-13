<?php

namespace App\Shared\Infrastructure;

interface EventBusInterface
{
    public function dispatchEvent(object $event): void;
}
