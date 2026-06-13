<?php

declare(strict_types=1);

namespace Exel\ApiBundle\Exception;

class ApiException extends \Exception
{
    private ?int $statusCode;
    private ?array $responseData;

    public function __construct(
        string $message = '',
        ?int $statusCode = null,
        ?array $responseData = null,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $statusCode ?? 0, $previous);
        $this->statusCode = $statusCode;
        $this->responseData = $responseData;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function getResponseData(): ?array
    {
        return $this->responseData;
    }
}
