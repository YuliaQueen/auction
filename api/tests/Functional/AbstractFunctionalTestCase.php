<?php

namespace Test\Functional;

use Slim\App;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Factory\ServerRequestFactory;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractFunctionalTestCase extends TestCase
{
    /**
     * @return mixed
     */
    protected function app()
    {
        /** @var ContainerInterface $container */
        $container = require __DIR__ . '/../../config/container.php';

        /** @var App $app */
        return (require __DIR__ . '/../../config/app.php')($container);
    }

    /**
     * @param string $method
     * @param string $uri
     * @return ServerRequestInterface
     */
    protected static function request(string $method = 'GET', string $uri = '/'): ServerRequestInterface
    {
        return (new ServerRequestFactory())->createServerRequest($method, $uri);
    }

    /**
     * @param string $method
     * @param string $uri
     * @return ServerRequestInterface
     */
    protected static function json(string $method, string $uri): ServerRequestInterface
    {
        return self::request($method, $uri)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Accept', 'application/json');
    }
}