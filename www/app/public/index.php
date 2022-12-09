<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: authorization");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    die;
}

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

require_once "../router.php";