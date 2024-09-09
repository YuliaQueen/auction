<?php

use App\Console\HelloCommand;

return [
    'config' => [
        'console' => [
            'commands' => [
                HelloCommand::class
            ]
        ]
    ]
];