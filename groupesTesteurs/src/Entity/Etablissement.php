<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

class Etablissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $uai = null;

    #[ORM\Column(length: 255)]
    private ?string $etablissementName = null;

    #[ORM\Column(length: 255)]
    private ?string $etablissementType = null;

    #[ORM\Column(type: "text")]
    private ?string $etablissementAdress = null;

    #[ORM\Column(type: "integer")]
    private ?int $etablissementDepartement = null;

    #[ORM\Column(type: "integer")]
    private ?int $etablissementCodePostal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUai(): ?string
    {
        return $this->uai;
    }

    public function setUai(?string $uai): void
    {
        $this->uai = $uai;
    }

    public function getEtablissementName(): ?string
    {
        return $this->etablissementName;
    }

    public function setEtablissementName(?string $etablissementName): void
    {
        $this->etablissementName = $etablissementName;
    }

    public function getEtablissementType(): ?string
    {
        return $this->etablissementType;
    }

    public function setEtablissementType(?string $etablissementType): void
    {
        $this->etablissementType = $etablissementType;
    }

    public function getEtablissementAdress(): ?string
    {
        return $this->etablissementAdress;
    }

    public function setEtablissementAdress(?string $etablissementAdress): void
    {
        $this->etablissementAdress = $etablissementAdress;
    }

    public function getEtablissementDepartement(): ?int
    {
        return $this->etablissementDepartement;
    }

    public function setEtablissementDepartement(?int $etablissementDepartement): void
    {
        $this->etablissementDepartement = $etablissementDepartement;
    }

    public function getEtablissementCodePostal(): ?int
    {
        return $this->etablissementCodePostal;
    }

    public function setEtablissementCodePostal(?int $etablissementCodePostal): void
    {
        $this->etablissementCodePostal = $etablissementCodePostal;
    }

}