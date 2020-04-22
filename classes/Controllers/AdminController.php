<?php


namespace Shop\Controllers;



use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use finfo;
use Shop\Lib\Config;
use Shop\Lib\Exceptions\BadRequestException;
use Shop\Lib\Exceptions\ServerErrorException;
use Shop\Models\Product;
use Shop\Models\Section;

/**
 * Одна из самых костыльных админок на свете. мегапростейшая проверка логина/пароля,
 * их хранение в конфиге в чистом виде, чуть меньше чем полное отсутствие валидации...
 * Кошмар... Какой я извращенец...(простите)
 * Собственно этого куска не было в тз=)
 * Контроллер написан только для упрощения заполнения БД фикстурами
 *
 * Class AdminController
 * @package Shop\Controllers
 */
class AdminController extends AbstractController
{
    protected function registerActions()
    {
        $this->actions = [
            'index',
            'login',
            'addsection',
            'addproduct'
        ];
    }

    public function checkAuth() {
        session_start();
        if (!isset($_SESSION['admin_auth'])) {
            $this->view->display('admin.auth.tpl');
            die();
        }
    }

    /**
     *
     */
    public function index() {
        $this->checkAuth();
        $this->view->display('admin.index.tpl');
    }

    /**
     * @throws BadRequestException
     * @throws ServerErrorException
     */
    public function login() {
        if (!isset($_POST['login']) && !isset($_POST['password'])) {
            throw new BadRequestException();
        }
        if ($_POST['login'] == Config::getConfig('admin_credentials:login')
            && $_POST['password'] == Config::getConfig('admin_credentials:password')) {
            session_start();
            $_SESSION['admin_auth'] = true;
        }
        $this->redirect('/admin/');
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws ServerErrorException
     */
    public function addsection() {
        $this->checkAuth();
        if (
            isset($_POST['tag']) &&
            isset($_POST['humanName']) &&
            isset($_POST['parent']) &&
            isset($_FILES['image'])
        ) {
            $dir = __ROOT__.Config::getConfig('sectionsImageDir');
            $filename = $this->imageUpload($_FILES['image'], $dir);
            if (!empty($filename)) {
                /** @var Section $section */
                $section = Section::create();
                $section->setImageFile($filename);
                $section->updateFromRequest($_POST);
                $section->save();
                $this->view->addMessage("Раздел добавлен");
            }
        }
        $sections = Section::get();
        $this->view->assign('sections', $sections);
        $this->view->display('admin.addsection.tpl');
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws ServerErrorException
     */
    public function addproduct() {
        $this->checkAuth();
        if (
            isset($_POST['name']) &&
            isset($_POST['description']) &&
            isset($_POST['price']) &&
            isset($_POST['amount']) &&
            isset($_FILES['image'])
        ) {
            $dir = __ROOT__ . Config::getConfig('productsImgDir');
            $filename = $this->imageUpload($_FILES['image'], $dir);
            if (!empty($filename)) {
                /** @var Product $product */
                $product = Product::create();
                $product->setImagefile($filename);
                $product->updateFromRequest($_POST);
                $product->save();
                $this->view->addMessage('Товар добавлен');
            }
        }
        $sections = Section::get();
        $this->view->assign('sections', $sections);
        $this->view->display('admin.addproduct.tpl');
    }

    /**
     * @param $file
     * @param $uploadDir
     * @return string|null
     * @throws ServerErrorException
     */
    private function imageUpload($file, $uploadDir) {
        $tmpfilename = $file['tmp_name'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (
            false !== array_search($finfo->file($tmpfilename), Config::getConfig('allowedFiles')) &&
            $file['size'] <= 5000000
        ) {
            $uploadFile = $uploadDir . uniqid();
            if (move_uploaded_file($tmpfilename, $uploadFile)) {
                return basename($uploadFile);
            } else {
                $this->view->addError('Ошибка загрузки файла');
            }
        } else {
            $this->view->addError('Попытка загрузки некорректного файла');
        }
        return null;
    }
}