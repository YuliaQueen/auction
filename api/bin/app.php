#! /usr/bin/env php
<?php

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

require __DIR__ . '/../vendor/autoload.php';

/** @var ContainerInterface $container */
$container = require __DIR__ . '/../config/container.php';

$cli = new Application('Console');

/**
 * @psalm-suppress MixedArrayAccess
 * @var string[] $commands
 */
$commands = $container->get('config')['console']['commands'];

/** @psalm-suppress MixedAssignment */
foreach ($commands as $name) {
    /** @var Command $command */
    $command = $container->get($name);
    $cli->add($command);
}

$cli->run();