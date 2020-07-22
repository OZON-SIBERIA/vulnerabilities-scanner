<?php


namespace App\Rules;


class XSS
{

    public static function ReturnRule()
    {
        $description = <<<'EOL'
<div id="reference-head">
<a id="reference-name">Уязвимость реализации XSS атаки</a>
</div>
<div id="reference-source">
<a href="https://rules.sonarsource.com/php/type/Vulnerability/RSPEC-5131">
Источник уязвимости
</a>
</div>
<div id="reference-text">
<p id="p-1">Предоставленные пользователем данные, такие как параметры URL, тело запроса POST или
файлы cookie, всегда должны рассматриваться как ненадежные и испорченные. Построение операторов
включения на основе данных, предоставленных пользователем, может позволить злоумышленнику
контролировать, какие файлы включены. Если у злоумышленника есть возможность загружать файлы в
систему, тогда может быть выполнен произвольный код. Это может привести к широкому спектру
серьезных атак, таких как доступ / изменение конфиденциальной информации или получение полного
доступа к системе. </p>
<p id="p-2">Стратегия предотвращения должна быть основана на внесении в белый список разрешенных значений или приведении к безопасным типам.</p>
</div>
<div id="reference-bad">
<div id="reference-exp-title">Пример кода с уязвимостью:</div>
<div id="reference-bad-code">
<div id="reference-bad-1str">$name = $_GET["name"];</div>
<div id="reference-bad-2str">echo "Welcome".$name;</div>
</div>
</div>
<div id="reference-good">
<div id="reference-exp-title">Пример кода с предотвращенной уязвимостью:</div>
<div id="reference-good-code">
<div id="reference-good-1str">$name = $_GET["name"];</div>
<div id="reference-good-2str">$safename = htmlspecialchars($name);</div>
<div id="reference-good-3str">echo "Welcome".$safename";</div>
</div>
</div>
<div id="scheme-annotation">
Ниже представлена обобщенная схема сценариев,
где слева - сценарий приведет к возникновению уязвимости,
а справа - уязвимость будет предотвращена
</div>
EOL;

        $rule = (array('name' => 'XSS',
            'description' => $description));
        return $rule;
    }

}