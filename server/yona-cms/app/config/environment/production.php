<?php

return [
    'base_path' => '/',
    //'base_path' => 'http://localhost/yona-cms/web/',

    'database'  => [
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => '',
        'password' => '',
        'dbname'   => '',
        'charset'  => 'utf8',
    ],

    'memcache'  => [
        'host' => '128.199.116.234',
        'port' => 11211,
    ],

    'cache'     => 'file',
    //'cache'     => 'memcache',
];