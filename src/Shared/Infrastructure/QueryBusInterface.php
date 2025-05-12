<?php

namespace App\Shared\Infrastructure;

interface QueryBusInterface
{
    public function handle(object $query): mixed;
}
