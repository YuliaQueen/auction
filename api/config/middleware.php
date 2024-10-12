<?php

use Slim\App;
use Psr\Container\ContainerInterface;

return static function (App $app, ContainerInterface $container) {
    /**
     * @psalm-suppress MixedArrayAccess
     * @var bool $isDebug
     */
    $isDebug = $container->get('config')['debug'];
    $isLogEnabled = $container->get('config')['env'] != 'test';
    $app->addErrorMiddleware($isDebug, $isLogEnabled, true);
};