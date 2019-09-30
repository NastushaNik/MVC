<?php


namespace Model\Form;


class FeedbackForm
{
    public $email;
    public $message;

    /**
     * FeedbackForm constructor.
     * @param $email
     * @param $message
     */
    public function __construct($email, $message)
    {
        $this->email = $email;
        $this->message = $message;
    }

    public function isValid()
    {
        return !empty($this->email) && !empty($this->message);
    }


}