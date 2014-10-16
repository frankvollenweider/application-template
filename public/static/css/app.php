<?php

require dirname(__FILE__) . '/../../../application/library/bootstrap.php';

// load reset css
$output = file_get_contents(RESOURCE . 'css/core/reset.css') . "\n";

// load plugin css
foreach (glob(RESOURCE . 'css/elements/*.css') as $entry) {
    if (is_file($entry)) {
        $output .= file_get_contents($entry) . "\n";
    }
}

// load module css including skins
foreach (glob(MODULES . '*', GLOB_ONLYDIR) as $dir) {
    $module = basename($dir);
    $css = $dir . '/css/' . strtolower($module) . '.css';
    if (is_file($css)) {
        $output .= file_get_contents($css) . "\n";
    }
    foreach (glob($dir . '/css/skin/*') as $entry) {
        if (is_file($entry)) {
            $output .= file_get_contents($entry) . "\n";
        }
    }
}

// minify the css if required
if (config('minify.css.enabled')) {
    require LIBRARY . 'thirdparty/cssmin/cssmin.php';
    $output = CssMin::minify($output);
}

// cache the css if required
if (config('cache.css.enabled')) {
	file_put_contents(CACHE . 'app.css', $output);
}

header("Content-Type: text/css");
echo $output;
