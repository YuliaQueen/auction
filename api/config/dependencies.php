<?php

$files = glob(__DIR__ . '/common/*.php');

/**
 * @psalm-suppress UnresolvableInclude
 * @psalm-suppress MixedInferredReturnType
 * @psalm-suppress MixedReturnStatement
 */
$configs = array_map(fn(string $file): array => require $file, $files);

return array_merge_recursive(...$configs);