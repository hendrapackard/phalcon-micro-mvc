<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'database' => [
        'adapter'     => 'Postgresql',
        'host'        => 'localhost',
        'username'    => 'postgres',
        'password'    => '123456',
        'dbname'      => 'robotics',
        'port'        => '5432'
    ],

    'application' => [
        'modelsDir'      => APP_PATH . '/models/',
        'controllersDir' => APP_PATH . '/controllers/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'baseUri'        => '/phalcon-micro-mvc/',
        'migrationsTsBased' => true,
    ]
]);
