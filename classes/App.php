<?php


namespace Shop;


use Shop\Lib\Exceptions\NotFoundException;

class App
{
    /**
     * @param $re
     * @throws NotFoundException
     */
    public function handleRequest($re) {
        $route = explode('/', $re);

        $controller_name = 'Home';
        if (!empty($route[0])) {
            $controller_name = ucfirst(array_shift($route));
        }
        $controller_name = 'Shop\\Controllers\\'.$controller_name.'Controller';

        $action_name = 'index';
        if (!empty($route[0])) {
            $action_name = array_shift($route);
        }

        if (class_exists($controller_name)) {
            $controller = new $controller_name;
        } else {
            throw new NotFoundException();
        }

        $controller->init();

        if (in_array($action_name, $controller->getActions())) {
            $controller->$action_name($route);
        } else {
            throw new NotFoundException();
        }
    }
}