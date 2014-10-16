<?php
global $config;
$config = array();

// Timezone
$config['timezone.default'] = 'UTC';

// Database
$config['database.names'] = array(
    'mysql' => array('db1')
);
$config['database.mysql.server.host'] = 'localhost';
$config['database.mysql.server.port'] = 3306;
$config['database.mysql.server.username'] = '';
$config['database.mysql.server.password'] = '';

// Memcached
$config['memcached.server.name'] = 'localhost';
$config['memcached.server.port'] = 30001;

// Application
$config['application.domain'] = 'http://www.yourdomain.com';
$config['application.url.base'] = '/';
$config['application.url.login'] = '/login';
$config['application.url.error'] = '/error';

// Security
$config['security.password.hash'] = 'ZvN3uEV0ACWvqw';
$config['security.user.provider'] = 'default';
$config['security.authentication.provider'] = 'default';
$config['security.authorization.provider'] = 'default';

// Minify Resources
$config['minify.css.enabled'] = true;
$config['minify.js.enabled'] = true;

// Cache
$config['cache.css.enabled'] = true;
$config['cache.js.enabled'] = true;

?>