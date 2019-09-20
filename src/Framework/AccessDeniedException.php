<?php


namespace Framework;


use Exception;

class AccessDeniedException extends Exception
{

    /**
     * AccessDeniedException constructor.
     */
    public function __construct()
    {
        parent::__construct('Access denied');
    }
}