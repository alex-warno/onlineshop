<?php


namespace Shop;

use Shop\Lib\Config;
use Smarty;

class View extends Smarty
{
    private $messages = [];
    private $errors = [];

    /**
     * View constructor.
     * @throws Lib\Exceptions\ServerErrorException
     */
    public function __construct()
    {
        parent::__construct();
        $this->template_dir = __ROOT__.Config::getConfig('smarty:templates_dir');
        $this->compile_dir = __ROOT__.Config::getConfig('smarty:templates_c_dir');
        $this->cache_dir = __ROOT__.Config::getConfig('smarty:cache_dir');;
        $this->config_dir = __ROOT__.Config::getConfig('smarty:config_dir');
        $this->assign('messages', $this->messages);
        $this->assign('errors', $this->errors);
    }

    public function addMessage($message) {
        $this->messages[] = $message;
        $this->assign('messages', $this->messages);
    }

    public function addError($message) {
        $this->errors[] = $message;
        $this->assign('errors', $this->errors);
    }
}