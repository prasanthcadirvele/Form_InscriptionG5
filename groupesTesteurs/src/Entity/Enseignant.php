<?php

namespace App\Entity;

use App\Repository\EnseignantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnseignantRepository::class)]
#[ORM\Table(name: '`user`')]
class Enseignant extends User
{

    protected $user_type = 'enseignant';

    private bool $isValidated;

    #[ORM\ManyToOne(targetEntity: Etablissement::class, inversedBy: 'enseignants', fetch: 'EAGER')]
    private Etablissement $etablissement;

    #[ORM\OneToMany(mappedBy: 'enseignant', targetEntity: Registration::class, fetch: 'EAGER')]
    private Collection $registrations;

    public function __construct()
    {
        parent::__construct();
        $this->registrations = new ArrayCollection();
    }

    public function getEtablissement(): Etablissement
    {
        return $this->etablissement;
    }

    public function setEtablissement(Etablissement $etablissement): void
    {
        $this->etablissement = $etablissement;
    }

    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }
}
