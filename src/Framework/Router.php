<?php


namespace Framework;


class Router
{
    public function redirect($to)
    {
        header("Location: {$to}");
        die();
    }
}