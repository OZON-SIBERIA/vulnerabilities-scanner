<?php


namespace App\Controller;


use App\Config;
use App\Entities\BadExample;
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

    public static function getReference(Request $request): Response
    {
        $em = Config::entityManager();

        //get all names of rules
        $name = json_decode($request->getContent(), true);
        $badExampleRepository = $em->getRepository(Rule::class);
        return new JsonResponse(array_map(
            function (Rule $rule) {
                return ['id' => $rule->getId(), 'name' => $rule->getName(),
                    'description' => $rule->getDescription(), 'source' => $rule->getSource()];
            },
            $badExampleRepository->findBy(array('name' => $name))
        ));
    }

    public static function newReference(Request $request): Response
    {
        $description = <<<'EOL'
<div id="reference-source">Источник: https://rules.sonarsource.com/php/type/Vulnerability/RSPEC-5131
</div>
<div id="reference-text">
<p id="p-1">Предоставленные пользователем данные, такие как параметры URL, тело запроса POST или
файлы cookie, всегда должны рассматриваться как ненадежные и испорченные. Построение операторов
включения на основе данных, предоставленных пользователем, может позволить злоумышленнику
контролировать, какие файлы включены. Если у злоумышленника есть возможность загружать файлы в
систему, тогда может быть выполнен произвольный код. Это может привести к широкому спектру
серьезных атак, таких как доступ / изменение конфиденциальной информации или получение полного
доступа к системе. Стратегия предотвращения должна быть основана на внесении в белый список разрешенных значений или приведении к безопасным типам.</p>
</div>
<div id="reference-bad">
<div id="reference-exp-title">Пример кода с уязвимостью:</div>
<div id="reference-bad-1str">$name = $_GET["name"];</div>
<div id="reference-bad-2str">echo "Welcome".$name;</div>
</div>
<div id="reference-good">
<div id="reference-exp-title">Пример кода с предотвращенной уязвимостью:</div>
<div id="reference-good-1str">$name = $_GET["name"];</div>
<div id="reference-good-2str">$safename = htmlspecialchars($name);</div>
<div id="reference-good-3str">echo "Welcome".$safename";</div>
</div>
EOL;

        $em = Config::entityManager();
        $rule = new Rule('Уязвимость реализации XSS атаки',
            $description,
            '/images/XSS.png',
        );

        //save
        $em->persist($rule);
        $em->flush();
    }
}