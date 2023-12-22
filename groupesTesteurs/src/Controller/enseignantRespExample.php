<?php

// src/Controller/EnseignantController.php

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Enseignant;
use App\Repository\EnseignantRepository;

/**
 * @Route("/enseignant")
 */
class EnseignantController extends AbstractController
{
    private $enseignantRepository;

    public function __construct(EnseignantRepository $enseignantRepository)
    {
        $this->enseignantRepository = $enseignantRepository;
    }

    /**
     * @Route("/{id}", name="enseignant_show", methods={"GET"})
     */
    public function showEnseignant($id): Response
    {
        $enseignant = $this->enseignantRepository->getEnseignantById($id);

        return $this->render('enseignant/show.html.twig', ['enseignant' => $enseignant]);
    }

    /**
     * @Route("/list", name="enseignant_list", methods={"GET"})
     */
    public function listEnseignants(): Response
    {
        $enseignants = $this->enseignantRepository->getAllEnseignants();

        return $this->render('enseignant/list.html.twig', ['enseignants' => $enseignants]);
    }

    // TO DO Create and Update methods

    /**
     * @Route("/delete/{id}", name="enseignant_delete", methods={"DELETE"})
     */
    public function deleteEnseignant($id): Response
    {
        $enseignant = $this->enseignantRepository->getEnseignantById($id);

        if ($enseignant) {
            $this->enseignantRepository->deleteEnseignant($enseignant);
        }

        return $this->redirectToRoute('enseignant_list');
    }
}

