<?php


namespace Framework;


class Request
{

    private $get = [];
    private $post = [];
    private $server = [];

    /**
     * Request constructor.
     * @param array $get
     * @param array $post
     * @param $server
     */
    public function __construct(array $get, array $post, $server)
    {
        $this->get = $get;
        $this->post = $post;
        $this->server = $server;

    }

    public function get($key, $default = null)
    {
        return isset($this->get[$key]) ? $this->get[$key]: $default;
    }

    public function post($key, $default = null)
    {
        return isset($this->post[$key]) ? $this->post[$key]: $default;
    }

    public function server($key, $default = null)
    {
        return isset($this->server[$key]) ? $this->server[$key]: $default;
    }

    public function isPost()
    {
        return (bool) $this->post;
    }

    public function getUri()
    {
        $uri = $this->server('REQUEST_URI');
        $uri = explode('?', $uri);
        return $uri[0];
    }
}