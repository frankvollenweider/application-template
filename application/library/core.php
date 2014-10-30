<?php

/**
 * Get a configuration variable by path.
 * Usage: $title = config('application.title'); 
 * @param var Name of the variable
 * @param value Default value to return if the variable is not set
 */
function config($var, $value = NULL) {
    global $config;
    if ($config == NULL) {
        $config = array();
        require CONFIG . 'config.php';
        is_file(CONFIG . 'config-private.php') ? include(CONFIG . 'config-private.php') : NULL;
    }
    return isset($config[$var]) ? $config[$var] : $value;
}

/**
 * Parse the request uri.
 */
function parseRequestUri($requestUri, $queryString) {
    global $route;
    $route = str_replace('?' . $queryString, '', explode('/', $requestUri));
}

function currentView() {
    global $route;
    if (empty($route[1])) { $route[1] = VIEW_INDEX; }
    return $route[1];
}

function currentApi() {
    if (currentView() === VIEW_API) {
        global $route;
        if (!empty($route[2])) {
            return $route[2];
        }
    }
    return NULL;
}

function currentApiAction() {
    if (currentView() === VIEW_API) {
        global $route;
        if (!empty($route[3])) {
            return $route[3];
        }
    }
    return NULL;
}

function currentApiActionParams() {
    global $route;
    $params = array();
    $routeIndex = 4;
    $paramsIndex = 0;
    while (isset($route[$routeIndex])) {
        $params[$paramsIndex++] = $route[$routeIndex++];
    }
    return $params;
}

function currentViewParams() {
    global $route;
    $params = array();
    $routeIndex = 6;
    $paramsIndex = 0;
    while (isset($route[$routeIndex])) {
        $params[$paramsIndex++] = $route[$routeIndex++];
    }
    return $params;
}

/**
 * Perform application startup tasks.
 */
function startup() {
    // initialize benchmarking
    //global $start;
    //$start = microtime(true);
}

/**
 * Perform application shutdown tasks.
 */
function shutdown() {
    global $databases;
    foreach ($databases as $alias => $db) {
        $db->close();
    }
    //global $start;
    //echo "\n<!-- " . round(microtime(true) - $start, 4) . "s -->";
}

function initializeCaching() {
    global $cache;
    if (class_exists('Memcache')) {
        $cache = new Memcache();
        $cache->connect(config('memcached.server.name'), config('memcached.server.port'));
//         require LIBRARY . 'session.php';
//         // set session save handler
//         session_set_save_handler("sess_open", "sess_close", "sess_read", "sess_write", "sess_destroy", "sess_gc");
    } else {
        require LIBRARY . 'cache/sessioncache.php';
        $cache = new SessionCache();
    }
}

function getCache() {
    global $cache;
    return $cache;
}

function initializeDatabases() {
    require LIBRARY . 'db.php';
    global $databases;
    $databases = array();
}

/**
 * Returns the named database.
 * @param name Name of the database
 */
function db($alias) {
    global $databases;
    if (!isset($databases[$alias])) {
        $dbnames = config('database.names');
        if (!isset($dbnames)) {
            $databases[$alias] = NULL;
        } else {
            $db = NULL;
            $dbAliases = NULL;
            foreach ($dbnames as $dbname => $aliases) {
                if (!empty($db)) {
                    break;
                }
                foreach ($aliases as $tmpAlias) {
                    if ($tmpAlias === $alias) {
                        $db = new Database(
                            config('database.' . $dbname . '.server.host'),
                            config('database.' . $dbname . '.server.username'),
                            config('database.' . $dbname . '.server.password'),
                            $dbname,
                            config('database.' . $dbname . '.server.port')
                        );
                        $dbAliases = $aliases;
                        break;
                    }
                }
            }
            if (empty($dbAliases)) {
                $dbAliases = array($alias);
            }
            foreach ($dbAliases as $tmpAlias) {
                $databases[$tmpAlias] = $db;
            }
        }
    }
    return $databases[$alias];
}

function jsonReceive() {
    $request = json_decode(file_get_contents('php://input'));
    if (!$request) { die(); }
    return $request;
}

function jsonSend($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit(0);
}

/**
 * Converts a path which looks something like this '/somefolder/../someotherfolder/' to a proper directory path.
 * @param $path Path to beautify
 * @return resulting path
 */
function simplifyPath($path) {
    // saves our current working directory to a variable
    $oldCwd = getcwd();
    // change the directory to the one to convert
    // $path is the directory to convert (clean up), handed over to the function as a string
    chdir($path);
    $newCwd = str_replace('\\', '/', getcwd());
    // change the cwd back to the old value to not interfere with the script
    chdir($oldCwd);
    return $newCwd;
}

function notEmptyValueOrNull($value) {
    return empty($value) ? null : trim($value);
}

function formatEmptyValueOrNullToDisplay($value) {
    return trim($value);
}

function formatEmptyValueOrNullToPersist($value) {
    $value = trim($value);
    if ($value === "") {
        return null;
    }
    return $value;
}

function formatDateToDisplay($datestring) {
    if (!empty($datestring)) {
        return date_format(date_create_from_format("Y-m-d", $datestring), "d.m.Y");
    }
    return '';
}

function formatDateToPersist($datestring) {
    if (!empty($datestring)) {
        return date_format(date_create_from_format("d.m.Y", $datestring), "Y-m-d");
    }
    return null;
}

function formatTimeToDisplay($timestring) {
    if (!empty($timestring)) {
        return date_format(date_create_from_format("G:i:s", $timestring), "G:i");
    }
    return '';
}

function formatTimeToPersist($timestring) {
    if (!empty($timestring)) {
        return date_format(date_create_from_format("G:i", $timestring), "G:i:s");
    }
    return null;
}

function doLog($message) {
    error_log($message);
}
