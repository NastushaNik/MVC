<?php


namespace Controller\Admin;


use Framework\Controller;
use Framework\Request;
use Model\Repository\BookRepository;

class BookController extends Controller
{
    public function indexAction(Request $request)
    {
        $repository = $factory = $this
            ->container
            ->get('repository_factory')
            ->createRepository('Book')
        ;

        $books = $repository->findAll();

        return $this->render('index.html.twig', [
            'books' => $books
        ]);
    }

    public function editAction(Request $request)
    {
        $id = $request->get('id');
        $repository = $factory = $this
            ->container
            ->get('repository_factory')
            ->createRepository('Book')
        ;

        $book = $repository->find($id);

        return $this->render('edit.html.twig', [
            'book' => $book
        ]);
    }

    public function createAction(Request $request)
    {
        return $this->render('show.html.twig');
    }
}