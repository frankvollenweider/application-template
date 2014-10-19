<?php

// configure error reporting level
error_reporting(E_ALL);

// set library and class location
define('APP', dirname(__FILE__) . '/../');
define('LIBRARY', APP . 'library/');
define('VIEWS', APP . 'views/');
define('CONFIG', APP . 'config/');
define('MODULES', APP . 'modules/');
define('PUB', APP . '../public/');
define('RESOURCE', PUB . 'static/');
define('CACHE', RESOURCE . 'cache/');

// load core function library
require LIBRARY . 'core.php';

// perform startup
startup();

// define base views
define('VIEW_INDEX', 'index');
define('VIEW_API', 'api');

// define urls
define('R', config('application.url.base'));
define('S', R . 'static/');

// initialize databases
initializeDatabases();

// initialize caching
initializeCaching();

// load user library
$userProvider = config('security.user.provider');
if (!empty($userProvider) && is_file(LIBRARY . 'user/' . $userProvider . '.php')) {
    require LIBRARY . 'user/' . $userProvider . '.php';
} else {
    require LIBRARY . '/user/default.php';
}

// load authentication library
$authenticationProvider = config('security.authentication.provider');
if (!empty($authenticationProvider) && is_file(LIBRARY . 'authentication/' . $authenticationProvider . '.php')) {
    require LIBRARY . 'authentication/' . $authenticationProvider . '.php';
} else {
    require LIBRARY . '/authentication/default.php';
}

// load authorization library
$authorizationProvider = config('security.authorization.provider');
if (!empty($authorizationProvider) && is_file(LIBRARY . 'authorization/' . $authorizationProvider . '.php')) {
    require LIBRARY . 'authorization/' . $authorizationProvider . '.php';
} else {
    require LIBRARY . '/authorization/default.php';
}

// set timezone
date_default_timezone_set(config('timezone.default'));

// register shutdown function
register_shutdown_function('session_write_close');
register_shutdown_function('shutdown');
