<?php


namespace Shop\Controllers;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Shop\Models\Cart;
use Shop\Models\Section;
use Shop\View;

abstract class AbstractController
{
    protected $actions = [];
    protected $view;

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function init() {
        $this->registerActions();
        $this->view = new View();

        /** @var Cart $cart */
        /** проверка существования заказа у клиента */
        if (isset($_COOKIE['cart_id'])) {
            $cart = Cart::get(['hashId' => $_COOKIE['cart_id']]);
            if (empty($cart[0])) {
                unset($_COOKIE['cart_id']);
            } else {
                $cart = $cart[0];
                if ($cart->getStatus() !== 'new') {
                    unset($_COOKIE['cart_id']);
                }
            }
        }

        /** если заказ не существует, сотворим его */
        if (!isset($_COOKIE['cart_id'])) {
            /** @var Cart $cart */
            $hashId = uniqid();
            $cart = Cart::create();
            $cart->setHashId($hashId);
            $cart->save();
            setcookie('cart_id', $hashId, time() + 604800, '/');
        }

        $this->view->assign('cart', $cart);
    }

    protected abstract function registerActions();

    /**
     * @return array
     */
    public function getActions() {
        return $this->actions;
    }

    /**
     * @param string $url
     */
    protected function redirect($url) {
        header("Location: $url");
        die();
    }

    /**
     * @param Section $section
     * @return array
     */
    protected function getPath($section) {
        $path[] = $section;
        if (!$section) {
            return [];
        }
        while ($section->getParent() > 0) {
            $section = Section::getById($section->getParent());
            $path[] = $section;
        }
        return array_reverse($path);
    }
}