<?php


namespace App\Rules;


class HASH
{

    public static function ReturnRule()
    {
        $description = <<<'EOL'
<div id="reference-head">
<a id="reference-name">Уязвимость использования слабых алгоритмов шифрования</a>
</div>
<div id="reference-source">
<a href="https://rules.sonarsource.com/php/type/Security%20Hotspot/RSPEC-4790">
Источник уязвимости
</a>
</div>
<div id="reference-text">
<p id="p-1">Криптографические алгоритмы хеширования, такие как MD2, MD4, MD5, MD6, HAVAL-128, HMAC-MD5, DSA (который использует SHA-1), RIPEMD, RIPEMD-128, RIPEMD-160, HMACRIPEMD160 и SHA-1, больше не считаются безопасными потому что слишком легко создавать коллизии хеша с ними (достаточно небольших вычислительных усилий, чтобы найти два или более разных входных данных, которые производят один и тот же хеш). 
</p>
<p id="p-2">Рекомендуются более безопасные альтернативы, такие как SHA-256, SHA-512, SHA-3 или bcrypt, а для хэширования паролей даже лучше использовать алгоритмы, которые не слишком быстро вычисляются, например bcrypt вместо SHA-256, потому что это замедляет атаки методом перебора и словаря.
</p>
</div>
<div id="reference-bad">
<div id="reference-exp-title">Пример кода с уязвимостью:</div>
<div id="reference-bad-code">
<div id="reference-bad-1str">$password = md5($password);</div>
<div id="reference-bad-2str">или</div>
<div id="reference-bad-3str">$password = sha1($password);</div>
</div>
</div>
<div id="reference-good">
<div id="reference-exp-title">Пример кода с предотвращенной уязвимостью:</div>
<div id="reference-good-code">
<div id="reference-good-1str">$password = password_hash($password, PASSWORD_BCRYPT);</div>
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