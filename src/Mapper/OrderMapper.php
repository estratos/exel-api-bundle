<?php

declare(strict_types=1);

namespace Exel\ApiBundle\Mapper;

use Exel\ApiBundle\DTO\OrderResult;

final class OrderMapper
{
    public function mapCreateOrderResponse(array $responseData): OrderResult
    {
        return new OrderResult($responseData);
    }
}
