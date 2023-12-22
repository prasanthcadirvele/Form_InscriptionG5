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
     * TODO : Why are you returning only returning id and email here ?
     * if the getAllUsers is used only by Admins then there should be an user Verification step added
     * => Check if the type of user is admin
     * Then you have to return all Users.
     * Also there shouldn't be a function for all users, it should be extract enseignants and extract admins
     * both functions must be accessed only by admins
     * Either you have to add a filter or you have to do manual verification for each function
     * if you choose to do it for each function then you have to have if(user type == admin) {} else [throw forbidden error }
     * Forbidden error => return access failed
     */

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
     * TODO : ERROR the below function is getUserById, so you are supposed to pass the id as the parameter and then use
     * user repository to extract user by id then return the user
     */

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

