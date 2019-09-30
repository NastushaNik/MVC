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
                foreach ($route['parameters'] as $name => $regex){
                    $pattern = str_replace(
                        '{' . $name . '}',
                        '(' . $regex . ')',
                        $pattern
                    );
                }
            }

            $pattern = '@^' . $pattern . '$@'; // @ - delimiter.

            if (preg_match($pattern, $uri, $matches)){
                array_shift($matches);

                if (!empty($route['parameters'])){
                    $result = array_combine(
                        array_keys($route['parameters']),
                        $matches
                    );
                    $request->mergeGetWithArray($result);
                }
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