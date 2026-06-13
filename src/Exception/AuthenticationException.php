<?php

declare(strict_types=1);

namespace Exel\ApiBundle\Exception;

final class AuthenticationException extends ApiException
{
    public function __construct(string $message = 'Authentication failed', ?\Throwable $previous = null)
    {
        parent::__construct($message, 401, null, $previous);
    }
}
