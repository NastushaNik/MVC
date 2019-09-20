<?php


namespace Controller;


use Framework\Controller;
use Framework\Request;
use Framework\Session;

class CartController extends Controller
{
    public function indexAction(Request $request)
    {
        $currentCart = Session::get('cart', []);
        //dump($currentCart);
        $cartCount = array_count_values($currentCart);
        $currentCart = array_values(array_unique($currentCart));
        $cart = $this
            ->container
            ->get('repository_factory')
            ->createRepository('Book')
            ->findByIds($currentCart)
        ;

        return $this->render('index.phtml', ['cart' => $cart, 'cartCount' => $cartCount]);
    }

    public function addToCartAction(Request $request)
    {
        $id = $request->get('id');

        //todo: Separate class CartService
        //todo: Count books in cart

        $currentCart = Session::get('cart', []);
        $currentCart[] = $id;

        Session::set('cart', $currentCart);
        $this->container->get('router')->redirect('/mvc/index.php?controller=book&action=index');
    }

    public function removeFromCartAction()
    {

    }

    public function clearCartAction()
    {

    }

}