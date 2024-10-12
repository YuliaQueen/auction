<?php

return [
    'config' => [
        'debug' => boolval(getenv('APP_DEBUG')),
        'env' => getenv('APP_ENV') ?: 'prod',
    ]
];
