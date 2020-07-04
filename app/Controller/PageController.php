<?php


namespace App\Controller;


use App\Service\Analysis;
use App\Service\TwigInitiator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\ASTBuilder;


class PageController
{
    public static function indexAction(Request $request): Response
    {
        return Response::create(TwigInitiator::twig()->render('index.html.twig'));
    }

    public static function analysisAction(Request $request): Response
    {
        $code = json_decode($request->getContent(), true);
        $codePHP = ASTBuilder::prepare($code);
        $stmts = ASTBuilder::toAST($codePHP);
        $analysis = new Analysis;
        $result = $analysis->bigWalk($stmts);

        return JsonResponse::create((array)$result);
    }

}