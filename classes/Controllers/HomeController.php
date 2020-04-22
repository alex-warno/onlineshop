<?php


namespace Shop\Controllers;

use Doctrine\ORM\ORMException;
use Shop\Lib\Config;
use Shop\Lib\Exceptions\ServerErrorException;
use Shop\Models\Product;
use Shop\Models\Section;

class HomeController extends AbstractController
{
    protected function registerActions()
    {
        $this->actions = [
            'index'
        ];
    }

    /**
     * @throws ServerErrorException
     * @throws ORMException
     */
    public function index() {
        $page = 1;
        $section_id = 1;
        $limit = Config::getConfig('itemsOnPage');
        $products = [];

        if (isset($_GET['page'])) {
            if (is_numeric($_GET['page'])) {
                $page = $_GET['page'];
            }
        }

        /** @var Section $section */
        if (isset($_GET['sect'])) {
            $section = Section::get(['tag'=>$_GET['sect']]);
            if (!empty($section[0])) {
                $section = $section[0];
                $section_id = $section->getId();
                $products = $section->getProducts($limit * ($page - 1), $limit);
            }
            $url = '/?sect='.$_GET['sect'].'&';
        } else {
            $section = Section::getById($section_id);
            $products = Product::get([], ['name'=>'ASC'], $limit, $limit * ($page  - 1));
            $url = '/?';
        }
        $sections = Section::get(['parent' => $section_id]);
        $path = $this->getPath($section);
        $pages_count = count($section->getProducts(0, null)) / $limit;

        $this->view->assign('url', $url);
        $this->view->assign('pages', $pages_count);
        $this->view->assign('path', $path);
        $this->view->assign('sections', $sections);
        $this->view->assign('products', $products);
        $this->view->display('home.index.tpl');
    }
}