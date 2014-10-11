<?php

$apiName = isset($route[2]) ? $route[2] : "";
$apiAction = isset($route[3]) ? $route[3] : "";

checkUserAllowedForApiAction($apiName, $apiAction);
require LIBRARY . 'api/' . $apiName . '.php';

if (is_callable($apiAction)) {
    $params = array();
    $routeIndex = 4;
    $paramsIndex = 0;
    while (isset($route[$routeIndex])) {
        $params[$paramsIndex++] = $route[$routeIndex++];
    }
    call_user_func($apiAction, $params);
}
?>