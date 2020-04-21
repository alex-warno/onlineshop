<?php
    use Doctrine\ORM\Tools\Setup;
    use Doctrine\ORM\EntityManager;
    use Shop\Lib\Config;

    require_once __ROOT__."/vendor/autoload.php";

    $isDevMode = Config::getConfig('doctrine:devMode');
    $entitiesDir = __ROOT__.Config::getConfig('doctrine:entities_dir');
    $config = Setup::createAnnotationMetadataConfiguration(
        array($entitiesDir),
        $isDevMode,
        null,
        null,
        false
    );

    try {
        $entityManager = EntityManager::create(Config::getConfig('doctrine:connection'), $config);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
