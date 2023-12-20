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
     * @Route("/users/{id}", methods={"GET"}, name="get_user_by_id")
     * @ParamConverter("user", class="App\Entity\User")
     */
    public function getUserById(User $user): JsonResponse
    {
        $formattedUser = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            // Add more fields as needed
        ];

        return $this->json($formattedUser);
    }
}
