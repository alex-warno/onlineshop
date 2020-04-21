<?php


namespace Shop;

use Shop\Lib\Config;
use Smarty;

class View extends Smarty
{
    private $messages = [];
    private $errors = [];

    public function __construct()
    {
        parent::__construct();
        $this->template_dir = $_SERVER['DOCUMENT_ROOT'].Config::getConfig('smarty:templates_dir');
        $this->compile_dir = $_SERVER['DOCUMENT_ROOT'].Config::getConfig('smarty:templates_c_dir');
        $this->cache_dir = $_SERVER['DOCUMENT_ROOT'].Config::getConfig('smarty:cache_dir');;
        $this->config_dir = $_SERVER['DOCUMENT_ROOT'].Config::getConfig('smarty:config_dir');
        $this->assign('messages', $this->messages);
        $this->assign('errors', $this->errors);
    }

    public function addMessage($message) {
        array_push($this->messages, $message);
        $this->assign('messages', $this->messages);
    }

    public function addError($message) {
        array_push($this->errors, $message);
        $this->assign('errors', $this->errors);
    }
}