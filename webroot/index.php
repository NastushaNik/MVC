<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__ . DS . '..' . DS);
define('VIEW_DIR', ROOT . 'View' . DS);
define('CONF_DIR', ROOT . 'config' . DS);
define('ADMIN_DIR', VIEW_DIR.'Admin'.DS);

use Controller\ErrorController;
use Framework\AccessDeniedException;
use Framework\Container;
use Framework\RepositoryFactory;
use Framework\Request;
use Framework\Router;
use Framework\Session;
use Framework\UserNotFoundException;

require '../vendor/autoload.php';

spl_autoload_register(function ($className){
    $path = ROOT . str_replace('\\', DS, $className);
    $path = "{$path}.php";

    if (!file_exists($path)){
        throw new \Exception("{path} not found");
    }
    require $path;
});

try{
    $request = new Request($_GET, $_POST, $_SERVER);
    Session::start();

    $dbConfig = require CONF_DIR . 'db.php';
    $pdo = new \PDO(
        $dbConfig['dsn'],
        $dbConfig['user'],
        $dbConfig['password']
    );

    $pdo->setAttribute(\PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $container = new Container();
    $router = new Router();
    $repositoryFactory = new RepositoryFactory();

    $container->set('router', $router);
    $container->set('repository_factory', $repositoryFactory);
    $repositoryFactory->setPdo($pdo);

    $controller = $request->get('controller', 'default');
    $action = $request->get('action', 'index');

    $uri = $request->getUri();
    $adminNamespace = strpos($uri, '/mvc/admin') === 0 ? "Admin\\" : '';
    $controller = '\\Controller\\' . $adminNamespace . ucfirst($controller) . 'Controller';

    $controller = new $controller();
    $controller->setContainer($container);

    $controller->setLayout($request);

    $action = $action . 'Action';

    if (!method_exists($controller, $action)){
        throw new Exception("{$action} not found.");
    }

    $content = $controller->$action($request);

} catch (\Exception $e){
    $controller = new ErrorController($e);
    $content = $controller->errorAction();
}

echo $content;
