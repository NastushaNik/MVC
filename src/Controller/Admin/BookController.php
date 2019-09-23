<?php


namespace Controller\Admin;


use Framework\Controller;
use Framework\Request;
use Model\Repository\BookRepository;

class BookController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('index.html.twig');
    }

    public function showAction(Request $request)
    {
        return $this->render('show.html.twig');
    }

    public function editAction(Request $request)
    {
        return $this->render('show.html.twig');
    }

    public function createAction(Request $request)
    {
        return $this->render('show.html.twig');
    }
}