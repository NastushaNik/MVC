<?php


namespace Controller;


use Framework\AccessDeniedException;
use Framework\Controller;
use Framework\Request;
use Framework\Session;
use Framework\UserNotFoundException;
use Model\Entity\User;
use Model\Form\LoginForm;

class SecurityController extends Controller
{

    /**
     * @throws \Exception
     */
    public function loginAction(Request $request)
    {
        error_reporting(E_ALL);

        $form = new LoginForm(
            $request->post('email'),
            $request->post('password')
        );

        $container = $this->container;

        if ($request->isPost()){
            if ($form->isValid()){
                $user = $container
                    ->get('repository_factory')
                    ->createRepository('User')
                    ->findByEmail($form->email)
                    ;

                try {
                    if (!$user) {
                        throw new UserNotFoundException();
                    }
                    $this->verify($form->password, $user);

                } catch (UserNotFoundException $e) {
                    Session::setFlash($e->getMessage());

                    $container
                        ->get('router')
                        ->redirect('/sign-in');
                }

                Session::set('user', $user->getEmail());
                $container->get('router')->redirect('/mvc/admin');
            }

            Session::setFlash('Invalid form');

        }

        return $this->render('login.html.twig', ['form' => $form]);
    }


    /**
     * @throws UserNotFoundException
     */
    private function verify($password, User $user)
    {
        $result = password_verify($password, $user->getPassword());
        if ($result) {
            return true;
        }
        throw new UserNotFoundException();
    }

    public function logoutAction()
    {
        Session::remove('user');
        $this->container->get('router')->redirect('/mvc');
    }

    public function changePasswordAction(){

    }

    public function registerAction(){

    }

    public function activateAccountAction(){

    }
}