<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__ . DS . '..' . DS . 'src' . DS);
define('VIEW_DIR', ROOT . 'View' . DS);
define('CONF_DIR', __DIR__ . DS . '..' . DS . 'config' . DS);
define('ADMIN_DIR', VIEW_DIR.'Admin'.DS);

use Controller\ErrorController;
use Framework\AccessDeniedException;
use Framework\Container;
use Framework\RepositoryFactory;
use Framework\Request;
use Framework\Router;
use Framework\Session;
use Framework\UserNotFoundException;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require '../vendor/autoload.php';

try{
    //config
    $config = Symfony\Component\Yaml\Yaml::parse(file_get_contents(CONF_DIR . 'config.yml'));
    $parameters = $config['parameters'];
    $routing = $config['routing'];

    //create request model and start session
    $request = new Request($_GET, $_POST, $_SERVER);
    Session::start();

    //create container and set params from config
    $container = new Container();
    $container->setParameters($parameters);

    // database connection
    $dsn = "mysql: host={$parameters['database_host']}; dbname={$parameters['database_name']}";
    $pdo = new \PDO(
        $dsn,
        $parameters['database_user'],
        $parameters['database_password']
    );
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //ROUTER
    $router = new Router($routing);
    $router->match($request);

    //create objects for container
    $repositoryFactory = new RepositoryFactory();
    $repositoryFactory->setPdo($pdo);

    //twig
    $loader = new FilesystemLoader(VIEW_DIR);
    $twig = new Environment($loader, [
        //'cache' => 'compilation_cache',
    ]);

    $container->set('router', $router);
    $container->set('repository_factory', $repositoryFactory);
    $container->set('twig', $twig);


    $controller = '\\Controller\\'.$router->getCurrentController();
    $action = $router->getCurrentAction();

    $controller = new $controller();
    $controller->setContainer($container);

    if (!method_exists($controller, $action)){
        throw new Exception("{$action} not found.");
    }

    $content = $controller->$action($request);

} catch (\Exception $e){
    dump($e);die();
    $controller = new ErrorController($e);
    $content = $controller->errorAction();
}

echo $content;
