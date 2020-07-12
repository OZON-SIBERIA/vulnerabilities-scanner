<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/vendor/autoload.php';


$entityManager = \App\Config::entityManager();
return ConsoleRunner::createHelperSet($entityManager);