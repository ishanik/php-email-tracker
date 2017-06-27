<?php

require_once './autoloader.php';

// Get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);

// Retrieve controller name
$controller_name = 'Controller_'.ucfirst(preg_replace('/[^a-z0-9_]+/i','',array_shift($request)));
//echo $controller_name; exit;

// Call controller
$controller = new $controller_name($method, $input);
?>
