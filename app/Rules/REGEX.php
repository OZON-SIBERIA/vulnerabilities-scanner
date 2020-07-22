<?php


namespace App\Rules;


class REGEX
{

    public static function ReturnRule()
    {
        $description = <<<'EOL'
<div id="reference-head">
<a id="reference-name">Уязвимость использования регулярных выражений в атаке типа «отказ в обслуживании»</a>
</div>
<div id="reference-source">
<a href="https://rules.sonarsource.com/php/type/Vulnerability/RSPEC-2631">
Источник уязвимости
</a>
</div>
<div id="reference-text">
<p id="p-1">Регулярные выражения могут иметь экспоненциальное время выполнения в зависимости от шаблона и длины входной строки. 
</p>
<p id="p-2">Рекомендуется исправить жестко запрограммированные шаблоны регулярных выражений, в которых используются функции с интенсивным использованием ЦП
</p>
<p id="p-3">Также рекомендуется, когда шаблон регулярного выражения определен с вводом, контролируемым пользователем, этот последний должен быть очищен, чтобы избежать символов, которые являются частью синтаксиса регулярного выражения.
</p>
<p id="p-4">PHP предотвращает атаки типа «отказ в обслуживании», устанавливая параметры конфигурации по умолчанию безопасные значения. Если для параметров pcre.backtracklimit_ или pcre.recursionlimit_ заданы более высокие значения, чем значения по умолчанию, убедитесь, что это не слишком большие числа, которые выставят приложение на отказ в обслуживании в случае неправильной или злонамеренной оценки регулярных выражений. Однако, несмотря на это снижение, рекомендуется проверять/избегать контролируемых пользователем входов. 
</p>
</div>
<div id="reference-bad">
<div id="reference-exp-title">Пример кода с уязвимостью:</div>
<div id="reference-bad-code">
<div id="reference-bad-1str">$regex = $_GET["regex"];</div>
<div id="reference-bad-2str">$input = $_GET["input"];</div>
<div id="reference-bad-3str">preg_grep($regex, $input);</div>
</div>
</div>
<div id="reference-good">
<div id="reference-exp-title">Пример кода с предотвращенной уязвимостью:</div>
<div id="reference-good-code">
<div id="reference-bad-1str">$regex = $_GET["regex"];</div>
<div id="reference-bad-2str">$input = $_GET["input"];</div>
<div id="reference-bad-3str">preg_grep(preg_quote($regex), $input);</div>
</div>
</div>
<div id="scheme-annotation">
Ниже представлена обобщенная схема сценариев,
где слева - сценарий приведет к возникновению уязвимости,
а справа - уязвимость будет предотвращена
</div>
EOL;

        $rule = (array('name' => 'HASH',
            'description' => $description));
        return $rule;
    }

}