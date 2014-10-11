<?php

function example_action($params) {
    header('Content-Type: application/json');
    $count = count($params);
    $values = "";
    $delimiter = "";
    for ($i = 0; $i < $count; $i++) {
        $values .= $delimiter . $params[$i];
        $delimiter = ", ";
    }
    echo '{ "params": [' . $values . '] }';
}
