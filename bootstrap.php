<?php

require_once __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config.php';

if (!is_array($config)) {
    echo 'Config your configuration file.';
    exit(1);
}
if (!isset($config['token'])) {
    echo 'Set your access token.';
    exit(1);
}
