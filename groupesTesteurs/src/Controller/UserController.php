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
     * TODO : ERROR the below function is getUserById, so you are supposed to pass the id as the parameter and then use
     * user repository to extract user by id then return the user
     */

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
