<?php

// start session
session_start();

// application bootstrap
require dirname(__FILE__) . '/../application/library/bootstrap.php';

// parse request uri
parseRequestUri($_SERVER['REQUEST_URI'], $_SERVER['QUERY_STRING']);

// view routing
$viewName = currentView();
checkUserAllowedForView($viewName);
require VIEWS . $viewName . '.php';

// terminate execution
exit(0);
