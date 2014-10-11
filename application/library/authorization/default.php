<?php

global $appViews;
global $appApis;

/**
 * An array containing view names as keys and integers 0 or 1 as values.
 * 1 states that the view is public, 0 stands for a private view.
 */
$appViews = array(
    'api' => 1,
    'index' => 1
);

/**
 * An array containing api names as keys and arrays as values.
 */
$appApis = array(
    'example' => array(
        'public' => 0,
        'actions' => array(
            'example_action' => 1,
            'example_action2' => 0
        )
    )
);

function isUserAllowedForView($view) {
    global $appViews;
    if (!isset($appViews[$view]) || !is_file(VIEWS . $view . '.php')) {
        return FALSE;
    }
    if ($appViews[$view] === 1) {
        return TRUE;
    }
    lock();
    // TODO: check for user permissions
    return FALSE;
}

function isUserAllowedForApiAction($api, $action) {
    global $appApis;
    if (!isset($appApis[$api]) || !is_file(LIBRARY . 'api/' . $api . '.php') || !isset($appApis[$api]['actions'][$action])) {
        return FALSE;
    }
    if ($appApis[$api]['public'] === 1) {
        return TRUE;
    }
    if ($appApis[$api]['actions'][$action] === 1) {
        return TRUE;
    }
    // TODO: check for user permissions
    return FALSE;
}

function checkUserAllowedForView($view) {
    if (!isUserAllowedForView($view)) {
        die('user not allowed for view');
    }
}

function checkUserAllowedForApiAction($api, $action) {
    if (!isUserAllowedForApiAction($api, $action)) {
        die('user not allowed for api-action');
    }
}
