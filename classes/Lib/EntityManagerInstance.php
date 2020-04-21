<?php


namespace Shop\Lib;


use Doctrine\Common\EventManager;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class EntityManagerInstance extends EntityManager
{
    private static $instance;

    protected function __construct(Connection $conn, Configuration $config, EventManager $eventManager)
    {
        /** конструктор не нужен */
    }

    public function __clone()
    {
        /** клонировать синглтоны тоже не есть хорошо */
    }

    public static function getInstance() {
        if (!self::$instance) {
            $isDevMode = Config::getConfig('doctrine:devMode');
            $entitiesDir = $_SERVER['DOCUMENT_ROOT'].Config::getConfig('doctrine:entities_dir');
            $proxyDir = $_SERVER['DOCUMENT_ROOT'].Config::getConfig('doctrine:proxy_dir');
            $config = Setup::createAnnotationMetadataConfiguration(
                array($entitiesDir),
                $isDevMode,
                $proxyDir,
                null,
                false
            );
            self::$instance = EntityManager::create(Config::getConfig('doctrine:connection'), $config);
        }
        return self::$instance;
    }
}