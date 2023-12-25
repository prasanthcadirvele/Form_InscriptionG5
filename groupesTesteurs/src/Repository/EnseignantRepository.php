<?php


namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Enseignant;

class EnseignantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enseignant::class);
    }

    public function save(Enseignant $enseignant): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($enseignant);
        $entityManager->flush();
    }

    public function updateIsValidatedStatus(int $id): void
    {
        $entityManager = $this->getEntityManager();
        $enseignant = $this->find($id);

        if ($enseignant) {
            $enseignant->setIsValidated(true);
            $entityManager->flush();
        }
    }

    public function updateEnseignant(int $id, Enseignant $updatedEnseignant): void
    {
        $entityManager = $this->getEntityManager();
        $enseignant = $this->find($id);

        if ($enseignant) {
            // Update properties as needed
            $enseignant->setFirstName($updatedEnseignant->getFirstName());
            $enseignant->setLastName($updatedEnseignant->getLastName());
            $enseignant->setEmail($updatedEnseignant->getEmail());

            $entityManager->flush();
        }
    }

    public function deleteEnseignant(int $id): void
    {
        $entityManager = $this->getEntityManager();
        $enseignant = $this->find($id);

        if ($enseignant) {
            $entityManager->remove($enseignant);
            $entityManager->flush();
        }
    }

    public function getAllEnseignants(): array
    {
        return $this->findAll();
    }

    public function findByEtablissementId($etablissementId): array
    {
        return $this->createQueryBuilder('e')
            ->join('e.etablissement', 'etablissement')
            ->andWhere('etablissement.id = :id')
            ->setParameter('id', $etablissementId)
            ->getQuery()
            ->getResult();
    }

    public function findByEtablissementUAI($etablissementUAI): array
    {
        return $this->createQueryBuilder('e')
            ->join('e.etablissement', 'etablissement')
            ->andWhere('etablissement.uai = :uai')
            ->setParameter('uai', $etablissementUAI)
            ->getQuery()
            ->getResult();
    }

}

