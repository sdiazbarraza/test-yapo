<?php

require 'vendor/autoload.php';

foreach (glob("application/controllers/*.php") as $filename)
 {
         include $filename;

 }
 if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;    // serve the requested resource as-is.
}{
    $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'LoadViewsController/loginUser');
    $r->addRoute('POST', '/loginprocess', 'ProcessController/processLogin');
    $r->addRoute('GET', '/page', 'LoadViewsController/loadPage');
    $r->addRoute('GET', '/user', 'ProcessController/processRead');
    $r->addRoute('POST', '/user', 'ProcessController/processCreate');
    // {id} must be a number (\d+)
    $r->addRoute('GET', '/users/{id:\d+}', function(){
        echo "adsad";
    });
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
        die("no estoy");
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
         die("no estoy");
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
