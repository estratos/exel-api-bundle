<?php

declare(strict_types=1);

namespace Exel\ApiBundle\DTO;

final class ProductInventory
{
    private string $id;
    private string $referencia;
    private string $sku;
    private string $nombre;
    private int $stockTotal;
    private ?float $precio;
    private ?float $precioOferta;
    private ?float $precioSinOferta;
    private bool $oferta;
    private string $moneda;
    private string $marcaId;
    private string $marcaNombre;
    private string $subcategoriaId;
    private string $subcategoriaNombre;
    /** @var Warehouse[] */
    private array $almacenes;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->referencia = $data['referencia'];
        $this->sku = $data['sku'];
        $this->nombre = $data['nombre'];
        $this->stockTotal = (int) $data['stock'];
        $this->precio = isset($data['precio']) ? (float) $data['precio'] : null;
        $this->precioOferta = isset($data['precio_oferta']) ? (float) $data['precio_oferta'] : null;
        $this->precioSinOferta = isset($data['precio_sin_oferta']) ? (float) $data['precio_sin_oferta'] : null;
        $this->oferta = (bool) ($data['oferta'] ?? false);
        $this->moneda = $data['moneda'] ?? 'MXN';
        $this->marcaId = $data['marca_id'];
        $this->marcaNombre = $data['marca_nombre'];
        $this->subcategoriaId = $data['subcategoria_id'];
        $this->subcategoriaNombre = $data['subcategoria_nombre'];
        
        $this->almacenes = [];
        foreach ($data['almacenes'] ?? [] as $warehouse) {
            $this->almacenes[] = new Warehouse(
                $warehouse['stock'],
                $warehouse['almacen'],
                $warehouse['almacen_clave']
            );
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getReferencia(): string
    {
        return $this->referencia;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getStockTotal(): int
    {
        return $this->stockTotal;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function getPrecioOferta(): ?float
    {
        return $this->precioOferta;
    }

    public function getPrecioSinOferta(): ?float
    {
        return $this->precioSinOferta;
    }

    public function isOferta(): bool
    {
        return $this->oferta;
    }

    public function getMoneda(): string
    {
        return $this->moneda;
    }

    public function getMarcaId(): string
    {
        return $this->marcaId;
    }

    public function getMarcaNombre(): string
    {
        return $this->marcaNombre;
    }

    public function getSubcategoriaId(): string
    {
        return $this->subcategoriaId;
    }

    public function getSubcategoriaNombre(): string
    {
        return $this->subcategoriaNombre;
    }

    /**
     * @return Warehouse[]
     */
    public function getAlmacenes(): array
    {
        return $this->almacenes;
    }

    /**
     * @return Warehouse[]
     */
    public function getWarehousesWithStock(): array
    {
        return array_filter($this->almacenes, fn(Warehouse $w) => $w->hasStock());
    }

    public function getStockByWarehouse(string $warehouseKey): int
    {
        foreach ($this->almacenes as $warehouse) {
            if ($warehouse->getAlmacenClave() === $warehouseKey) {
                return $warehouse->getStock();
            }
        }
        return 0;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'referencia' => $this->referencia,
            'sku' => $this->sku,
            'nombre' => $this->nombre,
            'stock' => $this->stockTotal,
            'precio' => $this->precio,
            'precio_oferta' => $this->precioOferta,
            'precio_sin_oferta' => $this->precioSinOferta,
            'oferta' => $this->oferta,
            'moneda' => $this->moneda,
            'marca_id' => $this->marcaId,
            'marca_nombre' => $this->marcaNombre,
            'subcategoria_id' => $this->subcategoriaId,
            'subcategoria_nombre' => $this->subcategoriaNombre,
            'almacenes' => array_map(fn(Warehouse $w) => $w->toArray(), $this->almacenes),
        ];
    }
}
