<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Etablissement;

class EtablissementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etablissement::class);
    }

    public function save(Etablissement $etablissement): void
    {
        $entityManager = $this->getEntityManager();
        try {
            $entityManager->persist($etablissement);
            $entityManager->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }  
    }

    public function delete(int $id): void
    {
        $etablissement = $this->find($id);

        if ($etablissement) {
            $entityManager = $this->getEntityManager();
            $entityManager->remove($etablissement);
            $entityManager->flush();
        }
    }

    public function update(int $id, Etablissement $newEtablissement): void
    {
        $etablissement = $this->find($id);

        if ($etablissement) {
            $etablissement->setUai($newEtablissement->getUai());
            $etablissement->setEtablissementName($newEtablissement->getEtablissementName());
            $etablissement->setEtablissementType($newEtablissement->getEtablissementType());
            $etablissement->setEtablissementAdress($newEtablissement->getEtablissementAdress());
            $etablissement->setEtablissementDepartement($newEtablissement->getEtablissementDepartement());
            $etablissement->setEtablissementCodePostal($newEtablissement->getEtablissementCodePostal());

            $this->getEntityManager()->flush();
        }
    }


}
