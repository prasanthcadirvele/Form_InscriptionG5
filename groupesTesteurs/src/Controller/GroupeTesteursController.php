<?php

namespace App\Controller;

use App\Entity\GroupeTesteurs;
use App\Form\GroupeTesteursType;
use App\Repository\GroupeTesteursRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     public function __construct(GroupeTesteursRepository $groupeTesteursRepository)
     {
         $this->groupeTesteursRepository = $groupeTesteursRepository;
     }
 
     #[Route("/list", name: "groupe_testeurs_list", methods: ["GET"])]
     public function list(): Response
     {
         $groupeTesteurs = $this->groupeTesteursRepository->findAll();
 
         return $this->render('groupeTesteurs/list.html.twig', [
             'groupeTesteurs' => $groupeTesteurs,
         ]);
     }

     /**
      * Display the form to add a new GroupeTesteurs.
      * @return Response
      */
     #[Route("/add", name: "groupe_testeurs_add", methods: ["GET"])]
     public function showGroupeTesteursForm(): Response
     {
         // Create a new GroupeTesteurs instance
         $groupeTesteurs = new GroupeTesteurs();

         // Create a form to handle the GroupeTesteurs data
         $form = $this->createForm(GroupeTesteursType::class, $groupeTesteurs);

         // Render the form template
         return $this->render('groupeTesteurs/add.html.twig', [
             'form' => $form->createView(),
         ]);
     }

    /**
     * Get GroupeTesteurs by ID.
     * @param int $id
     * @return JsonResponse
     */
    #[Route("id/{id}", methods:["GET"])]
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
      * @return Response
      */
     #[Route("/add", name:"groupe_testeurs_create", methods:["POST"])]
     public function createGroupeTesteurs(Request $request): Response
     {
         // Create a new GroupeTesteurs instance
         $groupeTesteurs = new GroupeTesteurs();

         // Create a form to handle the GroupeTesteurs data
         $form = $this->createForm(GroupeTesteursType::class, $groupeTesteurs);

         // Handle form submission
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             // Save the GroupeTesteurs to the database
             $groupeTesteurs->setCreatedAt(new \DateTime());
             $this->groupeTesteursRepository->save($groupeTesteurs);
             // Redirect to the list of groupe testeurs page
             return $this->redirectToRoute('groupe_testeurs_list');
         }

         // Render the form template
         return $this->render('groupeTesteurs/add.html.twig', [
             'form' => $form->createView(),
         ]);
     }


     /**
     * Update an existing GroupeTesteurs.
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    #[Route("/id/{id}", methods:["PUT"])]
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
        return $this->render('groupeTesteurs/list.html.twig', ['groupeTesteurs' => $groupeTesteurs]);

    }

    /**
     * Delete a GroupeTesteurs.
     * @param int $id
     * @return JsonResponse
     */
    #[Route("/id/{id}", name:"groupe_testeurs_delete", methods:["DELETE"])]
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
        return $this->render('groupeTesteurs/list.html.twig', ['groupeTesteurs' => $groupeTesteurs]);

    }

}


