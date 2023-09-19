<?php

class SessionTools
{
    public static function init()
    {
        if (session_status() === PHP_SESSION_NONE) {
            ob_start("ob_gzhandler");
            session_start();
        }
    }

    public static function set(string $name, $value)
    {
        self::init();
        $_SESSION[$name] = $value;
    }

    public static function get($name)
    {
        self::init();
        return $_SESSION[$name] ?? null;
    }

    public static function destroyByName($name)
    {
        self::init();
        unset($_SESSION[$name]);
    }

    public static function destroy()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }
}
