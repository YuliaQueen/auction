<?php

use Slim\App;
use Psr\Container\ContainerInterface;

return static function (App $app, ContainerInterface $container) {
    $isDebug = $container->get('config')['debug'];
    $app->addErrorMiddleware($isDebug, true, true);
};