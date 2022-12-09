<?php

namespace App\Controller;

use App\Model\Factory\PDOFactory;
use App\Model\Repository\UserRepository;
use App\Model\Entity\User;
use App\Route\Route;
use App\Services\JWTHelper;

class SecurityController extends Controller
{
    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $userRepository = new UserRepository(new PDOFactory());
        $user = $userRepository->getUserByName($username);

        if ($user && $user->verifyPassword($password)) {
            $jwt = JWTHelper::buildJWT($user);
            $user->setToken($jwt);
            $userRepository->update($user);
            $this->renderJSON([
                "token" => $jwt
            ]);
            http_response_code(200);
            die();
        }
        $this->signUp();
    }

    #[ROUTE('/signUp', 'signup', ['POST'])]
    public function signUp()
    {
        $username = $_POST['username'];

        $userRepository = new UserRepository(new PDOFactory());
        $user = $userRepository->getUserByName($username);
        if (!isset($user)) {
            $user = new User($_POST);
            $user = $userRepository->insert($user);
            $jwt = JWTHelper::buildJWT($user);
            $user->setToken($jwt);
            $userRepository->update($user);
            $this->renderJSON([
                "token" => $jwt
            ]);
            http_response_code(200);
            die();
        }
        echo json_encode(['error' => 'Mot de passe ou utilisateur invalid']);
        die();
    }

    #[Route('/signOut', 'signout', ['POST'])]
    public function signout()
    {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            unset($_SESSION["user"]);
            http_response_code(200);
        }
        exit();
    }
}
