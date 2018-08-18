<?php
return [
    'eventManager' => [
        'class' => \SF\Event\EventManager::class,
        'events' => [
        ],
    ],
    'database' => [
        'class' => SF\Database\DatabaseServiceProvider::class,
        'drivers' => include('config/database.php'),
        'tables' => include('config/tables.php')
    ],
    'cache' => [
        'class' => \SF\Cache\CacheServiceProvider::class,
        'drivers' => [
            'default' => [
                'class' => \SF\Cache\Redis::class,
                'host' => '127.0.0.1',
                'auth' => '',
                'port' => 6379,
            ]
        ]
    ],
    'protocol' => [
        'class' => \SF\Protocol\ProtocolServiceProvider::class,
        'protocols' => [
            'http' => [
                'class' => \SF\Protocol\Http\Protocol::class,
                'server' => [
                    'class' => \SF\Protocol\Http\Server::class,
                    'gzip' => false,
                    'router' => [
                        'class' => \SF\Http\Router::class,
                        'rules' => include('config/routes.php'),
                    ],
                    'middleware' => [],
                ]
            ]
        ],
    ]
];