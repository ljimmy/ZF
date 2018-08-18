<?php
//http 服务器
return [
    'host' => '192.168.1.124',
    'port' => 9000,
    'ssl' => false,
    'type' => SWOOLE_SOCK_TCP,
    'setting' => [
        //设置程序进入后台作为守护进程运行
        'daemonize' => 1,
        //指定Reactor线程数
        'reactor_num' => 8,
        // 指定启动的worker进程数
        'worker_num' => 1,
        //服务器开启的task进程数
        'task_worker_num' => 1,
        //backlog队列长度
        'backlog' => 128,
        // swoole server数据包分发策略
        'dispatch_mode' => 2,
        //swoole server设置端口重用
        'enable_reuse_port' => 1,
        //设置心跳检测间隔
        'heartbeat_check_interval' => 60,
        //
//            'user' => 'xfb_user',
        //用户组
//            'group' => 'staff',
        //日志
        'log_file' => __DIR__ . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'run.log',
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
        \SF\Event\Server\Http\Request::class,
        //web socket
        \App\Event\Open::class,
        \App\Event\Message::class,
        \App\Event\Close::class,
    ]

];
