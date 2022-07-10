<?php

declare(strict_types=1);

return [
    'config' => [
        'console' => [
            'commands' => [
                \App\Console\HelloCommand::class,
                \Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand::class
            ]
        ]
    ]
];
