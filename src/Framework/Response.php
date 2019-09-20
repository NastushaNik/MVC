<?php


namespace Framework;


class Response
{
    private $body;

    /**
     * Response constructor.
     * @param $body
     */
    public function __construct($body)
    {
        $this->body = $body;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string) $this->body;
    }


}