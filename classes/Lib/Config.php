<?php


namespace Shop\Lib;


class Config
{
    public static $instance;
    private $config;

    /**
     * Инициализируем конфиг
     */
    public static function init() {
        if (!self::$instance) {
            self::$instance = new self();
            $root_dir = defined('__ROOT__') ? __ROOT__ : $_SERVER['DOCUMENT_ROOT'];
            $conf_filename = $root_dir.'/config/config.yml';
            if (file_exists($conf_filename)) {
                self::$instance->config = yaml_parse_file($conf_filename);
            } else {
                die($conf_filename);
            }
        }
    }

    /**
     * Рекурсивно обходит конфиг и возвращает запрашиваемое значение
     * @param $path
     * @return mixed
     */
    public static function getConfig($path) {
        if (!self::$instance) {
            self::init();
        }
        $value = self::$instance->config;
        $path = explode(':', $path);
        foreach ($path as $item) {
            if (key_exists($item, $value)) {
                $value = $value[$item];
            } else {
                die('This path not exist');
            }
        }
        return $value;
    }
}