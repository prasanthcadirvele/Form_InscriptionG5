<?php

namespace App\Controller;

use App\Entity\Registration;
use App\Repository\GroupeTesteursRepository;
use App\Repository\EnseignantRepository;
use App\Repository\RegistrationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationController
 *
 * This controller provides RESTful endpoints for managing Registrations.
 * Note: The methods are structured as a REST API, but the response format is intended to be Twig instead of JSON.
 * JWT authentication is assumed to be implemented, and user access to endpoints is based on user types defined as
 * global constants. User type information is extracted from the JWT token in the request header.
 */
#[Route("/registration/")]
class RegistrationController extends AbstractController
{
    private RegistrationRepository $registrationRepository;
    private GroupeTesteursRepository $groupeTesteursRepository;
    private EnseignantRepository $enseignantRepository;

    /**
     * RegistrationController constructor.
     *
     * @param RegistrationRepository $registrationRepository
     * @param GroupeTesteursRepository $groupeTesteursRepository
     * @param EnseignantRepository $enseignantRepository
     */
    public function __construct(RegistrationRepository $registrationRepository,
                                GroupeTesteursRepository $groupeTesteursRepository,
                                EnseignantRepository $enseignantRepository) {
        $this->registrationRepository = $registrationRepository;
        $this->groupeTesteursRepository = $groupeTesteursRepository;
        $this->enseignantRepository = $enseignantRepository;
    }

    /**
     * Get Registrations by GroupeTesteur ID.
     * @param int $groupeTesteurId
     * @return JsonResponse
     */
    #[Route("groupe-testeur/{groupeTesteurId}", methods:"GET")]
    public function getRegistrationsByGroupeTesteurId(int $groupeTesteurId): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        // Retrieve Registrations by GroupeTesteur ID and return them
        $groupeTesteur = $this->groupeTesteursRepository->find($groupeTesteurId);

        if (!$groupeTesteur) {
            return $this->json(['message' => 'GroupeTesteur not found'], Response::HTTP_BAD_REQUEST);
        }

        $registrations = $groupeTesteur->getRegistrations();

        return $this->json(['registrations' => $registrations], Response::HTTP_OK);

        // TODO : RETURN TO LIST OF REGISTRATIONS PAGE
    }

    /**
     * Get Registrations by Enseignant ID.
     * @param int $enseignantId
     * @return JsonResponse
     */
    #[Route("enseignant/{enseignantId}", methods:"GET")]
    public function getRegistrationsByEnseignantId(int $enseignantId): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        // Retrieve Registrations by Enseignant ID and return them
        $enseignant = $this->enseignantRepository->find($enseignantId);

        if (!$enseignant) {
            return $this->json(['message' => 'Enseignant not found'], Response::HTTP_BAD_REQUEST);
        }

        $registrations = $enseignant->getRegistrations();

        return $this->json(['registrations' => $registrations], Response::HTTP_OK);

        // TODO : RETURN TO LIST OF REGISTRATIONS PAGE
    }

    /**
     * Create a new Registration.
     * @param Request $request
     * @return JsonResponse
     */
    #[Route("", methods:"POST")]
    public function createRegistration(Request $request): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        $data = json_decode($request->getContent(), true);

        // TODO: Validate data before insertion

        // Retrieve associated GroupeTesteurs and Enseignant entities
        $groupeTesteursId = $data['groupeTesteursId'];
        $groupeTesteurs = $this->groupeTesteursRepository->find($groupeTesteursId);

        $enseignantId = $data['enseignantId'];
        $enseignant = $this->enseignantRepository->find($enseignantId);

        // Create a new Registration and save it
        $registration = new Registration();
        $registration->setGroupeTesteurs($groupeTesteurs);
        $registration->setEnseignant($enseignant);
        $registration->setRegistrationDate(new DateTime());
        $registration->setIsRegistrationValidated(false);

        $this->registrationRepository->save($registration);

        return $this->json(['message' => 'Registration added successfully'], Response::HTTP_OK);

        // TODO: Redirect to list page
    }

    /**
     * Delete a Registration.
     * @param int $id
     * @return JsonResponse
     */
    #[Route("/id/{id}", methods:"DELETE")]
    public function deleteRegistration(int $id): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        $registration = $this->registrationRepository->find($id);

        if (!$registration) {
            return $this->json(['message' => 'Registration to delete not found'], Response::HTTP_BAD_REQUEST);
        }

        $this->registrationRepository->delete($id);

        if (!$this->registrationRepository->find($id)) {
            return $this->json(['message' => 'The delete was successful'], Response::HTTP_OK);
        }

        return $this->json(['message' => 'The delete was unsuccessful'], Response::HTTP_BAD_REQUEST);

        // TODO: REDIRECT TO LIST OF REGISTRATIONS FOR THE GROUP TESTEURS
    }

    /**
     * Validate a Registration.
     * @param int $id
     * @return JsonResponse
     */
    #[Route("/validate/{id}", methods:"POST")]
    public function validateRegistration(int $id): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        $registration = $this->registrationRepository->find($id);

        if (!$registration) {
            return $this->json(['message' => 'Registration to validate not found'], Response::HTTP_BAD_REQUEST);
        }

        // Mark the registration as validated
        $registration->setIsRegistrationValidated(true);
        $this->registrationRepository->save($registration);

        return $this->json(['message' => 'Registration validated successfully'], Response::HTTP_OK);

        // TODO: REDIRECT TO LIST OF REGISTRATIONS FOR THE GROUP TESTEURS
    }
}