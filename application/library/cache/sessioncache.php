<?php

class SessionCache {

    public function __construct() {
	    if (!isset($_SESSION['cache'])) {
	        $_SESSION['cache'] = array();
	    }
	}

	public function get($key) {
		if (isset($_SESSION['cache'][$key])) {
			return $_SESSION['cache'][$key];
		}
		return null;
	}

	public function set($key, $value) {
		$_SESSION['cache'][$key] = $value;
	}

}