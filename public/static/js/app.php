<?php


define('BASE', dirname(__FILE__) . '/..');
define('CACHE', dirname(__FILE__) . '/');

require dirname(__FILE__) . '/../../../application/library/bootstrap.php';

// initialize
$core = file_get_contents(BASE . '/js/core/jquery-1.11.1.min.js') . "\n";
$core .= file_get_contents(BASE . '/js/core/terrific-2.0.2.min.js') . "\n";

$output = '';

// load libraries
foreach (glob(BASE . '/js/libraries/*.js') as $entry) {
    if (is_file($entry)) {
        $output .= file_get_contents($entry) . "\n";
    }
}

// load plugins
foreach (glob(BASE . '/js/plugins/*.js') as $entry) {
    if (is_file($entry)) {
        $output .= file_get_contents($entry) . "\n";
    }
}

// load connectors
foreach (glob(BASE . '/js/connectors/*.js') as $entry) {
    if (is_file($entry)) {
        $output .= file_get_contents($entry) . "\n";
    }
}

// load modules
foreach (glob(APP . '/modules/*', GLOB_ONLYDIR) as $dir) {
    $module = basename($dir);
    $js = $dir . '/js/' . $module . '.js';
    if (is_file($js)) {
        $output .= file_get_contents($js) . "\n";
    }
    foreach (glob($dir . '/js/skin/*.js') as $entry) {
        if (is_file($entry)) {
            $output .= file_get_contents($entry) . "\n";
        }
    }
}
    
require LIBRARY . 'thirdparty/jsmin/jsmin.php';
$output = JSMin::minify($output);
file_put_contents(CACHE . 'app.js', $core . $output);
header("Content-Type: text/javascript; charset=utf-8");
echo $core . $output;

?>
