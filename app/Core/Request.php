<?php

namespace Core;

class Request
{
    private static $TF = [
            'true'=>true,
            'false'=>false
        ];
    static function post($key, $def = null) {
        return (isset($_POST[$key]))
            ? array_key_exists($_POST[$key], Request::$TF)
                ? Request::$TF[$_POST[$key]]
                : $_POST[$key]
            : $def;
    }
    static function get($key, $def = null) {
        return (isset($_GET[$key]))
            ? array_key_exists($_GET[$key], Request::$TF)
                ? Request::$TF[$_GET[$key]]
                : $_GET[$key]
            : $def;
    }

    static function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    static function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }
}
