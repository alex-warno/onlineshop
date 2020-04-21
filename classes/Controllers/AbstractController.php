<?php


namespace Shop\Controllers;


use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Shop\Lib\EntityManagerInstance;
use Shop\Models\Cart;
use Shop\Models\Section;
use Shop\View;

abstract class AbstractController
{
    protected $actions = [];
    protected $view;

    /**
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
        if (!isset($_COOKIE['cart_id']) && !isset($_POST['cart_id'])) {
            /** @var Cart $cart */
            $cart = Cart::create();
            $cart->setHashId(uniqid());
            $cart->save();
            setcookie('cart_id', $cart->getHashId(), '/', 604800);
        }

        $this->view->assign('cart', $cart);
    }

    /**
     * @return mixed
     */
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