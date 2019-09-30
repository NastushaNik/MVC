<?php


namespace Controller;

use Framework\Controller;
use Framework\Request;
use Framework\Router;
use Framework\Session;
use Model\Entity\Feedback;
use Model\Form\FeedbackForm;
use Model\Repository\FeedbackRepository;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('index.html.twig');

    }

    public function feedbackAction(Request $request)
    {
        $form = new FeedbackForm(
            $request->post('email'),
            $request->post('message')
        );

        if ($request->isPost()){
            if ($form->isValid()){
                $feedback = new Feedback(
                    $form->email,
                    $form->message
                );
                (new FeedbackRepository)->save($feedback);

                Session::setFlash('Saved.');

                $this
                    ->container
                    ->get('router')
                    ->redirect('/mvc/feedback');
            }

            Session::setFlash('Invalid form.');
        }

        return $this->render('feedback.html.twig', ['form' => $form]);
    }
}