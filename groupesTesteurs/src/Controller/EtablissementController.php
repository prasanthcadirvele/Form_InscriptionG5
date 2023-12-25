<?php

namespace App\Controller;

use App\Entity\Etablissement;
use App\Repository\EtablissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/etablissement", methods:"GET")]
class EtablissementController extends AbstractController
{

    private EtablissementRepository $etablissementRepository;

    public function __construct(EtablissementRepository $etablissementRepository)
    {
        $this->etablissementRepository = $etablissementRepository;
    }


    #[Route("/list", methods:"GET")]
    public function getAllEtablissements(): void //Response
    {
        $etablissements = $this->etablissementRepository->findAll();

        // return $this->render('etablissement/list.html.twig', ['etablissements' => $etablissements]);
    }

    #[Route("/id/{id}", methods:"GET")]
    public function getEtablissementById(int $id): void //Response
    {
        $etablissement = $this->etablissementRepository->find($id);

        if (!$etablissement) {
            // $this->render('etablissement/show.html.twig', ['etablissement' => $etablissement]);
        }


    }

    #[Route("/uai/{uai}", methods:"GET")]
    public function getEtablissementByUAI(string $uai): void //Response
    {
        $etablissement = $this->etablissementRepository->find($uai);

        if (!$etablissement) {
            // $this->render('etablissement/show.html.twig', ['etablissement' => $etablissement]);
        }


    }

    #[Route("/list/cp/{codePostal}", methods:"GET")]
    public function getEtablissementsByCodePostal(int $codePostal): void //Response
    {
        $etablissements = $this->etablissementRepository->findByEtablissementCodePostal($codePostal);

        // $this->render('etablissement/list.html.twig', ['etablissements' => $etablissements]);
    }

    #[Route("/list/dept/{departement}", methods:"GET")]
    public function getEtablissementsByDepartement(int $departement): void //Response
    {
        $etablissements = $this->etablissementRepository->findByEtablissemtDepartement($departement);

        // $this->render('etablissement/list.html.twig', ['etablissements' => $etablissements]);
    }

    #[Route("/list/type/{type}", methods:"GET")]
    public function getEtablissementsByType(string $type): void //Response
    {
        $etablissements = $this->etablissementRepository->findByType($type);

        // $this->render('etablissement/list.html.twig', ['etablissements' => $etablissements]);
    }

    #[Route("/", methods:"POST")]
    public function createEtablissement(Request $request): void
    {
        $data = json_decode($request->getContent(), true);

        // TODO VALIDATE DATA BEFORE INSERTION

        $etablissement = new Etablissement();
        $etablissement->setUai($data['uai']);
        $etablissement->setEtablissementName($data['etablissementName']);
        $etablissement->setEtablissementType($data['etablissementType']);
        $etablissement->setEtablissementAdress($data['etablissementAdress']);
        $etablissement->setEtablissementDepartement($data['etablissementDepartement']);
        $etablissement->setEtablissementCodePostal($data['etablissementCodePostal']);

        $this->etablissementRepository->save($etablissement);

        // TODO REDIRECTION TO LIST PAGE
    }

    #[Route("/{id}", methods:"PUT")]
    public function updateEtablissement(int $id, Request $request): void
    {
        $etablissement = $this->etablissementRepository->find($id);

        if (!$etablissement) {
            // TODO SEND ETABLISSEMENT TO UPDATE NOT FOUND
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

        // TODO REDIRECT TO UPDATED ETABLISSEMENT PAGE
    }

    #[Route("/{id}", methods:"DELETE")]
    public function deleteEtablissement(int $id): void //Response
    {
        $etablissement = $this->etablissementRepository->find($id);

        $this->etablissementRepository->delete($id);

        // TODO CHECK WHETHER THE DELETE WAS SUCESSFULL OR NOT

    }

}