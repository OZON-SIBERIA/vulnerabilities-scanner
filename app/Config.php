<?php

namespace App;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;

class Config
{
    private static $entityManager = null;

    /**
     * @return EntityManager
     * @throws ORMException
     */
    public static function entityManager()
    {
        if (self::$entityManager === null) {

            $config = Setup::createAnnotationMetadataConfiguration(
                [__DIR__ . '/Entities'],
                /* isDevMode */ true,
                /* proxyDir */ null,
                /* cache */ null,
                /* useSimpleAnnotationReader */ false
            );

            $conn = [
                'driver' => 'pdo_mysql',
                'user'     => 'master-work-user',
                'password' => '122435606',
                'dbname'   => 'master_work',
                'host' => 'localhost:3306',

            ];
            self::$entityManager = EntityManager::create($conn, $config);
        }
        return self::$entityManager;
    }
}
