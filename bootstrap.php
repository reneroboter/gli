<?php

require_once __DIR__ . '/vendor/autoload.php';


$configPath = __DIR__ . '/config.php';

if (!is_file($configPath)) {
    echo 'config.php not found!';
    exit(1);
}

$config = require $configPath;

if (!is_array($config)) {
    echo 'Config your configuration file.';
    exit(1);
}
if (!isset($config['token'])) {
    echo 'Set your access token.';
    exit(1);
}
