
<?php

declare(strict_types=1);

namespace Exel\ApiBundle\Exception;

final class ValidationException extends ApiException
{
    private array $errors;

    public function __construct(string $message = 'Validation failed', array $errors = [], ?\Throwable $previous = null)
    {
        parent::__construct($message, 422, null, $previous);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}