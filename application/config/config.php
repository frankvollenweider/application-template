<?php
global $config;
$config = array();

// Timezone
$config['timezone.default'] = 'UTC';

// Database
$config['database.names'] = array(
    'mysql'
);
$config['database.mysql.server.type'] = 'mysql';
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

// Cache
$config['cache.css.enabled'] = false;
$config['cache.js.enabled'] = false;

?>