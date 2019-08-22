<?php

// gli create --name <repo-name> --description --private true/false --homepage
// gli delete --name <repo-name>

$config = require __DIR__ . '/config.php';

$options = getopt('', ['name:', 'description:', 'private', 'homepage:']);

// $argc >= 2 ||
if (!isset($options['name'])) {
    echo 'Usage: php github.php create' . PHP_EOL .
        '--name <repo-name>'. PHP_EOL .
        '--description <description>'. PHP_EOL .
        '--private <default:false>'. PHP_EOL .
        '--homepage <homepage>';
    exit(1);
}

if (!is_array($config)) {
    echo 'Config your configuration file.';
    exit(1);
}
if (!isset($config['token'])) {
    echo 'Set your access token.';
    exit(1);
}
$request = [
    'name' => $options['name'],
    'description' => $options['description'],
    'private' => !$options['private'],
    'homepage' => $options['homepage'],
];


$url = 'https://api.github.com/user/repos';
$options = [
    CURLOPT_USERAGENT => 'Awesome-Octocat-App',
    CURLOPT_HTTPHEADER => [
        'Authorization: token ' . $config['token'],
    ],
    CURLOPT_POSTFIELDS => json_encode($request),
    CURLOPT_RETURNTRANSFER => true
];


$curl = curl_init($url);
curl_setopt_array($curl, $options);
curl_exec($curl);
curl_close($curl);
