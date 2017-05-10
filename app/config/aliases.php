<?php

$root = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR;

/**
 * Base path aliases
 */
return [
    '@vendor' => $root . 'vendor',
    '@bower' => $root . 'public' . DIRECTORY_SEPARATOR . 'vendor',
    '@modules' => $root . 'modules',
    '@tests' => $root . 'app' . DIRECTORY_SEPARATOR . 'tests'
];
