<?php 
namespace App\Services\Common;
class Request
{
    public static function method($expectedMethod)
    {
        $method = self::server('REQUEST_METHOD');
        return strtoupper($method) === strtoupper($expectedMethod);
    }
    public static function get($key, $default = null)
    {
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

    public static function post($key, $default = null)
    {
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }

    public static function cookie($key, $default = null)
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : $default;
    }

    public static function files($key)
    {
        return isset($_FILES[$key]) ? $_FILES[$key] : null;
    }

    public static function server($key, $default = null)
    {
        return isset($_SERVER[$key]) ? $_SERVER[$key] : $default;
    }
}
