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

}