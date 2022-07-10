<?php

declare(strict_types=1);

return [
    'config' => [
        'console' => [
            'commands' => [
                \Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand::class,
                \Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand::class
            ]
        ]
    ]
];
