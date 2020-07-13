<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Config;
use App\Controller\DatabaseController;
use App\Controller\PageController;
use App\Service\TwigInitiator;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader('../app/Template');
$twig = new Environment($loader);
TwigInitiator::twig_init($twig);

$routes = [
    "GET" => [
        '/' => [PageController::class, "indexAction"],
        '/rules' => [DatabaseController::class, "getReferencesPage"],
        '/rules/loaded' => [DatabaseController::class, "getReferencesList"],
        '/rules/rule/new' => [DatabaseController::class, "newReference"]
    ],
    "POST" => [
        '/' => [PageController::class, "analysisAction"]
    ]
];

$entityManager = Config::entityManager();

$request = Request::createFromGlobals();
$router = $routes[$request->getMethod()][$request->getPathInfo()];
$response = call_user_func($router, $request);

$response->send();