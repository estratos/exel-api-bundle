<?php

declare(strict_types=1);

namespace Exel\ApiBundle\DTO;

final class ShippingInfo
{
    private ?string $guia = null;
    private ?string $base64Pdf = null;
    private ?string $formato = null;

    public function getGuia(): ?string
    {
        return $this->guia;
    }

    public function setGuia(?string $guia): self
    {
        $this->guia = $guia;
        return $this;
    }

    public function getBase64Pdf(): ?string
    {
        return $this->base64Pdf;
    }

    public function setBase64Pdf(?string $base64Pdf): self
    {
        $this->base64Pdf = $base64Pdf;
        return $this;
    }

    public function getFormato(): ?string
    {
        return $this->formato;
    }

    public function setFormato(?string $formato): self
    {
        $this->formato = $formato;
        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'guia' => $this->guia,
            'base64pdf' => $this->base64Pdf,
            'formato' => $this->formato,
        ]);
    }
}
