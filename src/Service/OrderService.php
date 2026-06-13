<?php

declare(strict_types=1);

namespace Exel\ApiBundle\Service;

use Exel\ApiBundle\Client\ExelApiClient;
use Exel\ApiBundle\DTO\CreateOrderRequest;
use Exel\ApiBundle\DTO\OrderResult;
use Exel\ApiBundle\Mapper\OrderMapper;

final class OrderService
{
    public function __construct(
        private ExelApiClient $client,
        private OrderMapper $mapper
    ) {
    }

    /**
     * @param array<string, mixed>|CreateOrderRequest $pedido
     */
    public function create(array|CreateOrderRequest $pedido): OrderResult
    {
        $data = $pedido instanceof CreateOrderRequest ? $pedido->toArray() : $pedido;
        $response = $this->client->post('/creacion_pedido', $data);
        return $this->mapper->mapCreateOrderResponse($response);
    }

    /**
     * @return array<string, mixed>
     */
    public function get(string $numeroOrden): array
    {
        return $this->client->get('/mostrar_orden', ['num_orden' => $numeroOrden]);
    }

    /**
     * @return array<string, mixed>
     */
    public function confirm(string $numeroOrden): array
    {
        return $this->client->get('/confirma_preorden', ['num_orden' => $numeroOrden]);
    }
}
