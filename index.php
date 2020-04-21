<?php

ini_set('display_errors', 1);
ini_set('error_reporting', -1);

    require_once __DIR__.'/vendor/autoload.php';

    foreach (glob('include/*.php') as $file) {
        require_once $file;
    }


    $app = new \Shop\App();
    $req = empty($_REQUEST['req']) ? '' : $_REQUEST['req'];
    $app->handleRequest($req);
