<?php

require_once __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config.php';

$climate = new League\CLImate\CLImate();

$climate->arguments->add([
    'name' => [
        'prefix' => 'n',
        'longPrefix' => 'name',
        'description' => 'Name',
        'required' => true,
    ],
    'description' => [
        'prefix' => 'd',
        'longPrefix' => 'description',
        'description' => 'Description',
        'noValue' => true,
    ],
    'homepage' => [
        'prefix' => 'h',
        'longPrefix' => 'homepage',
        'description' => 'Homepage',
        'noValue' => true,
    ],
    'private' => [
        'prefix' => 'p',
        'longPrefix' => 'private',
        'description' => 'Private',
        'defaultValue' => false,
    ],
    'help' => [
        'longPrefix' => 'help',
        'description' => 'Prints a usage statement',
        'noValue' => true,
    ],
]);

if (!is_array($config)) {
    echo 'Config your configuration file.';
    exit(1);
}
if (!isset($config['token'])) {
    echo 'Set your access token.';
    exit(1);
}


if ($climate->arguments->defined('help')) {
    $climate->usage();
    exit(0);
}

if (!$climate->arguments->defined('name')) {
    $climate->error('The following arguments are required: [-n name, --name name]');
    exit(0);
}

$climate->arguments->parse();

$request = [];
$request['name'] = $climate->arguments->get('name');

if ($climate->arguments->defined('description')) {
    $request['description'] = $climate->arguments->get('description');
}

if ($climate->arguments->defined('homepage')) {
    $request['homepage'] = $climate->arguments->get('homepage');
}

if ($climate->arguments->defined('private')) {
    $request['private'] = $climate->arguments->get('private');
}

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
