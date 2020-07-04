<?php

require_once "../vendor/autoload.php";

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\PageController;

$loader = new \Twig\Loader\FilesystemLoader('../app/Template');
$twig = new \Twig\Environment($loader);
\App\Service\TwigInitiator::twig_init($twig);

$routes = [
    "GET" => [
        '/' => [PageController::class, "indexAction"],
    ],
    "POST" => [
        '/' => [PageController::class, "analysisAction"]
    ]
];

$request = Request::createFromGlobals();
$router = $routes[$request->getMethod()][$request->getPathInfo()];
$response = call_user_func($router, $request);

$response->send();