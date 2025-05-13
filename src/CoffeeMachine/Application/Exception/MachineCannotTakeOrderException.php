<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Application\Exception;

class MachineCannotTakeOrderException extends \LogicException
{
    final public const DEFAULT_MESSAGE = 'Machine cannot take order';
    final public const CODE = 403;

    public function __construct(
        string $message = self::DEFAULT_MESSAGE,
        int $code = self::CODE,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
