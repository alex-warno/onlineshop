<?php


namespace Shop\Lib;


use Shop\Lib\Exceptions\ServerErrorException;

class Config
{
    public static $instance;
    private $config = [];

    /**
     * Инициализируем конфиг
     */
    public static function init() {
        if (!self::$instance) {
            self::$instance = new self();
            foreach (glob(__ROOT__.'/config/*.yml') as $file) {
                $content = yaml_parse_file($file);
                if (!!$content) {
                    self::$instance->config = array_merge(self::$instance->config, $content);
                }
            }
        }
    }

    /**
     * Рекурсивно обходит конфиг и возвращает запрашиваемое значение
     * @param $path
     * @return mixed
     * @throws ServerErrorException
     */
    public static function getConfig($path) {
        if (!self::$instance) {
            self::init();
        }
        $value = self::$instance->config;
        $path_array = explode(':', $path);
        foreach ($path_array as $item) {
            if (key_exists($item, $value)) {
                $value = $value[$item];
            } else {
                throw new ServerErrorException('Конфигурация не найдена');
            }
        }
        return $value;
    }
}