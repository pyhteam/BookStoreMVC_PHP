<?php 
namespace App\Services\Common;
class Session
{
    public static function start()
    {
        session_start();
    }
    // Authozize
    public static function Authorize($role = "Admin")
    {
        $user = self::get('user');
        $timeout = self::get('timeout');
        if ($user == null || $timeout == null) {
            return false;
        }
        if (time() > $timeout) {
            self::destroy();
            return false;
        }
        $roleName = self::get('role');
        if ($roleName!= $role) {
            return false;
        }
        return true;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function remove($key)
    {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy()
    {
        session_unset();
        session_destroy();
    }
}
