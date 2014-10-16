<?php

$apiName = currentApi();
$apiAction = currentApiAction();

checkUserAllowedForApiAction($apiName, $apiAction);
require LIBRARY . VIEW_API . '/' . $apiName . '.php';

if (is_callable($apiAction)) {
    $params = currentApiActionParams();
    call_user_func($apiAction, $params);
}
