<?php

$files = glob(__DIR__ . '/common/*.php');

$configs = array_map(fn($file) => require $file, $files);

return array_merge_recursive(...$configs);