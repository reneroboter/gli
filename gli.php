<?php

use reneroboter\gli\Command\CreateCommand;
use reneroboter\gli\Command\DeleteCommand;
use reneroboter\gli\Command\ListCommand;
use reneroboter\gli\Service\CurlService;

require_once __DIR__ . '/bootstrap.php';

$climate = new League\CLImate\CLImate();
$whiteList = ['create', 'delete', 'list'];
$command = $argv[1] ?? null;

if($argc < 2 || !\in_array($command, $whiteList, true)) {
    $climate->out('gli 0.0.1');
    $climate->br();
    $climate->out('Usage:');
    $climate->out('command: [arguments] [options]');
    $climate->br();
    $climate->out('Available commands:');
    $climate->out('create: Create a repository');
    $climate->out('delete: Delete a given repository');
    $climate->out('list: List all your repositories');
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
        $commandResult = (new DeleteCommand($climate))->handle();
        break;
}


if (!$commandResult) {
    $climate->error('Something get wrong ...');
    exit(1);
}

$curlService = new CurlService($climate, $config);
$curlService->process($commandResult);
