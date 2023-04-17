<?php

class SessionTools
{

    public static function gzhandler()
    {
        if (!ob_start("ob_gzhandler"))
            ob_start();
    }

    public static function init()
    {
        if (!isset($_SESSION)) {
            self::gzhandler();
            session_start();
        }
    }

    public static function set(string $name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public static function get($name)
    {
        return @$_SESSION[$name];
    }

    public static function destroyByName($name)
    {
        unset($_SESSION[$name]);
    }

    public static function destroy()
    {
        if (isset($_SESSION)) {
            session_destroy();
            session_unset();
        }
    }
}
