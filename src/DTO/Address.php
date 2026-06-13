<?php

declare(strict_types=1);

namespace Exel\ApiBundle\DTO;

final class Address
{
    private string $colonia;
    private string $codigoPostal;
    private string $calle;
    private string $numeroExterior;
    private ?string $numeroInterior;
    private string $referencias;
    private string $contactoNombre;
    private string $correo;
    private string $lada;
    private string $telefono;

    public function __construct()
    {
        $this->numeroInterior = null;
    }

    public function getColonia(): string
    {
        return $this->colonia;
    }

    public function setColonia(string $colonia): self
    {
        $this->colonia = $colonia;
        return $this;
    }

    public function getCodigoPostal(): string
    {
        return $this->codigoPostal;
    }

    public function setCodigoPostal(string $codigoPostal): self
    {
        $this->codigoPostal = $codigoPostal;
        return $this;
    }

    public function getCalle(): string
    {
        return $this->calle;
    }

    public function setCalle(string $calle): self
    {
        $this->calle = $calle;
        return $this;
    }

    public function getNumeroExterior(): string
    {
        return $this->numeroExterior;
    }

    public function setNumeroExterior(string $numeroExterior): self
    {
        $this->numeroExterior = $numeroExterior;
        return $this;
    }

    public function getNumeroInterior(): ?string
    {
        return $this->numeroInterior;
    }

    public function setNumeroInterior(?string $numeroInterior): self
    {
        $this->numeroInterior = $numeroInterior;
        return $this;
    }

    public function getReferencias(): string
    {
        return $this->referencias;
    }

    public function setReferencias(string $referencias): self
    {
        $this->referencias = $referencias;
        return $this;
    }

    public function getContactoNombre(): string
    {
        return $this->contactoNombre;
    }

    public function setContactoNombre(string $contactoNombre): self
    {
        $this->contactoNombre = $contactoNombre;
        return $this;
    }

    public function getCorreo(): string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): self
    {
        $this->correo = $correo;
        return $this;
    }

    public function getLada(): string
    {
        return $this->lada;
    }

    public function setLada(string $lada): self
    {
        $this->lada = $lada;
        return $this;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;
        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'colonia' => $this->colonia,
            'codigo_postal' => $this->codigoPostal,
            'calle' => $this->calle,
            'numero_exterior' => $this->numeroExterior,
            'referencias' => $this->referencias,
            'contacto_nombre' => $this->contactoNombre,
            'correo' => $this->correo,
            'lada' => $this->lada,
            'telefono' => $this->telefono,
        ];

        if ($this->numeroInterior !== null) {
            $data['numero_interior'] = $this->numeroInterior;
        }

        return $data;
    }
}
