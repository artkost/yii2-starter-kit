<?php

$root = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR;

return [
    'active' => dirname(__DIR__) . '/active',
    '@vendor' => $root . 'vendor',
    '@bower' => $root . 'public' . DIRECTORY_SEPARATOR . 'vendor'
];