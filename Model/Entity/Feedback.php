<?php


namespace Model\Entity;


use DateTime;
use Exception;

class Feedback
{
    private $id;
    private $email;
    private $message;
    private $created;

    /**
     * Feedback constructor.
     * @param $email
     * @param $message
     * @throws Exception
     */
    public function __construct($email, $message)
    {
        $this->email = $email;
        $this->message = $message;
        $this->created = new DateTime();
    }

    public function getMySqlCreated(){
        return $this->created->format('Y-m-d H:i:s');
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Feedback
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Feedback
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return Feedback
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     * @return Feedback
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;

        return $this;
    }




}