<?php

namespace App\Entity;

use App\Repository\EnseignantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Again use the class diagram, the Enseignant class must be an extension of the User class so the Enseignant
 * class inherits all the attributes and methods from Parent class => Use Objected oriented programming
 * The only reason to user symphony is to have Object oriented programming
 */

#[ORM\Entity(repositoryClass: EnseignantRepository::class)]
class Enseignant extends User {

    protected $user_type = 'enseignant';

    private bool $isValidated;

    #[ORM\ManyToOne(targetEntity: Etablissement::class, inversedBy: 'enseignants', fetch: 'EAGER')]
    private Etablissement $etablissement;

    #[ORM\OneToMany(mappedBy: 'enseignant', targetEntity: Registration::class, fetch: 'EAGER')]
    private Collection $registrations;

    public function __construct()
    {
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
