<?php

namespace App\Entity;

use App\Repository\GroupeTesteursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


use DateTime;

#[ORM\Entity(repositoryClass: GroupeTesteursRepository::class)]
class GroupeTesteurs
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $groupTesteurLabel = null;

    #[ORM\Column(type: "text")]
    private ?string $groupTesteurDescription = null;

    #[ORM\Column(type: "date")]
    private ?DateTime $createdAt = null;

    #[ORM\OneToMany(mappedBy: "groupeTesteurs", targetEntity: Registration::class, fetch: 'EAGER')]
    private Collection $registrations;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getGroupTesteurLabel(): ?string
    {
        return $this->groupTesteurLabel;
    }

    public function setGroupTesteurLabel(?string $groupTesteurLabel): void
    {
        $this->groupTesteurLabel = $groupTesteurLabel;
    }

    public function getGroupTesteurDescription(): ?string
    {
        return $this->groupTesteurDescription;
    }

    public function setGroupTesteurDescription(?string $groupTesteurDescription): void
    {
        $this->groupTesteurDescription = $groupTesteurDescription;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function __construct()
    {
        $this->registrations = new ArrayCollection();
    }

    /**
     * @return Collection|Registration[]
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }
}