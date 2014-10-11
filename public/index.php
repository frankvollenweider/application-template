<?php

// start session
session_start();

require dirname(__FILE__) . '/../application/library/bootstrap.php';

// define route
define('VIEW_INDEX', 'index');
$route = str_replace('?' . $_SERVER['QUERY_STRING'], '', explode('/', $_SERVER['REQUEST_URI']));
if (!isset($route[1]) || empty($route[1])) { $route[1] = VIEW_INDEX; }
$viewName = $route[1];

// view handling
checkUserAllowedForView($viewName);
require VIEWS . $viewName . '.php';

// terminate execution
exit(0);
