<?php

declare(strict_types=1);

namespace Exel\ApiBundle\Mapper;

use Exel\ApiBundle\DTO\Brand;
use Exel\ApiBundle\DTO\Family;
use Exel\ApiBundle\DTO\Subcategory;

final class CatalogMapper
{
    /**
     * @return Brand[]
     */
    public function mapBrands(array $responseData): array
    {
        $brands = [];

        if (!isset($responseData['resultado']) || $responseData['resultado'] !== true) {
            return $brands;
        }

        $datos = $responseData['datos'] ?? [];

        foreach ($datos as $item) {
            $brands[] = new Brand(
                $item['id'] ?? $item['marca_id'] ?? '',
                $item['nombre'] ?? $item['marca_nombre'] ?? ''
            );
        }

        return $brands;
    }

    /**
     * @return Family[]
     */
    public function mapFamilies(array $responseData): array
    {
        $families = [];

        if (!isset($responseData['resultado']) || $responseData['resultado'] !== true) {
            return $families;
        }

        $datos = $responseData['datos'] ?? [];

        foreach ($datos as $item) {
            $families[] = new Family(
                $item['id'] ?? $item['familia_id'] ?? '',
                $item['nombre'] ?? $item['familia_nombre'] ?? ''
            );
        }

        return $families;
    }

    /**
     * @return Subcategory[]
     */
    public function mapSubcategories(array $responseData): array
    {
        $subcategories = [];

        if (!isset($responseData['resultado']) || $responseData['resultado'] !== true) {
            return $subcategories;
        }

        $datos = $responseData['datos'] ?? [];

        foreach ($datos as $item) {
            $subcategories[] = new Subcategory(
                $item['id'] ?? $item['subcategoria_id'] ?? '',
                $item['nombre'] ?? $item['subcategoria_nombre'] ?? '',
                $item['categoria_id'] ?? null,
                $item['categoria_nombre'] ?? null
            );
        }

        return $subcategories;
    }
}