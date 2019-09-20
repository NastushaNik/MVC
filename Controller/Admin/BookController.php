<?php


namespace Controller\Admin;


use Framework\Controller;
use Framework\Request;
use Model\Repository\BookRepository;

class BookController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('index.phtml');
    }

    public function showAction(Request $request)
    {
        return $this->render('show.phtml');
    }

    public function editAction(Request $request)
    {
        return $this->render('show.phtml');
    }

    public function createAction(Request $request)
    {
        return $this->render('show.phtml');
    }
}