<?php 
require_once("./vendor/autoload.php");

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use App\Controllers\PagesController;
use App\Controllers\ProductController;

try {
    // 1. Define your array of routes
    $routes = new RouteCollection();

    // 2. Define your individual routes
    $homeRoute = new Route('/', ['controller' => 'App\Controllers\PagesController@home']);
    $aboutRoute = new Route('/about', ['controller' => 'App\Controllers\PagesController@about']);
    $productRoute = new Route('/product/{id}/animal/{userId}', ['controller' => 'App\Controllers\ProductController@getProduct'], ['id' => '[0-9]+', 'userId' => '[0-9]+']);

    // 3. Add routes to your array of routes
    $routes->add('home_route', $homeRoute);
    $routes->add('about_route', $aboutRoute);
    $routes->add('product_route', $productRoute);

    // 4. Create request context
    $context = new RequestContext();
    $context->fromRequest(Request::createFromGlobals());


    $matcher = new UrlMatcher($routes, $context);
    $parameters = $matcher->match($context->getPathInfo()); //
    unset($parameters["_route"]);
    $controllerInfo = $parameters['controller'];
    $controllerArray = explode('@', $controllerInfo);
    $controller = $controllerArray[0];
    $method = $controllerArray[1];
    unset($parameters['controller']);
    $controllerInstance = new $controller();
    call_user_func_array([$controllerInstance, $method], $parameters);
} catch (ResourceNotFoundException $e) {
    echo "<h1>Route not found</h1>";
} catch (Exception $exception) {
    echo "<h1>An error occurred</h1>";
}

