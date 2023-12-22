<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UserController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/users", methods={"GET"}, name="get_all_users")
     */
    public function getAllUsers(): JsonResponse
    {
        // Check if the logged-in user is an admin
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have permission to view all users.');
        }

        $users = $this->userRepository->findAll();

        if (empty($users)) {
            return $this->json(['error' => 'No users found'], 404);
        }

        $formattedUsers = [];
        foreach ($users as $user) {
            $formattedUsers[] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                // Add more fields as needed
            ];
        }

        return $this->json($formattedUsers);
    }

     /**
     * @Route("/enseignants", methods={"GET"}, name="get_all_enseignants")
     */
    public function getAllEnseignants(): JsonResponse
    {
        // Check if the logged-in user is an admin
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have permission to view all enseignants.');
        }

        $enseignants = $this->userRepository->findBy(['type' => 'enseignant']);

        $formattedEnseignants = [];
        foreach ($enseignants as $enseignant) {
            $formattedEnseignants[] = [
                'id' => $enseignant->getId(),
                'email' => $enseignant->getEmail(),
            ];
        }

        return $this->json($formattedEnseignants);
    }

    /**
     * @Route("/admins", methods={"GET"}, name="get_all_admins")
     */
    public function getAllAdmins(): JsonResponse
    {
        // Check if the logged-in user is an admin
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have permission to view all admins.');
        }

        $admins = $this->userRepository->findBy(['type' => 'admin']);

        $formattedAdmins = [];
        foreach ($admins as $admin) {
            $formattedAdmins[] = [
                'id' => $admin->getId(),
                'email' => $admin->getEmail(),
        
            ];
        }

        return $this->json($formattedAdmins);
    }

    /**
     * @Route("/users/{id}", methods={"GET"}, name="get_user_by_id")
     * @ParamConverter("user", class="App\Entity\User")
     */
    public function getUserById(int $id): JsonResponse
    {
        // Check if the logged-in user is an admin
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have permission to view user details.');
        }

        $user = $this->userRepository->find($id);

        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }

        $formattedUser = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),

        ];

        return $this->json($formattedUser);
    }

    /**
     * @Route("/users/{id}/edit", methods={"GET", "POST"}, name="edit_user")
     */
    public function editUser(Request $request, int $id): Response
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }

        // Check if the logged-in user is the admin or the user being edited
        $loggedInUser = $this->getUser();
        if (!$loggedInUser || ($loggedInUser->getId() !== $user->getId() && !$this->isGranted('ROLE_ADMIN'))) {
            throw new AccessDeniedException('You do not have permission to edit this user.');
        }

        // Logic to handle user editing

        return $this->json(['message' => 'User edited successfully']);
    }

    /**
     * @Route("/users/{id}/delete", methods={"DELETE"}, name="delete_user")
     */
    public function deleteUser(int $id): Response
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }

        // Check if the logged-in user is an admin
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('You do not have permission to delete users.');
        }

        // User deletion logic here

        return $this->json(['message' => 'User deleted successfully']);
    }
}

