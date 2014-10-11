<?php

// initialize benchmarking
global $start;
$start = microtime(true);

// configure error reporting level
error_reporting(E_ALL);

// set library and class location
define('APP', dirname(__FILE__) . '/../');
define('LIBRARY', APP . 'library/');
define('VIEWS', APP . 'views/');
define('CONFIG', APP . 'config/');
define('CACHE', APP . 'cache/');
define('MODULES', APP . 'modules/');

// load core function library
require LIBRARY . 'core.php';

// define additional constants
define('R', config('application.baseurl'));
define('S', R . 'static/');

// create database connection instances
require LIBRARY . 'db.php';
global $databases;
$dbnames = config('database.names');
foreach ($dbnames as $dbname) {
    $databases[$dbname] = new Database(
        config('database.' . $dbname . '.server.host'),
        config('database.' . $dbname . '.server.username'),
        config('database.' . $dbname . '.server.password'),
        config('database.' . $dbname . '.name')
    );
}

global $cache;
if (class_exists('Memcache')) {
    $cache = new Memcache();
    $cache->connect(config('memcached.server.name'), config('memcached.server.port'));
    require LIBRARY . 'session.php';
    // set session save handler
    session_set_save_handler("sess_open", "sess_close", "sess_read", "sess_write", "sess_destroy", "sess_gc");
} else {
    require LIBRARY . 'cache.php';
    $cache = new Cache();
}

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

?>
