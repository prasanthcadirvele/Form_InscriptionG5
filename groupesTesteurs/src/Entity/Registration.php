<?php

namespace App\Entity;

use App\Repository\RegistrationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Represents the bridge between GroupeTesteurs and Enseignant, storing registration information.
 */

#[ORM\Entity(repositoryClass: RegistrationRepository::class)]
class Registration
{
     #[ORM\Id]
     #[ORM\GeneratedValue]
     #[ORM\Column(type: "integer")]
     private $id;

     #[ORM\ManyToOne(targetEntity: GroupeTesteurs::class, fetch: 'EAGER', inversedBy: "registrations")]
     private $groupeTesteurs;

     #[ORM\ManyToOne(targetEntity: Enseignant::class, fetch: 'EAGER', inversedBy: "registrations")]
     private $enseignant;

     #[ORM\Column(type: "date")]
     private $registrationDate;

     #[ORM\Column(type: "boolean")]
     private $isRegistrationValidated;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getGroupeTesteurs()
    {
        return $this->groupeTesteurs;
    }

    /**
     * @param mixed $groupeTesteurs
     */
    public function setGroupeTesteurs($groupeTesteurs): void
    {
        $this->groupeTesteurs = $groupeTesteurs;
    }

    /**
     * @return mixed
     */
    public function getEnseignant()
    {
        return $this->enseignant;
    }

    /**
     * @param mixed $enseignant
     */
    public function setEnseignant($enseignant): void
    {
        $this->enseignant = $enseignant;
    }

    /**
     * @return mixed
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * @param mixed $registrationDate
     */
    public function setRegistrationDate($registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }

    /**
     * @return mixed
     */
    public function getIsRegistrationValidated()
    {
        return $this->isRegistrationValidated;
    }

    /**
     * @param mixed $isRegistrationValidated
     */
    public function setIsRegistrationValidated($isRegistrationValidated): void
    {
        $this->isRegistrationValidated = $isRegistrationValidated;
    }

}