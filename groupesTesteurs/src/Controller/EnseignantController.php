<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Repository\EtablissementRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\EnseignantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/enseignant")]
class EnseignantController extends AbstractController
{
    private $enseignantRepository;
    private $etablissementRepository;

    public function __construct(
        EnseignantRepository $enseignantRepository,
        EtablissementRepository $etablissementRepository,
    ) {
        $this->enseignantRepository = $enseignantRepository;
        $this->etablissementRepository = $etablissementRepository;
    }

    public function validateEnseignantEntry($data)
    {
        return true;
    }

    #[Route("/", name: "enseignant_add", methods: "POST")]
    public function createEnseignant(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$this->validateEnseignantEntry($data)) {
            return $this->json(['message' => 'Invalid data'], Response::HTTP_BAD_REQUEST);
        }

        $enseignant = new Enseignant();
        $enseignant->setFirstName($data['first_name']);
        $enseignant->setLastName($data['last_name']);
        $enseignant->setEmail($data['email']);
        $etablissementData = $data['etablissement'];
        $etablissementId = $etablissementData['etablissementId'];

        $etablissement = $this->etablissementRepository->find($etablissementId);
        if (!$etablissement) {
            return $this->json(['message' => 'Invalid Etablissement'], Response::HTTP_BAD_REQUEST);
        }
        $enseignant->setEtablissement($etablissement);

        $token = bin2hex(random_bytes(32));

        $enseignant->setToken($token);
        $enseignant->setTokenExpiresAt(new \DateTimeImmutable('+1 hour'));

        $this->enseignantRepository->save($enseignant);

<<<<<<< HEAD
        //TO DO : Send registration email
        $this->sendRegistrationEmail($enseignant, $data['email']);

        return $this->json(['message' => 'Registration email sent'], Response::HTTP_OK);
    }   
=======
        return $this->json(['message' => 'Registration email sent'], Response::HTTP_OK);
    }
>>>>>>> b178c6c6392be670ed45ad220dad5df7c8685ff7

    #[Route("/set-password/{token}", name: "set_password", methods: "POST")]
    // TO DO : Method not working
    public function setPassword(string $token, Request $request): JsonResponse
    {
        // Find user by token
        $user = $this->enseignantRepository->findOneBy(['token' => $token]);

        // Check if the user exists and the account is activated
        if (!$user) {
            return $this->json(['message' => 'Invalid token'], Response::HTTP_BAD_REQUEST);
        }

        // Extract and validate the password from the request
        $data = json_decode($request->getContent(), true);

        if (empty($data['password'])) {
            return $this->json(['message' => 'Password cannot be empty'], Response::HTTP_BAD_REQUEST);
        }

        // Hash and set the new password
        $encodedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($encodedPassword);

        // Clear token and expiration date after setting the password
        $user->setToken(null);
        $user->setTokenExpiresAt(null);

        $this->enseignantRepository->save($user);

        return $this->json(['message' => 'Password set successfully']);
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
