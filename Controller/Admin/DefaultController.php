<?php


namespace Controller\Admin;


use Framework\AccessDeniedException;
use Framework\Controller;
use Framework\Request;
use Framework\Session;
use Model\Entity\User;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        if (!Session::has('user')) {
            throw new AccessDeniedException();
        }

        return $this->render('index.phtml');
    }
}