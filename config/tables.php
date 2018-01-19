<?php

use SF\Databases\Types;

return [
    'user' => [

        /**
         * @see \SF\Databases\Column
         */
        'columns' => [
            [
                'name' => 'user_id',
                'type' => Types::INTEGER,
                'primaryKey' => true,
                'allowNull' => false,
                'autoincrement' => true,
                'unsigned' => true,
            ],
            [
                'name' => 'mobile',
                'type' => Types::VARCHAR
            ],
            [
                'name' => 'nickname',
                'type' => Types::VARCHAR
            ],
            [
                'name' => 'avatar',
                'type' => Types::VARCHAR
            ],
            [
                'name' => 'password',
                'type' => Types::VARCHAR
            ],
            [
                'name' => 'state',
                'type' => Types::TINYINT
            ],
            [
                'name' => 'create_at',
                'type' => Types::DATETIME
            ],
        ],
        'sql' => [
            'find_one' => 'SELECT * FROM `user` WHERE `user_id` = ? AND `state` = 1'
        ],
    ]

];