<?php

namespace App\Components;

/**
 * Class ConfigService
 * @package App\Services
 */
class Config
{
    private static $config;

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        if (is_null(self::$config)) {
            self::$config = require_once(__DIR__ . '/../../config.php');
        }

        return !empty(self::$config[$key]) ? self::$config[$key] : $default;
    }
}
