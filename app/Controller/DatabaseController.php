<?php


namespace App\Controller;


use App\Service\TwigInitiator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DatabaseController
{
    public static function getReferencesList()
    {
        return Response::create(TwigInitiator::twig()->render('spravka.html.twig'));
    }

    public static function getReference()
    {

    }
}