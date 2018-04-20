<?php
//http 服务器
return [
    'application' => [
        'host' => '127.0.0.1',
        'port' => 9000,
        'ssl' => false,
        'type' => SWOOLE_SOCK_TCP,
        'setting'     => [
            //设置程序进入后台作为守护进程运行
            'daemonize'                => 0,
            //指定Reactor线程数
            'reactor_num'              => 8,
            // 指定启动的worker进程数
            'worker_num'               => 4,
            //服务器开启的task进程数
            'task_worker_num'          => 2,
            //backlog队列长度
            'backlog'                  => 128,
            // swoole server数据包分发策略
            'dispatch_mode'            => 1,
            //swoole server设置端口重用
            'enable_reuse_port'        => 1,
            //设置心跳检测间隔
            'heartbeat_check_interval' => 60,
            //
            'user'                     => 'xfb_user',
            //用户组
            'group'                    => 'staff',
            //日志
            'log_file'                 => __DIR__ . DIRECTORY_SEPARATOR . 'run.log',
        ],
        'events' => [
            \SF\Application\Event\BufferEmpty::class,
            \SF\Application\Event\BufferFull::class,
            \SF\Application\Event\Close::class,//dispatch_mode==1/3 被忽略
            \SF\Application\Event\Connect::class,//dispatch_mode==1/3 被忽略
            \SF\Application\Event\Finish::class,
            \SF\Application\Event\ManagerStart::class,
            \SF\Application\Event\ManagerStop::class,
            \SF\Application\Event\Packet::class,
            \SF\Application\Event\PipeMessage::class,
            \SF\Application\Event\Shutdown::class,
            \SF\Application\Event\Start::class,
            \SF\Application\Event\Task::class,
            \SF\Application\Event\WorkerError::class,
            \SF\Application\Event\WorkerStart::class,
            \SF\Application\Event\WorkerStop::class,
            \SF\Application\Event\Http\Request::class
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
                    \SF\Application\Event\Receive::class
                ]
            ]
        ]
    ],
    'components'  => [
        'eventManager' => [
            'class'  => \SF\Events\EventManager::class,
            'events' => [
            ],
        ],
        'database'     => [
            'class'     => SF\Databases\DatabaseServiceProvider::class,
            'connector' => [
                'class'    => SF\Databases\Mysql\Connector::class,
                'host'     => '127.0.0.1',
                'port'     => 3306,
                'username' => 'root',
                'password' => '123456',
                'database' => 'demo',
                'timeout'  => 60,
                'charset'  => 'utf8'
            ],
            'pool'      => [
                'class'          => SF\Pool\DatabaseConnectPool::class,
                'maxConnections' => 30
            ],
            'tables'    => include_once('config/tables.php')
        ],
        'cache'        => [
            'class'  => \SF\Cache\CacheServiceProvider::class,
            'driver' => [
                'class'          => SF\Redis\RedisCache::class,
                'host'           => '127.0.0.1',
                'port'           => 6379,
                'maxConnections' => 30
            ]
        ],
        'protocol'     => [
            'class'     => \SF\Protocol\ProtocolServiceProvider::class,
            'protocols' => [
                'rpc' => [
                    'class' => \SF\Protocol\Http\Protocol::class,
                    'server' => [
                        'class' => \SF\Protocol\Http\Server::class,
                        'middleware' => [],
                    ]
                ]
            ],
        ],
        'router'       => [
            'class' => \SF\Http\Router::class,
            'rules' => include_once('config/routes.php'),
        ]
    ]
];
