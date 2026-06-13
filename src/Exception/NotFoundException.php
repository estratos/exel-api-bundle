<?php

declare(strict_types=1);

namespace Exel\ApiBundle\Exception;

final class NotFoundException extends ApiException
{
    public function __construct(string $resource, string $identifier, ?\Throwable $previous = null)
    {
        parent::__construct(
            sprintf('%s with identifier "%s" not found', $resource, $identifier),
            404,
            null,
            $previous
        );
    }
}
