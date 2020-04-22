<?php

    use Shop\App;

    require_once __DIR__.'/vendor/autoload.php';

    foreach (glob('include/*.php') as $file) {
        require_once $file;
    }


    $app = new App();
    $req = empty($_REQUEST['req']) ? '' : $_REQUEST['req'];
    $app->handleRequest($req);
