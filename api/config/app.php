<?php

use Slim\App;
use Slim\Factory\AppFactory;
use Psr\Container\ContainerInterface;

return static function (ContainerInterface $container): App {

    $app = AppFactory::createFromContainer($container);

    /** @psalm-suppress InvalidArgument */
    (require __DIR__ . '/../config/middleware.php')($app, $container);

    /** @psalm-suppress InvalidArgument */
    (require __DIR__ . '/../config/routes.php')($app);

    return $app;
};