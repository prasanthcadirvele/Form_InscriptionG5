<?php

namespace App\Controller;

use App\Entity\GroupeTesteurs;
use App\Repository\GroupeTesteursRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class GroupeTesteursController
 *
 * This controller provides RESTful endpoints for managing GroupeTesteurs.
 * Note: The methods are structured as a REST API, but the response format is intended to be Twig instead of JSON.
 * JWT authentication is assumed to be implemented, and user access to endpoints is based on user types defined as
 * global constants. User type information is extracted from the JWT token in the request header.
 */
#[Route("/groupeTesteurs")]
class GroupeTesteursController extends AbstractController
{

    private GroupeTesteursRepository $groupeTesteursRepository;

    /**
     * GroupeTesteursController constructor.
     *
     * @param GroupeTesteursRepository $groupeTesteursRepository
     */
    public function __construct(GroupeTesteursRepository $groupeTesteursRepository) {
        $this->groupeTesteursRepository = $groupeTesteursRepository;
    }

    /**
     * Get all GroupeTesteurs.
     * @return JsonResponse
     */
    #[Route("/list", methods:"GET")]
    public function getAllGroupeTesteurs(): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        // Retrieve and return all GroupeTesteurs
        $groupeTesteurs = $this->groupeTesteursRepository->findAll();
        return $this->json(['groupeTesteurs' => $groupeTesteurs], Response::HTTP_OK);

        // TODO : RETURN TO LIST OF GROUPE TESTEURS PAGE
    }

    /**
     * Get GroupeTesteurs by ID.
     * @param int $id
     * @return JsonResponse
     */
    #[Route("/id/{id}", methods:"GET")]
    public function getGroupeTesteursById(int $id): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        // Retrieve GroupeTesteurs by ID and return it
        $groupeTesteurs = $this->groupeTesteursRepository->find($id);

        if (!$groupeTesteurs) {
            return $this->json(['message' => 'GroupeTesteurs for provided ID does not exist'], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['groupeTesteurs' => $groupeTesteurs], Response::HTTP_OK);

        // TODO : RETURN TO GROUPE TESTEURS PAGE
    }

    /**
     * Create a new GroupeTesteurs.
     * @param Request $request
     * @return JsonResponse
     */
    #[Route("/", methods:"POST")]
    public function createGroupeTesteurs(Request $request): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        $data = json_decode($request->getContent(), true);

        // TODO: Validate data before insertion

        // Create a new GroupeTesteurs and save it
        $groupeTesteurs = new GroupeTesteurs();
        $groupeTesteurs->setGroupTesteurLabel($data['groupTesteurLabel']);
        $groupeTesteurs->setGroupTesteurDescription($data['groupTesteurDescription']);
        $groupeTesteurs->setCreatedAt(new DateTime());

        $this->groupeTesteursRepository->save($groupeTesteurs);

        return $this->json(['message' => 'GroupeTesteurs added successfully'], Response::HTTP_OK);

        // TODO: Redirect to list of groupe testeurs page
    }

    /**
     * Update an existing GroupeTesteurs.
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    #[Route("/id/{id}", methods:"PUT")]
    public function updateGroupeTesteurs(int $id, Request $request): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        $groupeTesteurs = $this->groupeTesteursRepository->find($id);

        if (!$groupeTesteurs) {
            return $this->json(['message' => 'GroupeTesteurs to update not found'], Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);

        // Update GroupeTesteurs properties based on the request data
        if (isset($data['groupTesteurLabel'])) {
            $groupeTesteurs->setGroupTesteurLabel($data['groupTesteurLabel']);
        }

        if (isset($data['groupTesteurDescription'])) {
            $groupeTesteurs->setGroupTesteurDescription($data['groupTesteurDescription']);
        }

        $this->groupeTesteursRepository->update($id, $groupeTesteurs);

        return $this->json(['message' => 'GroupeTesteurs updated successfully']);

        // TODO: Redirect to updated GroupeTesteurs page
    }

    /**
     * Delete a GroupeTesteurs.
     * @param int $id
     * @return JsonResponse
     */
    #[Route("/id/{id}", methods:"DELETE")]
    public function deleteGroupeTesteurs(int $id): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        $groupeTesteurs = $this->groupeTesteursRepository->find($id);

        if (!$groupeTesteurs) {
            return $this->json(['message' => 'GroupeTesteurs to delete not found'], Response::HTTP_BAD_REQUEST);
        }

        $this->groupeTesteursRepository->delete($id);

        if (!$this->groupeTesteursRepository->find($id)) {
            return $this->json(['message' => 'The delete was successful'], Response::HTTP_OK);
        }

        return $this->json(['message' => 'The delete was unsuccessful'], Response::HTTP_BAD_REQUEST);

        // TODO: Check whether the delete was successful or not
    }


}