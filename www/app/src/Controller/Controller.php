<?php

namespace App\Controller;

abstract class Controller
{
    public function __construct(string $action, array $params = [])
    {
        if (!is_callable([$this, $action])) {
            throw new \RuntimeException("La methode $action n'est pas disponible dans ce controller");
        }
        call_user_func_array([$this, $action], $params);
    }

    public function render(string $view, string $title, string $style, array $args = [])
    {
        $view = dirname(__DIR__, 2) . '/views/' . $view;
        $base = dirname(__DIR__, 2) . '/views/base.php';
        
        ob_start();
        foreach ($args as $key => $value) {
            ${$key} = $value;
        }

        unset($args);

        require_once $view;
        $content = ob_get_clean();
        $title = $title;
        $style = '../../../style/' . $style . '?time()';


        require_once $base;

        exit;
    }

    public function saveFile($fileName): array
    {
        $targetDir = __DIR__ . "/../../public/img/";
        $targetFile = $targetDir . basename($fileName);
        $error = ['error'];
        $succeed = ['succeed'];
        $acceptExtension = ['jpg', 'png', 'jpeg', 'gif'];
        $check = true;

        if(!getimagesize($_FILES["fileToUpload"]["tmp_name"])) {
            $error[] = "Ce n'est pas une image";
            $check = false;
        }

        if ($_FILES["fileToUpload"]["size"] > 5971520) {
            $error[] = "Image trop volumineuse";
            $check = false;
        }

        if(!in_array(strtolower(pathinfo($fileName,PATHINFO_EXTENSION)), $acceptExtension)) {
            $error[] = "Seulement jpg, png, jpeg et gif";
            $check = false;
        }

        if (!$check) {
            return $error;
        }

        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile);
        return $succeed;
    }

    public function uuid(): string
    {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            mt_rand( 0, 0xffff ),

            mt_rand( 0, 0x0fff ) | 0x4000,

            mt_rand( 0, 0x3fff ) | 0x8000,

            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    public function renderJSON($content)
    {
        header('Content-Type: application/json');
        echo json_encode($content);
        exit;
    }
}
