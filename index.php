<?php

// Error reporting on
error_reporting(E_ALL);
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/code/';
$requestUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$requestString = substr($requestUrl, strlen($baseUrl));

//Get url params
$urlParams = explode('/', $requestString);

// Get controller name, action name, parameters
$controllerName = ucfirst(array_shift($urlParams)) . 'Controller';
$actionName = strtolower(array_shift($urlParams)) . 'Action';
$params = array_shift($urlParams);

// Call right controller, action
if (class_exists($controllerName)) {
    $controller = new $controllerName();
    if (method_exists($controller, $actionName)) {
        $controller->$actionName($params);
    } else
        trigger_error("Unable to load action: $actionName");
}

// Autoload controller class
function __autoload($controllerName) {
    require_once ('controller/' . $controllerName . '.php');
    if (!class_exists($controllerName, false)) {
        trigger_error("Unable to load class: $controllerName");
    }
}

?>