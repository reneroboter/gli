<?php

use reneroboter\gli\Command\CreateCommand;

require_once __DIR__ . '/bootstrap.php';

$climate = new League\CLImate\CLImate();
$whiteList = ['create', 'delete', 'list'];
$command = $argv[1];
if($argc < 2 || !\in_array($command, $whiteList, true)) {
    $data = [
        [
            'create',
            'Create a repository',
        ],
        [
            'delete',
            'Delete a given repository',
        ],
        [
            'list',
            'List all your repositories',
        ],
    ];
    $climate->out('Usage:');
    $climate->table($data);
    exit(1);
}

$request = [];
switch ($command) {
    case 'create':
        $request = (new CreateCommand($climate))->handle();
        break;
    case 'list':
        // do list
        exit('Not implement yet ...');
        break;
    case 'delete':
        // do delete
        exit('Not implement yet ...');
        break;
}

// handle request
$url = 'https://api.github.com/user/repos';
$options = [
    CURLOPT_USERAGENT => 'gli user-agent',
    CURLOPT_HTTPHEADER => [
        'Authorization: token ' . $config['token'],
    ],
    CURLOPT_POSTFIELDS => json_encode($request),
    CURLOPT_RETURNTRANSFER => true
];

$curl = curl_init($url);
curl_setopt_array($curl, $options);
if (!curl_exec($curl)) {
    $climate->error(sprintf('Curl error: %s', curl_error($curl)));
}
curl_close($curl);
