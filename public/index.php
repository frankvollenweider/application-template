<?php

// start session
session_start();

// parse request uri
global $route;
$route = str_replace('?' . $_SERVER['QUERY_STRING'], '', explode('/', $_SERVER['REQUEST_URI']));

// application bootstrap
require dirname(__FILE__) . '/../application/library/bootstrap.php';

// view routing
$viewName = currentView();
checkUserAllowedForView($viewName);
require VIEWS . $viewName . '.php';

// terminate execution
exit(0);
