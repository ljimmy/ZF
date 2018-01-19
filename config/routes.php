<?php

return [
    [
        'pattern' => '/',
        'handler' => function() {
            return '首页';
        }
    ],
    [
        'pattern' => '/(.*)/',
        'regex'   => true,
        'handler' => function() {
            return \App\Controllers\User::handle('index');
        }
    ]
];
