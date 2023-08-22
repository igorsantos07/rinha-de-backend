<?php
Dotenv\Dotenv::createImmutable(__DIR__)->load();

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/migrations', //originally, db/migrations
        'seeds' => '%%PHINX_CONFIG_DIR%%/seeds' //originally, db/seeds
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'production',
        'production' => [
            'adapter' => 'pgsql',
            'host' => $_ENV['DB_HOST'],
            'name' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'pass' => $_ENV['DB_PWD'],
            'port' => $_ENV['DB_PORT'],
            'charset' => 'utf8',
        ],
//        'development' => [
//            'adapter' => 'mysql',
//            'host' => 'localhost',
//            'name' => 'development_db',
//            'user' => 'root',
//            'pass' => '',
//            'port' => '3306',
//            'charset' => 'utf8',
//        ],
//        'testing' => [
//            'adapter' => 'mysql',
//            'host' => 'localhost',
//            'name' => 'testing_db',
//            'user' => 'root',
//            'pass' => '',
//            'port' => '3306',
//            'charset' => 'utf8',
//        ]
    ],
    'version_order' => 'creation'
];
