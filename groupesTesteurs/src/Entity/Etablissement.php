<?php

namespace App\Entity;
use App\Repository\EtablissementRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtablissementRepository::class)]
class Etablissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
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

    #[ORM\OneToMany(targetEntity: Enseignant::class, mappedBy: "etablissement")]
    private Collection $enseignants;

    public function getEnseignants(): Collection
    {
        return $this->enseignants;
    }

    public function setEnseignants(Collection $enseignants): void
    {
        $this->enseignants = $enseignants;
    }

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