<?php

// src/Repository/EnseignantRepository.php

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Enseignant;

class EnseignantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enseignant::class);
    }

    // Create
    public function save(Enseignant $enseignant)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($enseignant);
        $entityManager->flush();
    }

    // Read
    public function getAllEnseignants()
    {
        return $this->findAll();
    }

    public function getEnseignantById($id)
    {
        return $this->find($id);
    }

    // Update
    public function updateEnseignant(Enseignant $enseignant)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->flush();
    }

    // Delete
    public function deleteEnseignant(Enseignant $enseignant)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($enseignant);
        $entityManager->flush();
    }
}
