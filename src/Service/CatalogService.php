<?php

declare(strict_types=1);

namespace Exel\ApiBundle\Service;

use Exel\ApiBundle\Client\ExelApiClient;
use Exel\ApiBundle\DTO\Brand;
use Exel\ApiBundle\DTO\Family;
use Exel\ApiBundle\DTO\Subcategory;
use Exel\ApiBundle\Mapper\CatalogMapper;

final class CatalogService
{
    public function __construct(
        private ExelApiClient $client,
        private CatalogMapper $mapper
    ) {
    }

    /**
     * @return Brand[]
     */
    public function brands(): array
    {
        $response = $this->client->get('/marcas');
        return $this->mapper->mapBrands($response);
    }

    /**
     * @return Family[]
     */
    public function families(): array
    {
        $response = $this->client->get('/familias');
        return $this->mapper->mapFamilies($response);
    }

    /**
     * @return Subcategory[]
     */
    public function subcategories(): array
    {
        $response = $this->client->get('/subcategorias');
        return $this->mapper->mapSubcategories($response);
    }
}