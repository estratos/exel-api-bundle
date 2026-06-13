<?php

declare(strict_types=1);

namespace Exel\ApiBundle\DTO;

final class OrderResult
{
    private string $numeroOrden;
    private string $estatus;
    private string $total;
    private int $correcto;
    private string $envio;

    public function __construct(array $data)
    {
        $resultado = $data['resultado'] ?? [];
        $this->numeroOrden = $resultado['Numero_Orden'] ?? '';
        $this->estatus = $resultado['Estatus'] ?? '';
        $this->total = $resultado['Total'] ?? '0';
        $this->correcto = (int) ($resultado['correcto'] ?? 0);
        $this->envio = $resultado['envio'] ?? '';
    }

    public function getNumeroOrden(): string
    {
        return $this->numeroOrden;
    }

    public function getEstatus(): string
    {
        return $this->estatus;
    }

    public function getTotal(): string
    {
        return $this->total;
    }

    public function getTotalFloat(): float
    {
        return (float) $this->total;
    }

    public function isCorrecto(): bool
    {
        return $this->correcto === 1;
    }

    public function getEnvio(): string
    {
        return $this->envio;
    }

    public function toArray(): array
    {
        return [
            'numero_orden' => $this->numeroOrden,
            'estatus' => $this->estatus,
            'total' => $this->total,
            'correcto' => $this->correcto,
            'envio' => $this->envio,
        ];
    }
}
