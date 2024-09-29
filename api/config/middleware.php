<?php

use Slim\App;
use Psr\Container\ContainerInterface;

return static function (App $app, ContainerInterface $container) {
    /**
     * @psalm-suppress MixedArrayAccess
     * @var bool $isDebug
     */
    $isDebug = $container->get('config')['debug'];
    $app->addErrorMiddleware($isDebug, true, true);
};