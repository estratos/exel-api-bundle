<?php

declare(strict_types=1);

namespace Exel\ApiBundle\Mapper;

use Exel\ApiBundle\DTO\Product;
use Exel\ApiBundle\DTO\ProductInventory;

final class ProductMapper
{
    /**
     * @return Product[]
     */
    public function mapArray(array $responseData): array
    {
        $products = [];

        if (!isset($responseData['resultado']) || $responseData['resultado'] !== true) {
            return $products;
        }

        $datos = $responseData['datos'] ?? [];

        foreach ($datos as $item) {
            $products[] = new Product($item);
        }

        return $products;
    }

    public function mapSingle(array $responseData): ?Product
    {
        if (!isset($responseData['resultado']) || $responseData['resultado'] !== true) {
            return null;
        }

        $datos = $responseData['datos'] ?? [];

        if (empty($datos)) {
            return null;
        }

        return new Product($datos[0]);
    }

    /**
     * @return ProductInventory[]
     */
    public function mapInventoryArray(array $responseData): array
    {
        $inventory = [];

        if (!isset($responseData['resultado']) || $responseData['resultado'] !== true) {
            return $inventory;
        }

        $datos = $responseData['datos'] ?? [];

        foreach ($datos as $item) {
            $inventory[] = new ProductInventory($item);
        }

        return $inventory;
    }

    public function mapInventorySingle(array $responseData): ?ProductInventory
    {
        if (!isset($responseData['resultado']) || $responseData['resultado'] !== true) {
            return null;
        }

        $datos = $responseData['datos'] ?? [];

        if (empty($datos)) {
            return null;
        }

        return new ProductInventory($datos[0]);
    }
}
