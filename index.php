<?php 
require_once("./vendor/autoload.php");

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use App\Controllers\PagesController;
use App\Controllers\ProductController;

try {
    // 1. Define your array of routes
    $locator = new FileLocator(__DIR__);
    $yamlLoader = new YamlFileLoader($locator);
    $routes = $yamlLoader->load('routes.yaml');

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
} catch (MethodNotAllowedException $exception) {
    print_r($exception->getMessage());
    echo "<h1>An error occurred</h1>";
}

