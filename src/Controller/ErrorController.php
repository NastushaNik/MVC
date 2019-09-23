<?php


namespace Controller;


use Framework\Controller;
use Framework\Request;
use Framework\Session;
use Framework\Router;

class ErrorController extends Controller
{
    private $exception;

    /**
     * ErrorController constructor.
     * @param $exception
     */
    public function __construct(\Exception $exception)
    {
        $this->exception = $exception;
    }


    public function error404Action(Request $request)
    {
        return $this->render('error404.html.twig');

    }

    public function errorAction()
    {
        $message = $this->exception->getMessage();

        return $this->render('error.html.twig', ['message' => $message]);
    }

}