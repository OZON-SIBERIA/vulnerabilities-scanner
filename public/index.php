<?php

require_once "../vendor/autoload.php";

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\PageController;
use App\Controller\DatabaseController;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$loader = new \Twig\Loader\FilesystemLoader('../app/Template');
$twig = new \Twig\Environment($loader);
\App\Service\TwigInitiator::twig_init($twig);

/*$paths = array(__DIR__."../Entities");
$isDevMode = true;

$dbParams = array(
    'driver'   => 'name',
    'user'     => 'name',
    'password' => 'name',
    'dbname'   => 'name',
    'host' => 'name'
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);*/

$routes = [
    "GET" => [
        '/' => [PageController::class, "indexAction"],
        '/rules' => [DatabaseController::class, "getReferencesList"],
        '/rules/1' => [DatabaseController::class, "getReference"]
    ],
    "POST" => [
        '/' => [PageController::class, "analysisAction"]
    ]
];

$request = Request::createFromGlobals();
$router = $routes[$request->getMethod()][$request->getPathInfo()];
$response = call_user_func($router, $request);

$response->send();