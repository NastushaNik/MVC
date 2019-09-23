<?php


namespace Framework;


class Container implements ContainerInterface
{

    private $objects = [];
    private $parameters = [];

    private function getParameter($key)
    {
        return $this->getValue($this->$parameters, $key);
    }

    public function setParameters(array $array)
    {
        $this->parameters = $array;
    }

    public function get($key)
    {
        // TODO: Implement get() method.
        return $this->getValue($this->objects, $key);
    }

    /**
     * @param $key
     * @param $object
     */
    public function set($key, $object): void
    {
        $this->objects[$key] = $object;
    }

    private function getValue(array $array, $key)
    {
        if (isset($array[$key])){
            return $array[$key];
        }
        return null;
    }


}