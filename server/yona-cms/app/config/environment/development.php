<?php

return [
    'base_path' => 'http://nuoiboso.dev/',
    //'base_path' => 'http://localhost/yona-cms/web/',

    'database'  => [
        'adapter'  => 'Mysql',
        'host'     => '127.0.0.1',
        'username' => 'root',
        'password' => 'smile123!@#',
        'dbname'   => 'nuoiboso',
        'charset'  => 'utf8',
    ],

    'memcache'  => [
        'host' => 'localhost',
        'port' => 11211,
    ],

    'cache'     => 'file',
    //'cache'     => 'memcache',
];