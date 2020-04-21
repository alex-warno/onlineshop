<?php


namespace Shop\Controllers;


use Doctrine\Common\Collections\Criteria;
use Shop\Lib\Config;
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
     *
     */
    public function index() {
        $page = 1;
        $section_id = 1;
        $limit = Config::getConfig('itemsOnPage');
        $products = [];

        /** @var Section $section */
        if (isset($_GET['sect'])) {
            $section = Section::get(['tag'=>$_GET['sect']]);
            if (!empty($section[0])) {
                $section = $section[0];
                $section_id = $section->getId();
                $products = $section->getProducts($limit * ($page - 1), $limit);
            }
        } else {
            $section = Section::getById($section_id);
            $products = Product::get([], ['name'=>'ASC'], $limit, $limit * ($page  - 1));
        }
        $sections = Section::get(['parent' => $section_id]);
        $path = $this->getPath($section);
        $pages_count = count($section->getProducts(0, null)) / $limit;

        if (isset($_GET['page'])) {
            if (is_numeric($_GET['page'])) {
                $page = $_GET['page'];
            }
        }

        $this->view->assign('pages', $pages_count);
        $this->view->assign('path', $path);
        $this->view->assign('sections', $sections);
        $this->view->assign('products', $products);
        $this->view->display('home.index.tpl');
    }
}