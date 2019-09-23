<?php


namespace Framework;

use Exception;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    protected $container;

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected function render($view, array $args = [])
    {

        $loader = new FilesystemLoader(VIEW_DIR);
        $twig = new Environment($loader, [
            //'cache' => 'compilation_cache',
        ]);

        $path =  str_replace('Controller', '', get_class($this));
        $path = trim($path, '\\');
        $path = str_replace('\\', DS, $path);
        $file = $path . DS . $view;

        return $twig->render($file, $args);

    }
}