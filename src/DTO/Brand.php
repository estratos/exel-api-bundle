<?php

declare(strict_types=1);

namespace Exel\ApiBundle\DTO;

final class Brand
{
    public function __construct(
        private string $id,
        private string $nombre
    ) {
    }

    public function getId(): string { return $this->id; }
    public function getNombre(): string { return $this->nombre; }

    public function toArray(): array
    {
        return ['id' => $this->id, 'nombre' => $this->nombre];
    }
}
