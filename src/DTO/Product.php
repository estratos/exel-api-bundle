<?php

declare(strict_types=1);

namespace Exel\ApiBundle\DTO;

final class Product
{
    private string $id;
    private string $referencia;
    private string $sku;
    private string $codigoBarras;
    private string $codigoSat;
    private string $nombre;
    private string $descripcionExtendida;
    private int $stock;
    private float $precio;
    private float $precioOferta;
    private float $precioSinOferta;
    private bool $oferta;
    private string $moneda;
    private string $marcaId;
    private string $marcaNombre;
    private string $familiaId;
    private string $familiaNombre;
    private string $subcategoriaId;
    private string $subcategoriaNombre;
    private string $categoriaId;
    private string $categoriaNombre;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->referencia = $data['referencia'];
        $this->sku = $data['sku'];
        $this->codigoBarras = $data['codigo_barras'];
        $this->codigoSat = $data['codigo_sat'];
        $this->nombre = $data['nombre'];
        $this->descripcionExtendida = $data['descripcion_extendida'] ?? '';
        $this->stock = (int) $data['stock'];
        $this->precio = (float) $data['precio'];
        $this->precioOferta = (float) $data['precio_oferta'];
        $this->precioSinOferta = (float) $data['precio_sin_oferta'];
        $this->oferta = (bool) $data['oferta'];
        $this->moneda = $data['moneda'];
        $this->marcaId = $data['marca_id'];
        $this->marcaNombre = $data['marca_nombre'];
        $this->familiaId = $data['familia_id'];
        $this->familiaNombre = $data['familia_nombre'];
        $this->subcategoriaId = $data['subcategoria_id'];
        $this->subcategoriaNombre = $data['subcategoria_nombre'];
        $this->categoriaId = $data['categoria_id'];
        $this->categoriaNombre = $data['categoria_nombre'];
    }

    public function getId(): string { return $this->id; }
    public function getReferencia(): string { return $this->referencia; }
    public function getSku(): string { return $this->sku; }
    public function getCodigoBarras(): string { return $this->codigoBarras; }
    public function getCodigoSat(): string { return $this->codigoSat; }
    public function getNombre(): string { return $this->nombre; }
    public function getDescripcionExtendida(): string { return $this->descripcionExtendida; }
    public function getStock(): int { return $this->stock; }
    public function getPrecio(): float { return $this->precio; }
    public function getPrecioOferta(): float { return $this->precioOferta; }
    public function getPrecioSinOferta(): float { return $this->precioSinOferta; }
    public function isOferta(): bool { return $this->oferta; }
    public function getMoneda(): string { return $this->moneda; }
    public function getMarcaId(): string { return $this->marcaId; }
    public function getMarcaNombre(): string { return $this->marcaNombre; }
    public function getFamiliaId(): string { return $this->familiaId; }
    public function getFamiliaNombre(): string { return $this->familiaNombre; }
    public function getSubcategoriaId(): string { return $this->subcategoriaId; }
    public function getSubcategoriaNombre(): string { return $this->subcategoriaNombre; }
    public function getCategoriaId(): string { return $this->categoriaId; }
    public function getCategoriaNombre(): string { return $this->categoriaNombre; }
    public function getPrecioFinal(): float { return $this->oferta ? $this->precioOferta : $this->precio; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'referencia' => $this->referencia,
            'sku' => $this->sku,
            'codigo_barras' => $this->codigoBarras,
            'codigo_sat' => $this->codigoSat,
            'nombre' => $this->nombre,
            'descripcion_extendida' => $this->descripcionExtendida,
            'stock' => $this->stock,
            'precio' => $this->precio,
            'precio_oferta' => $this->precioOferta,
            'precio_sin_oferta' => $this->precioSinOferta,
            'oferta' => $this->oferta,
            'moneda' => $this->moneda,
            'marca_id' => $this->marcaId,
            'marca_nombre' => $this->marcaNombre,
            'familia_id' => $this->familiaId,
            'familia_nombre' => $this->familiaNombre,
            'subcategoria_id' => $this->subcategoriaId,
            'subcategoria_nombre' => $this->subcategoriaNombre,
            'categoria_id' => $this->categoriaId,
            'categoria_nombre' => $this->categoriaNombre,
        ];
    }
}
