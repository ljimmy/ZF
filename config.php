<?php
//http 服务器
return [
    'application' => [
        'host' => '127.0.0.1',
        'port' => 9000,
        'ssl' => false,
        'type' => SWOOLE_SOCK_TCP,
        'setting' => [
            //设置程序进入后台作为守护进程运行
            'daemonize' => 0,
            //指定Reactor线程数
            'reactor_num' => 8,
            // 指定启动的worker进程数
            'worker_num' => 1,
            //服务器开启的task进程数
            'task_worker_num' => 2,
            //backlog队列长度
            'backlog' => 128,
            // swoole server数据包分发策略
            'dispatch_mode' => 1,
            //swoole server设置端口重用
            'enable_reuse_port' => 1,
            //设置心跳检测间隔
            'heartbeat_check_interval' => 60,
            //
            'user' => 'xfb_user',
            //用户组
            'group' => 'staff',
            //日志
            'log_file' => __DIR__ . DIRECTORY_SEPARATOR . 'run.log',
        ],
        'events' => [
            \SF\Event\Server\BufferEmpty::class,
            \SF\Event\Server\BufferFull::class,
            \SF\Event\Server\Close::class,//dispatch_mode==1/3 被忽略
            \SF\Event\Server\Connect::class,//dispatch_mode==1/3 被忽略
            \SF\Event\Server\Finish::class,
            \SF\Event\Server\ManagerStart::class,
            \SF\Event\Server\ManagerStop::class,
            \SF\Event\Server\Packet::class,
            \SF\Event\Server\PipeMessage::class,
            \SF\Event\Server\Shutdown::class,
            \SF\Event\Server\Start::class,
            \SF\Event\Server\Task::class,
            \SF\Event\Server\WorkerError::class,
            \SF\Event\Server\WorkerStart::class,
            \SF\Event\Server\WorkerStop::class,
            \SF\Event\Server\Http\Request::class
        ],

        'multiport' => [
            [
                //rpc
                'host' => '127.0.0.1',
                'port' => 9001,
                'type' => SWOOLE_SOCK_TCP,
                'setting' => [
                    //固定长度
//                    'open_length_check'        => true,
//                    'package_length_type'      => 'N',
//                    'package_length_offset'    => 8,
//                    'package_body_offset'      => \SF\Protocol\Rpc\Header::HEADER_LENGTH,
//                    'package_max_length'       => 102400,//最大数据包尺寸 100kb
                ],
                'events' => [
                    SF\Event\Server\Rpc\Receive::class
                ]
            ]
        ]
    ],
    'components' => [
        'eventManager' => [
            'class' => \SF\Event\EventManager::class,
            'events' => [
            ],
        ],
        'database' => [
            'class' => SF\Database\DatabaseServiceProvider::class,
            'drivers' => [
                'default' => [
                    'dsn' => 'mysql:host=127.0.0.1;port=3306;database=demo;charset=utf8',
                    'username' => 'root',
                    'password' => '123456',
                    'options' => [
                        'timeout' => 60
                    ]
                ]

            ],
            'tables' => include_once('config/tables.php')
        ],
        'cache' => [
            'class' => \SF\Cache\CacheServiceProvider::class,
            'drivers' => [
                'default' => [
                    'class' => \SF\Cache\Redis::class,
                    'host' => '127.0.0.1',
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
                        'router' => [
                            'class' => \SF\Http\Router::class,
                            'rules' => include_once('config/routes.php'),
                        ],
                        'middleware' => [],
                    ]
                ],
                'rpc' => [
                    'class' => SF\Protocol\Rpc\Protocol::class,
                    'server' => [
                        'class' => SF\Protocol\Rpc\Server::class,
                        'middleware' => []
                    ]
                ]
            ],
        ]
    ]
];
