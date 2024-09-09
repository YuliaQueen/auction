<?php

use Slim\Factory\AppFactory;
use Psr\Container\ContainerInterface;

return static function (ContainerInterface $container) {

    $app = AppFactory::createFromContainer($container);

    (require __DIR__ . '/../config/middleware.php')($app, $container);
    (require __DIR__ . '/../config/routes.php')($app);

    return $app;
};