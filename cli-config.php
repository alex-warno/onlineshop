<?php

    use Doctrine\ORM\Tools\Console\ConsoleRunner;

    if (!defined('__ROOT__')) {
        define('__ROOT__', __DIR__);
    }

    require_once 'cli/bootstrap.php';

    return ConsoleRunner::createHelperSet($entityManager);