<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\GroupeTesteurs;

class GroupeTesteursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupeTesteurs::class);
    }

    public function save(GroupeTesteurs $groupeTesteurs): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($groupeTesteurs);
        $entityManager->flush();
    }

    public function update(int $id, GroupeTesteurs $newGroupeTesteur) : void
    {
        $groupeTesteur = $this->find($id);

        if ($groupeTesteur) {
            $groupeTesteur->setGroupTesteurLabel($newGroupeTesteur->getGroupTesteurLabel());
            $groupeTesteur->setGroupTesteurDescription($newGroupeTesteur->getGroupTesteurDescription());
            $this->getEntityManager()->flush();
        }
    }
}