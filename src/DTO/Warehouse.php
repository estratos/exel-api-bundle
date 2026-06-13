<?php

declare(strict_types=1);

namespace Exel\ApiBundle\DTO;

final class Warehouse
{
    public function __construct(
        private int $stock,
        private string $almacen,
        private string $almacenClave
    ) {
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getAlmacen(): string
    {
        return $this->almacen;
    }

    public function getAlmacenClave(): string
    {
        return $this->almacenClave;
    }

    public function hasStock(): bool
    {
        return $this->stock > 0;
    }

    public function toArray(): array
    {
        return [
            'stock' => $this->stock,
            'almacen' => $this->almacen,
            'almacen_clave' => $this->almacenClave,
        ];
    }
}
