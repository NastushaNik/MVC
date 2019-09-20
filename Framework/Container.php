<?php


namespace Framework;


class Container implements ContainerInterface
{

    private $objects = [];

    public function get($key)
    {
        // TODO: Implement get() method.
        if (isset($this->objects[$key])){
            return $this->objects[$key];
        }
        return null;
    }

    /**
     * @param $key
     * @param $object
     */
    public function set($key, $object): void
    {
        $this->objects[$key] = $object;
    }


}