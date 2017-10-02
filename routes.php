<?php

require 'vendor/autoload.php';

foreach (glob("application/controllers/*.php") as $filename)
 {
         require_once $filename;

 }
 if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;    // serve the requested resource as-is.
}{
    $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'LoadViewsController/loginUser');
    $r->addRoute('POST', '/loginprocess', 'ProcessLoginController/processLogin');
    $r->addRoute('POST', '/logout', 'ProcessLoginController/processLogout');
    $r->addRoute('GET', '/page', 'LoadViewsController/loadPage');
    $r->addRoute('GET', '/page_1', 'LoadViewsController/loadPage');
    $r->addRoute('GET', '/page_2', 'LoadViewsController/loadPage');
    $r->addRoute('GET', '/page_3', 'LoadViewsController/loadPage');
    $r->addRoute('GET', '/user', 'ApiController/processData');
    $r->addRoute('POST', '/user', 'ApiController/processData');
    $r->addRoute('PUT', '/user/{id:\d+}', 'ApiController/processData');
    $r->addRoute('DELETE', '/user/{id:\d+}', 'ApiController/processData');
    // {id} must be a number (\d+)
       // The /{title} suffix is optional
    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        die("404 Not Found");
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
         die("405 Method Not Allowed");
        break;
    case FastRoute\Dispatcher::FOUND:
        
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        list($class, $method) = explode("/", $handler, 2);
        call_user_func_array(array(new $class, $method), $vars);
        // ... call $handler with $vars
        break;
}
} 
