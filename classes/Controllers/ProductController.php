<?php


namespace Shop\Controllers;


use Shop\Lib\Exceptions\NotFoundException;
use Shop\Models\Product;

class ProductController extends AbstractController
{
    protected function registerActions()
    {
        $this->actions = [
            'show'
        ];
    }

    /**
     * @param array $params
     * @throws NotFoundException
     */
    public function show($params = null) {
        if (empty($params[0])) {
            throw new NotFoundException();
        }
        if (!is_numeric($params[0])) {
            throw new NotFoundException();
        }
        /** @var Product $product */
        $product = Product::getById($params[0]);
        if (empty($product)) {
            throw new NotFoundException();
        }
        $path = $this->getPath($product->getSection());

        $this->view->assign('path', $path);
        $this->view->assign('product', $product);
        $this->view->display('product.index.tpl');
    }
}