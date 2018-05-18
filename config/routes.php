<?php

return [
    [
        'pattern' => '/',
        'handler' => function() {
            return '首页';
        }
    ],
    [
        'pattern' => '/user/',
        'regex'   => false,
        'handler' => function() {
            return \App\Controllers\User::handle('detail');
        }
    ],
    [
        'pattern' => '/(.*)/',
        'regex'   => true,
        'handler' => function() {
            return \App\Controllers\User::handle('index');
        }
    ],
];
