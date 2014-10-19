<?php

/**
 * Open a session
 * @param path - session save path
 * @param id - session id
 */
function sess_open($path, $id) {
    return true;
}

/**
 * Close a session
 */
function sess_close() {
    $cache = getCache();
    if (is_object($cache)) {
        $cache->close();
    }
    return true;
}

/**
 * Read a session with the given id
 * @param id session id
 */
function sess_read($id) {
    $cache = getCache();
    return $cache->get('session_' . $id);
}

/**
 * Write data to a session with given id
 * @param id - session id
 * @param data - session data
 */
function sess_write($id, $data) {
    $cache = getCache();
    $cache->set('session_' . $id, $data, false);
}

/**
 * Destroy session with the given id
 * @param id - session id
 */
function sess_destroy($id) {
    $cache = getCache();
    $cache->delete('session_' . $id);
}

/**
 * Run garbage collector on sessions
 * @param maxlifetime - maximum session lifetime in seconds
 */
function sess_gc($maxlifetime) {
    // NOOP
}
