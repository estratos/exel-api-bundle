<?php

declare(strict_types=1);

namespace Exel\ApiBundle;

use Exel\ApiBundle\Service\CatalogService;
use Exel\ApiBundle\Service\OrderService;
use Exel\ApiBundle\Service\ProductService;
use Exel\ApiBundle\Service\ShippingService;

final class ExelApi
{
    public function __construct(
        private ProductService $productService,
        private CatalogService $catalogService,
        private OrderService $orderService,
        private ShippingService $shippingService
    ) {
    }

    public function products(): ProductService
    {
        return $this->productService;
    }

    public function catalogs(): CatalogService
    {
        return $this->catalogService;
    }

    public function orders(): OrderService
    {
        return $this->orderService;
    }

    public function shipping(): ShippingService
    {
        return $this->shippingService;
    }
}
