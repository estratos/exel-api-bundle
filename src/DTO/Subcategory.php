<?php

declare(strict_types=1);

namespace Exel\ApiBundle\DTO;

final class Subcategory
{
    public function __construct(
        private string $id,
        private string $nombre,
        private ?string $categoriaId = null,
        private ?string $categoriaNombre = null
    ) {
    }

    public function getId(): string { return $this->id; }
    public function getNombre(): string { return $this->nombre; }
    public function getCategoriaId(): ?string { return $this->categoriaId; }
    public function getCategoriaNombre(): ?string { return $this->categoriaNombre; }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'nombre' => $this->nombre,
            'categoria_id' => $this->categoriaId,
            'categoria_nombre' => $this->categoriaNombre,
        ]);
    }
}
