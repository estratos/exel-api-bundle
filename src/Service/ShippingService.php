<?php

declare(strict_types=1);

namespace Exel\ApiBundle\Service;

use Exel\ApiBundle\Client\ExelApiClient;

final class ShippingService
{
    public function __construct(
        private ExelApiClient $client
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function quote(array $data): array
    {
        return $this->client->post('/fletes_y_transportistas', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function registerGuide(array $data): array
    {
        return $this->client->post('/guia', $data);
    }
}