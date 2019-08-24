<?php
$pharFile = 'gli.phar';

if (file_exists($pharFile)) {
unlink($pharFile);
}

if (file_exists($pharFile . '.gz')) {
unlink($pharFile . '.gz');
}

$phar = new Phar($pharFile);
$exclude = '/^(?:.gitignore|config.dist.php|maker.php|README.md)$/';
$phar->buildFromDirectory('.');
$phar->setDefaultStub('gli.php', '/gli.php');
