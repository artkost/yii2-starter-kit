<?php

$root = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR;

return [
    '@vendor' => $root . 'vendor',
    '@bower' => $root . 'public' . DIRECTORY_SEPARATOR . 'vendor',
    '@modules' => $root . 'modules'
];
