<?php


namespace App\Controller;


use App\Config;
use App\Entities\BadExample;
use Symfony\Component\HttpFoundation\JsonResponse;

class DatabaseController
{
    public static function getReferencesList()
    {
        $em = Config::entityManager();
        $badexample = new BadExample("Example created at" . date('Y-m-d H:i:s'));

        //save
        $em->persist($badexample);
        $em->flush();

        //get all
        $badExampleRepository = $em->getRepository(BadExample::class);
        return new JsonResponse(array_map(
            function (BadExample $badExample) {
                return ['id' => $badExample->getId(), 'example' => $badExample->getBadExample()];
            },
            $badExampleRepository->findAll()
        ));

        //return Response::create(TwigInitiator::twig()->render('spravka.html.twig'));
    }

    public static function getReference()
    {

    }
}