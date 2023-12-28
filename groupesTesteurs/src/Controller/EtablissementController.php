<?php

namespace App\Controller;

use App\Entity\Etablissement;
use App\Repository\EtablissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EtablissementController
 *
 * This controller provides RESTful endpoints for managing etablissements.
 * Note: The methods are structured as a REST API, but the response format is intended to be Twig instead of JSON.
 * JWT authentication is assumed to be implemented, and user access to endpoints is based on user types defined as
 * global constants. User type information is extracted from the JWT token in the request header.
 */
#[Route("/etablissement")]
class EtablissementController extends AbstractController
{

    private EtablissementRepository $etablissementRepository;

    /**
     * EtablissementController constructor.
     *
     * @param EtablissementRepository $etablissementRepository
     */
    public function __construct(EtablissementRepository $etablissementRepository)
    {
        $this->etablissementRepository = $etablissementRepository;
    }

    /**
     * Get all etablissements.
     * @return JsonResponse
     */
    #[Route("/list", methods:"GET")]
    public function getAllEtablissements(): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        $etablissements = $this->etablissementRepository->findAll();
        return $this->json(['etablissements' => $etablissements], Response::HTTP_OK);

        // TODO : RETURN TO LIST OF ETABLISSEMENTS PAGE
    }

    /**
     * Get etablissement by ID.
     * @param int $id
     * @return JsonResponse
     */
    #[Route("/id/{id}", methods:"GET")]
    public function getEtablissementById(int $id): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        // Retrieve etablissement by ID and return it
        $etablissement = $this->etablissementRepository->findOneBy(['id' => $id]);

        if (!$etablissement) {
            return $this->json(['message' => 'Etablissement for provided uai does not exist'], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['etablissement' => $etablissement], Response::HTTP_OK);

        // TODO : RETURN TO ETABLISSEMENT PAGE
    }

    /**
     * Get etablissement by UAI.
     * @param string $uai
     * @return JsonResponse
     */
    #[Route("/uai/{uai}", methods:"GET")]
    public function getEtablissementByUAI(string $uai): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        // Retrieve etablissement by UAI and return it
        $etablissement = $this->etablissementRepository->findOneBy(['uai' => $uai]);

        if (!$etablissement) {
            return $this->json(['message' => 'Etablissement for provided uai does not exist'], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['etablissement' => $etablissement], Response::HTTP_OK);

        // TODO : RETURN TO ETABLISSEMENT PAGE

    }

    /**
     * Get etablissements by code postal.
     * @param int $codePostal
     * @return JsonResponse
     */
    #[Route("/list/cp/{codePostal}", methods:"GET")]
    public function getEtablissementsByCodePostal(int $codePostal): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        // Retrieve etablissements by code postal and return them
        $etablissements = $this->etablissementRepository->findBy(['etablissementCodePostal' => $codePostal]);
        return $this->json($etablissements);

        // TODO : RETURN TO LIST OF ETABLISSEMENTS PAGE

        // $this->render('etablissement/list.html.twig', ['etablissements' => $etablissements]);
    }

    /**
     * Get etablissements by departement.
     * @param int $departement
     * @return JsonResponse
     */
    #[Route("/list/dept/{departement}", methods:"GET")]
    public function getEtablissementsByDepartement(int $departement): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        // Retrieve etablissements by departement and return them
        $etablissements = $this->etablissementRepository->findBy(['etablissementDepartement' => $departement]);
        return $this->json($etablissements);

        // TODO : RETURN TO LIST OF ETABLISSEMENTS PAGE

        // $this->render('etablissement/list.html.twig', ['etablissements' => $etablissements]);
    }

    /**
     * Get etablissements by type.
     * @param string $type
     * @return JsonResponse
     */
    #[Route("/list/type/{type}", methods:"GET")]
    public function getEtablissementsByType(string $type): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        // Retrieve etablissements by type and return them
        $etablissements = $this->etablissementRepository->findBy(['etablissementType' => $type]);
        return $this->json($etablissements);

        // TODO : RETURN TO LIST OF ETABLISSEMENTS PAGE

        // $this->render('etablissement/list.html.twig', ['etablissements' => $etablissements]);
    }

    /**
     * Create a new etablissement.
     * @param Request $request
     * @return JsonResponse
     */
    #[Route("/", methods:"POST")]
    public function createEtablissement(Request $request): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        $data = json_decode($request->getContent(), true);

        // TODO VALIDATE DATA BEFORE INSERTION

        // Create a new etablissement and save it
        $etablissement = new Etablissement();
        $etablissement->setUai($data['uai']);
        $etablissement->setEtablissementName($data['etablissementName']);
        $etablissement->setEtablissementType($data['etablissementType']);
        $etablissement->setEtablissementAdress($data['etablissementAdress']);
        $etablissement->setEtablissementDepartement($data['etablissementDepartement']);
        $etablissement->setEtablissementCodePostal($data['etablissementCodePostal']);

        $this->etablissementRepository->save($etablissement);

        return $this->json(['message' => 'Etablissement added successfully'], Response::HTTP_OK);

        // TODO REDIRECTION TO LIST PAGE
    }

    /**
     * Update an existing etablissement.
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    #[Route("/{id}", methods:"PUT")]
    public function updateEtablissement(int $id, Request $request): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        $etablissement = $this->etablissementRepository->find($id);

        if (!$etablissement) {
            return $this->json(['message' => 'Etablissement to update not found'], Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);

        // Update Etablissement properties based on the request data
        if (isset($data['uai'])) {
            $etablissement->setUai($data['uai']);
        }

        if (isset($data['etablissementName'])) {
            $etablissement->setEtablissementName($data['etablissementName']);
        }

        if (isset($data['etablissementType'])) {
            $etablissement->setEtablissementType($data['etablissementType']);
        }

        if (isset($data['etablissementAdress'])) {
            $etablissement->setEtablissementAdress($data['etablissementAdress']);
        }

        if (isset($data['etablissementDepartement'])) {
            $etablissement->setEtablissementDepartement($data['etablissementDepartement']);
        }

        if (isset($data['etablissementCodePostal'])) {
            $etablissement->setEtablissementCodePostal($data['etablissementCodePostal']);
        }

        $this->etablissementRepository->update($id, $etablissement);

        return $this->json(['message' => 'Etablissement updated successfully']);

        // TODO REDIRECT TO UPDATED ETABLISSEMENT PAGE

    }

    /**
     * Delete an etablissement.
     * @param int $id
     * @return JsonResponse
     */
    #[Route("/{id}", methods:"DELETE")]
    public function deleteEtablissement(int $id): JsonResponse
    {
        // TODO: Implement JWT validation for user type

        $etablissement = $this->etablissementRepository->find($id);

        if(!$etablissement){
            return $this->json(['message' => 'The delete was unsuccessful'], Response::HTTP_BAD_REQUEST);
        }

        $this->etablissementRepository->delete($id);

        if(!$this->etablissementRepository->find($id)){
            return $this->json(['message' => 'The delete was successful'], Response::HTTP_OK);
        }

        return $this->json(['message' => 'The delete was unsuccessful'], Response::HTTP_INTERNAL_SERVER_ERROR);

    }

}