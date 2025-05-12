<?php

declare(strict_types=1);

namespace App\CoffeeMachine\Infrastructure\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends \RuntimeException implements \Throwable
{
    public function __construct(private ConstraintViolationListInterface $constraintViolationList, string $message = '', int $code = 0, ?\Exception $previous = null)
    {
        parent::__construct($message ?: $this->__toString(), $code, $previous);
    }

    public function __toString(): string
    {
        $message = '';
        foreach ($this->constraintViolationList as $violation) {
            if ('' !== $message) {
                $message .= "\n";
            }
            if ($propertyPath = $violation->getPropertyPath()) {
                $message .= "$propertyPath: ";
            }

            $message .= $violation->getMessage();
        }

        return $message;
    }
}
