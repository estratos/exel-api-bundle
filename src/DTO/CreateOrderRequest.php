<?php

declare(strict_types=1);

namespace Exel\ApiBundle\DTO;

final class CreateOrderRequest
{
    /** @var array<array{clave_producto: string, cantidad: int}> */
    private array $productos = [];
    private string $claveAlmacen;
    private ?bool $ordenConfirmada = null;
    private ?string $claveTransportista = null;
    private ?string $comentario = null;
    private ?string $numOrden = null;
    private Address $direccion;
    private ?ShippingInfo $envio = null;

    public function getClaveAlmacen(): string
    {
        return $this->claveAlmacen;
    }

    public function setClaveAlmacen(string $claveAlmacen): self
    {
        $this->claveAlmacen = $claveAlmacen;
        return $this;
    }

    public function isOrdenConfirmada(): ?bool
    {
        return $this->ordenConfirmada;
    }

    public function setOrdenConfirmada(?bool $ordenConfirmada): self
    {
        $this->ordenConfirmada = $ordenConfirmada;
        return $this;
    }

    public function getClaveTransportista(): ?string
    {
        return $this->claveTransportista;
    }

    public function setClaveTransportista(?string $claveTransportista): self
    {
        $this->claveTransportista = $claveTransportista;
        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(?string $comentario): self
    {
        $this->comentario = $comentario;
        return $this;
    }

    public function getNumOrden(): ?string
    {
        return $this->numOrden;
    }

    public function setNumOrden(?string $numOrden): self
    {
        $this->numOrden = $numOrden;
        return $this;
    }

    public function getDireccion(): Address
    {
        return $this->direccion;
    }

    public function setDireccion(Address $direccion): self
    {
        $this->direccion = $direccion;
        return $this;
    }

    public function getEnvio(): ?ShippingInfo
    {
        return $this->envio;
    }

    public function setEnvio(?ShippingInfo $envio): self
    {
        $this->envio = $envio;
        return $this;
    }

    /**
     * @return array<array{clave_producto: string, cantidad: int}>
     */
    public function getProductos(): array
    {
        return $this->productos;
    }

    public function addProducto(string $claveProducto, int $cantidad): self
    {
        $this->productos[] = [
            'clave_producto' => $claveProducto,
            'cantidad' => $cantidad,
        ];
        return $this;
    }

    public function setProductos(array $productos): self
    {
        $this->productos = $productos;
        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'clave_almacen' => $this->claveAlmacen,
            'direccion' => $this->direccion->toArray(),
            'productos' => $this->productos,
        ];

        if ($this->ordenConfirmada !== null) {
            $data['orden_confirmada'] = $this->ordenConfirmada;
        }

        if ($this->claveTransportista !== null) {
            $data['clave_transportista'] = $this->claveTransportista;
        }

        if ($this->comentario !== null) {
            $data['comentario'] = $this->comentario;
        }

        if ($this->numOrden !== null) {
            $data['num_orden'] = $this->numOrden;
        }

        if ($this->envio !== null) {
            $data['envio'] = $this->envio->toArray();
        }

        return $data;
    }
}
