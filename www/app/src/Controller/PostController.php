<?php

namespace App\Controller;

use App\Model\Factory\PDOFactory;
use App\Model\Repository\PostRepository;
use App\Model\Repository\UserRepository;
use App\Route\Route;
use App\Model\Entity\Post;
use App\Services\JWTHelper;

class PostController extends Controller
{
    #[Route('/', 'homePage', ['GET'])]
    public function home($error = [])
    {
        $cred = str_replace("Bearer ", "", getallheaders()['authorization']);
        $token = JWTHelper::decodeJWT($cred);
        if (!$token) {
            $this->renderJSON([
                "message" => "invalid cred"
            ]);
            die;
        }
        $postRepository = new PostRepository(new PDOFactory());
        $posts = $postRepository->getAllPost();
        if($posts) {
            $this->renderJSON([
                "posts" => $posts
            ]);
            http_response_code(200);
            die;
        }
        $this->renderJSON([
            "message" => "No Post"
        ]);
        die;
    }

    #[Route('/post', 'newPost', ['POST'])]
    public function newPost()
    {
        $cred = str_replace("Bearer ", "", getallheaders()['authorization']);
        $token = JWTHelper::decodeJWT($cred);
        if (!$token) {
            $this->renderJSON([
                "message" => "invalid cred"
            ]);
            die;
        }

        $userRepository = new UserRepository(new PDOFactory());
        $user = $userRepository->getUserByToken($cred);
        $author = $user->getUsername();
        $userId = $user->getId();

        $args = [...$_POST, 'author' => $author, 'user_id' => $userId];
        $postRepository = new PostRepository(new PDOFactory());
        $post = new Post($args);
        $post = $postRepository->insert($post);
        $this->renderJSON([
            "post" => $post
        ]);
        http_response_code(200);
        die;
    }

    #[Route('/post/delete', 'deletePost', ['POST'])]
    public function deletePost()
    {
        $json = file_get_contents("php://input");
        $body = json_decode($json, true);
        $postId = $body['id'];
        if ($postId) {
            $postRepository = new PostRepository(new PDOFactory());
            $postRepository->delete($postId);
            http_response_code(200);
        }
        exit();
    }

    #[Route('/post/patch', 'patchPost', ['POST'])]
    public function patchPost()
    {
        $json = file_get_contents("php://input");
        $postRepository = new PostRepository(new PDOFactory());
        $post = new Post(json_decode($json, true));
        $postRepository->update($post);
        http_response_code(200);
        exit();
    }


}
