<?php

$builder = new DI\ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/../config/dependencies.php');

return $builder->build();