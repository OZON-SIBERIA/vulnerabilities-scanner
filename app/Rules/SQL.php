<?php


namespace App\Rules;


class SQL
{

    public static function ReturnRule()
    {
        $description = <<<'EOL'
<div id="reference-head">
<a id="reference-name">Уязвимость форматирования SQL-запросов</a>
</div>
<div id="reference-source">
<a href="https://rules.sonarsource.com/php/type/Security%20Hotspot/RSPEC-2077">
Источник уязвимости
</a>
</div>
<div id="reference-text">
<p id="p-1">В запросах SQL часто требуется использовать жестко запрограммированную строку SQL с динамическим параметром, исходящим из запроса пользователя. Форматирование строки для добавления этих параметров в запрос является плохой практикой, поскольку может привести к внедрению SQL. Безопасный способ добавить параметры в запрос SQL - это использовать механизмы привязки SQL
</p>
<p id="p-2">Это правило помечает выполнение запросов SQL, которые построены с использованием форматирования строк, даже если нет внедрения. Это правило не обнаруживает SQL-инъекции. Цель состоит в том, чтобы направлять обзоры кода безопасности и предотвращать распространенную плохую практику 
</p>
<p id="p-3">Рекомендуемые методы безопасного кодирования:
</p>
<ul>
<li id="p-4">избегайте создания запросов вручную с использованием техники форматирования. Если вы все равно это сделаете, не включайте пользовательский ввод в этот процесс сборки;
</li>
<li id="p-5">по возможности используйте параметризованные запросы, подготовленные операторы или хранимые процедуры;
</li>
<li id="p-6">подготовленный оператор объектов данных PHP (PDO) со связанными параметрами должен быть предпочтительнее, чем встроенные функции базы данных;
</li>
<li id="p-7">избегайте выполнения запросов SQL, содержащих небезопасный ввод в хранимых процедурах или функциях;
</li>
<li id="p-8">проводите санитизацию входных данных.
</li>
</ul>
</div>
<div id="reference-bad">
<div id="reference-exp-title">Пример кода с уязвимостью:</div>
<div id="reference-bad-code">
<div id="reference-bad-1str">$id = $_GET['id'];</div>
<div id="reference-bad-2str">mysql_connect('localhost', $username, $password) or die('Could not connect: ' . mysql_error());</div>
<div id="reference-bad-3str">mysql_select_db('myDatabase') or die('Could not select database');</div>
<div id="reference-bad-4str">   </div>
<div id="reference-bad-5str">$result = mysql_query("SELECT * FROM myTable WHERE id = " . $id);
</div>
<div id="reference-bad-6str">  </div>
<div id="reference-bad-7str">while ($row = mysql_fetch_object($result)) {</div>
<div id="reference-bad-8str">    echo $row->name;</div>
<div id="reference-bad-9str">}</div>
</div>
</div>
<div id="reference-good">
<div id="reference-exp-title">Пример кода с предотвращенной уязвимостью:</div>
<div id="reference-good-code">
<div id="reference-good-1str">$id = $_GET['id'];</div>
<div id="reference-good-2str">try {</div>
<div id="reference-good-3str">    $conn = new PDO('mysql:host=localhost;dbname=myDatabase', $username, $password);</div>
<div id="reference-good-4str">    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);</div>
<div id="reference-good-5str">   </div>
<div id="reference-good-6str">    $stmt = $conn->prepare('SELECT * FROM myTable WHERE id = :id');</div>
<div id="reference-good-7str">    $stmt->execute(array('id' => $id));</div>
<div id="reference-good-8str">    </div>
<div id="reference-good-9str">while($row = $stmt->fetch(PDO::FETCH_OBJ)) {</div>
<div id="reference-good-10str">        echo $row->name;</div>
<div id="reference-good-11str">    }</div>
<div id="reference-good-12str">} catch(PDOException $e) {</div>
<div id="reference-good-13str">    echo 'ERROR: ' . $e->getMessage();</div>
<div id="reference-good-14str">}</div>
</div>
</div>
<div id="scheme-annotation">
Ниже представлена обобщенная схема сценариев,
где слева - сценарий приведет к возникновению уязвимости,
а справа - уязвимость будет предотвращена
</div>
EOL;

        $rule = (array('name' => 'SQL',
            'description' => $description));
        return $rule;
    }

}