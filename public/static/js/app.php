<?php

require dirname(__FILE__) . '/../../../application/library/bootstrap.php';

// initialize
$core = '';
if (config('minify.js.enabled')) {
    $core .= file_get_contents(RESOURCE . 'js/core/jquery-1.11.1.min.js') . "\n";
    $core .= file_get_contents(RESOURCE . 'js/core/terrific-2.1.0.min.js') . "\n";
    $core .= file_get_contents(RESOURCE . 'js/core/doT-1.0.1.min.js') . "\n";
} else {
	$core .= file_get_contents(RESOURCE . 'js/core/jquery-1.11.1.js') . "\n";
	$core .= file_get_contents(RESOURCE . 'js/core/terrific-2.1.0.js') . "\n";
	$core .= file_get_contents(RESOURCE . 'js/core/doT-1.0.1.js') . "\n";
}

$output = file_get_contents(RESOURCE . 'js/core/core.js') . "\n";

// load libraries
foreach (glob(RESOURCE . 'js/libraries/*.js') as $entry) {
    if (is_file($entry)) {
        $output .= file_get_contents($entry) . "\n";
    }
}

// load plugins
foreach (glob(RESOURCE . 'js/plugins/*.js') as $entry) {
    if (is_file($entry)) {
        $output .= file_get_contents($entry) . "\n";
    }
}

// load connectors
foreach (glob(RESOURCE . 'js/connectors/*.js') as $entry) {
    if (is_file($entry)) {
        $output .= file_get_contents($entry) . "\n";
    }
}

// load modules
foreach (glob(MODULES . '*', GLOB_ONLYDIR) as $dir) {
    $module = basename($dir);
    $js = $dir . '/js/' . strtolower($module) . '.js';
    if (is_file($js)) {
        $output .= file_get_contents($js) . "\n";
    }
    foreach (glob($dir . '/js/skin/*.js') as $entry) {
        if (is_file($entry)) {
            $output .= file_get_contents($entry) . "\n";
        }
    }
}
    
// minify the js if required
if (config('minify.js.enabled')) {
    require LIBRARY . 'thirdparty/jsmin/jsmin.php';
    $output = JSMin::minify($output);
}

// cache the js if required
if (config('cache.js.enabled')) {
	file_put_contents(CACHE . 'app.js', $core . $output);
}

header("Content-Type: text/javascript; charset=utf-8");
echo $core . $output;
