<?php

/**
 * Returns current users ID. If anonymous, null will be returned.
 */
function userid() {
    return user('id');
}

/**
 * Returns provided field of current user or current user if field is null
 * or null if there is no current user.
 */
function user($field = NULL) {
    $u = $_SESSION['current_user'];
    if (!empty($u)) {
        if (!empty($field)) {
            return $u[$field];
        }
        return $u;
    }
    return null;
}
