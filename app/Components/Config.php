<?php

namespace App\Components;

/**
 * Helper for working with configs
 * @package App\Components
 */
class Config
{
    private static $config;

    /**
     * Get value from config by key, or default value
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
