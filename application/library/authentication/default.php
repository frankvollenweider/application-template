<?php 

/**
 * Returns, whether the current user is authenticated or not
 * @return true if authenticated, false otherwise
 */
function authenticated() {
    return $_SESSION['auth'] == md5(config('security.password.hash') . userid());
}

/**
 * Locks a specific script for unauthenticated requests.
 */
function lock() {
    if (!authenticated()) {
        // Check for an ajax-request
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $response = array('success' => false);
            $response['error_code'] = "401";
            $response['error_message'] = "Unauthorized Request";
            $response['forward_url'] = R . config('application.url.login') . '?referer=' . $_SERVER['REQUEST_URI'];
            json_send($response);
        } else {
            header('Location: ' . R . config('application.url.login') . '?referer=' . $_SERVER['REQUEST_URI']);
            exit();
        }
    }
}

?>
