<?php

use reneroboter\gli\App;

require_once __DIR__ . '/bootstrap.php';

$climate = new League\CLImate\CLImate();
$whiteList = ['create', 'delete', 'list'];
$command = $argv[1] ?? null;

if ($argc < 2 || !\in_array($command, $whiteList, true)) {
    $climate->usage();
    $climate->br();
    $output = 'Available commands:'
        . 'create: Create a repository'
        . 'delete: Delete a given repository'
        . 'delete: Delete a given repository'
        . 'list: List all your repositories';
    $climate->out($output);
    exit(1);
}

$app = new App($climate, $config);
$app->run($command);