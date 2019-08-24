<?php

use reneroboter\gli\Command\CreateCommand;
use reneroboter\gli\Command\ListCommand;
use reneroboter\gli\Service\CurlService;

require_once __DIR__ . '/bootstrap.php';

$climate = new League\CLImate\CLImate();
$whiteList = ['create', 'delete', 'list'];
$command = $argv[1];

if($argc < 2 || !\in_array($command, $whiteList, true)) {
    $climate->darkGray('gli 0.0.1');
    $climate->br();
    $climate->darkGray('Usage:');
    $climate->lightGray('command: [arguments] [options]');
    $climate->br();
    $climate->darkGray('Available commands:');
    $climate->lightGray('create: Create a repository');
    $climate->lightGray('delete: Delete a given repository');
    $climate->lightGray('list: List all your repositories');
    exit(1);
}

$commandResult = null;
switch ($command) {
    case 'create':
        $commandResult = (new CreateCommand($climate))->handle();
        break;
    case 'list':
        $commandResult = (new ListCommand($climate))->handle();
        break;
    case 'delete':
        // do delete
        exit('Not implement yet ...');
        break;
}


if (!$commandResult) {
    $climate->error('Something get wrong ...');
    exit(1);
}

$curlService = new CurlService($climate, $config);
$curlService->process($commandResult);
