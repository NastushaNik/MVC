<?php


namespace Framework;


abstract class Session
{
    const FLASH_KEY = 'flash';

    /**
     * @param string $key
     * @param $value
     */
    public static function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public static function get(string $key, $default = null)
    {
        if (self::has($key)) {
            return $_SESSION[$key];
        }

        return $default;
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @param string $key
     */
    public static function remove(string $key)
    {
        unset($_SESSION[$key]);
    }

    /**
    * destroy
    */
    public static function destroy()
    {
        session_destroy();
    }

    public static function start()
    {
        session_start();
    }

    /**
     * @param string $message
     */
    public static function setFlash(string $message)
    {
        self::set(self::FLASH_KEY, $message);
    }

    /**
     * @return string|null
     */
    public static function getFlash()
    {
        $message = self::get(self::FLASH_KEY);
        self::remove(self::FLASH_KEY);

        return $message;
    }
}