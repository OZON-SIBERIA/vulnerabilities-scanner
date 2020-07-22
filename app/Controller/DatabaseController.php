<?php


namespace App\Controller;


use App\Config;
use App\Entities\Rule;
use App\Service\TwigInitiator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class DatabaseController
{
    public static function getReferencesPage(Request $request): Response
    {
        return Response::create(TwigInitiator::twig()->render('spravka.html.twig'));
    }



    public static function getReference(Request $request): Response
    {
        $em = Config::entityManager();

        $name = $request->query->get('name');
        $ruleRepository = $em->getRepository(Rule::class);
        //return new JsonResponse(array('code' => 'wad'));

        $rule = null;
        $rules = $ruleRepository->findBy(array('name' => $name));
        if(!empty($rules))
        {
            $rule = $rules[0];
        }
        return Response::create(
            TwigInitiator::twig()->render(
                'spravka.html.twig',
                [
                    'rule' =>  $rule

                ]
            )
        );

        /*return new JsonResponse(array_map(
            function (Rule $rule) {
                return ['id' => $rule->getId(), 'name' => $rule->getName(),
                    'description' => $rule->getDescription(), 'scheme' => $rule->getScheme()];
            },
            $ruleRepository->findBy(array('name' => $name))
        ));*/
    }

    //неиспользуемые методы
    public static function getReferencesList(Request $request): Response
    {
        $em = Config::entityManager();
        //get all names of rules
        $badExampleRepository = $em->getRepository(Rule::class);
        return new JsonResponse(array_map(
            function (Rule $rule) {
                return ['id' => $rule->getId(), 'name' => $rule->getName(),
                    'description' => $rule->getDescription(), 'scheme' => $rule->getScheme()];
            },
            $badExampleRepository->findAll()
        ));
    }

    //метод для добавления справочной информации в базу данных
    public static function newReference(Request $request): Response
    {
        $description = 'HTML-DESCRIPTION';

        $em = Config::entityManager();
        $rule = new Rule('RuleName',
            $description,
            '/images/image.png',
        );

        //save
        $em->persist($rule);
        $em->flush();
    }
}