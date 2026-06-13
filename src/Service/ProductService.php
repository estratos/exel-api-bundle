<?php

declare(strict_types=1);

namespace Exel\ApiBundle\Service;

use Exel\ApiBundle\Client\ExelApiClient;
use Exel\ApiBundle\DTO\Product;
use Exel\ApiBundle\DTO\ProductInventory;
use Exel\ApiBundle\Mapper\ProductMapper;

final class ProductService
{
    public function __construct(
        private ExelApiClient $client,
        private ProductMapper $mapper
    ) {
    }

    /**
     * @param array{
     *     sin_stock?: string,
     *     marca?: string,
     *     subcategoria?: string,
     *     categoria?: string,
     *     familia?: string
     * } $filters
     * @return Product[]
     */
    public function all(array $filters = []): array
    {
        $response = $this->client->get('/productos', $filters);
        return $this->mapper->mapArray($response);
    }

    public function getBySku(string $sku): ?Product
    {
        $response = $this->client->post('/productos_skus', ['skus' => [$sku]]);
        return $this->mapper->mapSingle($response);
    }

    /**
     * @param string[] $skus
     * @return Product[]
     */
    public function getBySkus(array $skus): array
    {
        $response = $this->client->post('/productos_skus', ['skus' => $skus]);
        return $this->mapper->mapArray($response);
    }

    /**
     * @param string[] $skus
     * @return ProductInventory[]
     */
    public function inventory(array $skus, bool $sinStock = false): array
    {
        $query = $sinStock ? ['sin_stock' => 'true'] : [];
        $response = $this->client->post('/productos_almacenes', ['skus' => $skus], $query);
        return $this->mapper->mapInventoryArray($response);
    }

    public function inventoryBySku(string $sku, bool $sinStock = false): ?ProductInventory
    {
        $query = $sinStock ? ['sin_stock' => 'true'] : [];
        $response = $this->client->post('/productos_almacenes', ['skus' => [$sku]], $query);
        return $this->mapper->mapInventorySingle($response);
    }

    /**
     * @param string[] $referencias
     * @return array<string, mixed>
     */
    public function technicalSheet(array $referencias): array
    {
        return $this->client->post('/productos_fichatecnica', ['referencias' => $referencias]);
    }

    public function images(string $referencia): array
    {
        return $this->client->get('/imagenes_unitario', ['referencia' => $referencia]);
    }
}
