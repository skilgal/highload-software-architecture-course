<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;
use Throwable;

final class ValidationException extends RuntimeException
{
    /**
     * @var array
     */
    private array $errors;

    /**
     * The constructor.
     *
     * @param array $errors The errors
     * @param string $message The error message
     * @param int $code The error code
     * @param Throwable|null $previous The previous exception
     */
    public function __construct(string $message, array $errors = [], int $code = 422, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }

    /**
     * Get error details.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
