<?php


namespace Shop\Controllers;


use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Shop\Lib\EntityManagerInstance;
use Shop\Lib\Exceptions\BadRequestException;
use Shop\Lib\Exceptions\NotFoundException;
use Shop\Lib\MailSender;
use Shop\Models\Cart;
use Shop\Models\Cart_Product;
use Shop\Models\Product;

class CartController extends AbstractController
{
    protected function registerActions() {
        $this->actions = [
            'index',
            'addProduct',
            'deleteProduct',
            'checkout',
            'confirm'
        ];
    }

    /**
     * @throws BadRequestException
     */
    public function index() {
        /** @var Cart $cart */
        $this->view->display('cart.index.tpl');
    }

    /**
     * @param array $params
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addProduct($params = null) {
        $product = $this->validateRequest($params);
        $cart = Cart::get(['hashId' => $_COOKIE['cart_id']])[0];
        $cProduct = Cart_Product::get(['cart' => $cart, 'product' => $product]);
        if (empty($cProduct[0])) {
            $cProduct = Cart_Product::create();
            $cProduct->setCart($cart);
            $cProduct->setProduct($product);
            $cProduct->setAmount($_POST['count']);
            $count = $cProduct->getAmount();
            $sum = $product->getPrice() * $cProduct->getAmount();
        } else {
            $cProduct = $cProduct[0];
            $cProduct->setAmount($cProduct->getAmount() + $_POST['count']);
            $count = count($cart->getProducts());
            $sum = $cart->getSum();
        }
        $cProduct->save();
        $product->setAmount($product->getAmount() - $_POST['count']);
        $product->save();
        $result = [
            'success' => true,
            'cart' => [
                'count' => $count,
                'sum' => $sum,
                'product_amount' => $cProduct->getAmount(),
                'product_id' => $product->getId()
            ]
        ];
        echo json_encode($result);
    }

    /**
     * @param array $params
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteProduct($params = null) {
        $product = $this->validateRequest($params);
        /** @var Cart $cart */
        $cart = Cart::get(['hashId' => $_COOKIE['cart_id']])[0];
        $cProduct = Cart_Product::get(['cart' => $cart, 'product' => $product]);
        if (empty($cProduct[0])) {
            echo json_encode(['error' => 'Товар не существует']);
            die();
        }
        /** @var Cart_Product $cProduct */
        $cProduct = $cProduct[0];
        $cProduct->setAmount($cProduct->getAmount() - $_POST['count']);
        $product->setAmount($product->getAmount() + $_POST['count']);
        $cProduct->save();
        $product->save();
        $cart->save();
        $result = [
            'success' => true,
            'cart' => [
                'count' => count($cart->getProducts()),
                'sum' => $cart->getSum(),
                'product_amount' => $cProduct->getAmount(),
                'product_id' => $product->getId()
            ]
        ];
        if ($cProduct->getAmount() < 1) {
            $cProduct->delete();
        }
        echo json_encode($result);
    }

    /**
     * @param array $params
     * @return Product
     */
    private function validateRequest($params = null): Product {
        if (empty($params[0])) {
            echo json_encode(['error' => 'Страница не найдена']);
            die();
        }
        if (!is_numeric($params[0])) {
            echo json_encode(['error' => 'Страница не найдена']);
            die();
        }
        if (empty($_POST['count'])){
            echo json_encode(['error' => 'Количество товаров не передано']);
            die();
        }
        if (!is_numeric($_POST['count']) || $_POST['count'] < 1) {
            echo json_encode(['error' => 'Количество товаров не передано']);
            die();
        }
        /** @var Product $product */
        $product = Product::getById($params[0]);
        if (!$product) {
            echo json_encode(['error' => 'Товар не существует']);
            die();
        }
        if ($product->getAmount() < $_POST['count']) {
            echo json_encode(['error' => 'Товар закончился']);
            die();
        }

        return $product;
    }

    public function checkout() {
        if (isset($_POST['submit'])) {
            $cart = Cart::get(['hashId' => $_COOKIE['cart_id']])[0];
            $cart->updateFromRequest($_POST);
            $errors = $cart->validate();
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $this->view->addError($error);
                }
            } else {
                $cart->setStatus('confirmed');
                $cart->save();
                MailSender::sendConfirmMails($cart);
                $this->redirect('/cart/confirm/'.$cart->getId().'/');
            }
        }
        $this->view->display('cart.checkout.tpl');
    }

    public function confirm($params = null) {
        if (!isset($params[0])) {
            throw new NotFoundException();
        }
        if (!is_numeric($params[0])) {
            throw new NotFoundException();
        }
        $cart = Cart::getById($params[0]);
        if (empty($cart)) {
            throw new NotFoundException();
        }
        $cProducts = $cart->getCartProducts();

        $this->view->assign('cProducts', $cProducts);
        $this->view->assign('confirmedCart', $cart);
        $this->view->display('cart.confirm.tpl');
    }
}