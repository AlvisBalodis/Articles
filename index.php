<?php

use App\Repositories\ArticlesRepository;
use App\Repositories\NewsApiArticlesRepository;
use DI\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use function DI\create;

require_once 'vendor/autoload.php';
session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'App\Controllers\ArticleController@index');
    $r->addRoute('GET', '/articles', 'App\Controllers\ArticleController@index');

    $r->addRoute('GET', '/articles/favorite-articles', 'App\Controllers\ArticleController@create');
    $r->addRoute('POST', '/articles', 'App\Controllers\ArticleController@store');
    $r->addRoute('POST', '/articles/favorite-articles', 'App\Controllers\ArticleController@delete');
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        var_dump('404 Page Not Found');
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        var_dump('405 Method Not Allowed');
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = explode('@', $handler);

        $loader = new FilesystemLoader('app/Views');
        $twig = new Environment($loader);

        $container = new Container();

        $container->set(ArticlesRepository::class, create(NewsApiArticlesRepository::class));

        /** @var App\View $view */
        $view = ($container->get($controller))->$method($vars);

        if ($view) {
            $template = $twig->load($view->getTemplatePath() . '.twig');
            echo $template->render($view->getData());
        }
        break;
}