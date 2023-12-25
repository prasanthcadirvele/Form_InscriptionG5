<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Repository\EnseignantRepository;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


#[Route("/enseignant")]
class EnseignantController extends AbstractController
{
    private $enseignantRepository;

    public function __construct(EnseignantRepository $enseignantRepository)
    {
        $this->enseignantRepository = $enseignantRepository;
    }

    #[Route("/", name: "enseignant_add", methods: "POST")]
    public function createEnseignant(): void
    {
        // Retrieve data from the request (assuming JSON payload)
        $data = null;//json_decode($request->getContent(), true); TODO : Update values before testing

        // Create a new Enseignant entity
        $enseignant = new Enseignant();
        $enseignant->setFirstName($data['first_name']);
        $enseignant->setLastName($data['last_name']);
        $enseignant->setEmail($data['email']);
        $enseignant->setPassword($data['password']); // Note: Ensure to handle password encryption

        $this->enseignantRepository->save($enseignant);

        // Return a success response
        //return $this->json(['message' => 'Enseignant created successfully'], STATUS_OK);
    }

    #[Route("/{id}", name: "enseignant_show", methods: "GET")]
    public function showEnseignant($id): void //Response
    {
        $enseignant = $this->enseignantRepository->getEnseignantById($id);

        // return $this->render('enseignant/show.html.twig', ['enseignant' => $enseignant]);
    }

    #[Route("/list", name: "enseignant_list", methods: "GET")]
    public function listEnseignants(): void //Response
    {
        $enseignants = $this->enseignantRepository->getAllEnseignants();

        // return $this->render('enseignant/list.html.twig', ['enseignants' => $enseignants]);
    }

    #[Route("/update/{id}", name: "enseignant_update", methods: "PUT")]
    public function updateEnseignant(int $id, Request $request): void //Response
    {
        $enseignant = $this->enseignantRepository->find($id);

        if (!$enseignant) {
            // return $this->json(['message' => 'Enseignant not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $updatedEnseignant = new Enseignant();

        $this->enseignantRepository->updateEnseignant($id, $updatedEnseignant);

        // return $this->json(['message' => 'Enseignant updated successfully'], Response::HTTP_OK);
    }

    #[Route("/delete/{id}", name: "enseignant_delete", methods: "DELETE")]
    public function deleteEnseignant(int $id, EnseignantRepository $repository): void //Response
    {
        $enseignant = $repository->find($id);

        if (!$enseignant) {
            // return $this->json(['message' => 'Enseignant not found'], Response::HTTP_NOT_FOUND);
        }

        $repository->deleteEnseignant($enseignant);

        // return $this->json(['message' => 'Enseignant deleted successfully'], Response::HTTP_OK);
    }

    #[Route("/{id}/validate", name: "enseignant_validate", methods: "PATCH")]
    public function validateEnseignant(int $id): void //Response
    {
        $enseignant = $this->enseignantRepository->find($id);

        if (!$enseignant) {
            // return $this->json(['message' => 'Enseignant not found'], Response::HTTP_NOT_FOUND);
        }

        $this->enseignantRepository->updateIsValidatedStatus($id);

        // return $this->json(['message' => 'Enseignant validated successfully'], Response::HTTP_OK);
    }

    #[Route("/etablissement/id/{schoolId}", methods:"GET")]
    public function getEnseignantsBySchoolId(int $etablissementId): void //Response
    {
        $enseignant = $this->enseignantRepository->findByEtablissementId($etablissementId);
        // return $this->render('etablissement/show.html.twig', ['enseignant' => $enseignant]);
    }

    #[Route("/etablissement/uai/{uai}", methods:"GET")]
    public function getEnseignantsByUai(int $etablissementUAI): void //Response
    {
        $enseignant = $this->enseignantRepository->findByEtablissementUAI($etablissementUAI);
        // return $this->render('etablissement/show.html.twig', ['enseignant' => $enseignant]);
    }
}
