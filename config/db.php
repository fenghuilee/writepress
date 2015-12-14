<?php

return [
    'mysql' => [
        'host'     => 'localhost',
        'username' => 'username',
        'password' => 'password',
        'dbname'   => 'phalcon_blog',
        'prefix'   => 'pb_',
        'charset'  => 'utf8mb4',
        "options"  => [
            //PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES \'utf8mb4\'",
            PDO::ATTR_CASE => PDO::CASE_LOWER,
        ],
    ],
];
