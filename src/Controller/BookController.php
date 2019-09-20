<?php


namespace Controller;
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

        return $this->render('index.phtml', [
            'books' => $books
        ]);
    }

    public function showAction(Request $request)
    {
        $id = $request->get('id');
        $repository = $factory = $this
            ->container
            ->get('repository_factory')
            ->createRepository('Book')
        ;

        $book = $repository->find($id);

        return $this->render('show.phtml', [
            'book' => $book
        ]);
    }

}