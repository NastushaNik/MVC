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
    //twig
    $loader = new FilesystemLoader(VIEW_DIR);
    $twig = new Environment($loader, [
        //'cache' => 'compilation_cache',
        ]);

    $config = Symfony\Component\Yaml\Yaml::parse(file_get_contents(CONF_DIR . 'config.yml'));
    $parameters = $config['parameters'];

    $request = new Request($_GET, $_POST, $_SERVER);
    Session::start();

    $dsn = "mysql: host={$parameters['database_host']}; dbname={$parameters['database_name']}";
    $pdo = new \PDO(
        $dsn,
        $parameters['database_user'],
        $parameters['database_password']
    );

    $pdo->setAttribute(\PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $container = new Container();
    $container->setParameters($parameters);
    $router = new Router();
    $repositoryFactory = new RepositoryFactory();

    $container->set('router', $router);
    $container->set('repository_factory', $repositoryFactory);
    $container->set('twig', $twig);
    $repositoryFactory->setPdo($pdo);

    $controller = $request->get('controller', 'default');
    $action = $request->get('action', 'index');

    $uri = $request->getUri();
    $adminNamespace = strpos($uri, '/mvc/admin') === 0 ? "Admin\\" : '';
    $controller = '\\Controller\\' . $adminNamespace . ucfirst($controller) . 'Controller';

    $controller = new $controller();
    $controller->setContainer($container);

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
