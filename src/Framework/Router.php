<?php


namespace Framework;


use mysql_xdevapi\Exception;

class Router
{
    private $routes;
    private $currentRoute;

    /**
     * Router constructor.
     * @param $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }


    public function redirect($to)
    {
        header("Location: {$to}");
        die();
    }

    public function match(Request $request)
    {
        $uri = $request->getUri();
        $routes = $this->routes;

        foreach ($routes as $route){
            $pattern = $route['pattern'];

            if (!empty($route['parameters'])){
                foreach (){

                }
            }

            if ($pattern == $uri){
                $this->currentRoute = $route;
                return;
            }
        }

        throw new \Exception('Page not found', 404);

    }

    public function getCurrentController()
    {
        return $this->getCurrentRouteAttr('controller');
    }

    public function getCurrentAction()
    {
        return $this->getCurrentRouteAttr('action');
    }

    private function getCurrentRouteAttr($key)
    {
        if (!$this->currentRoute){
            return null;
        }

        return $this->currentRoute[$key];
    }

}