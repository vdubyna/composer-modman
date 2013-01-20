<?php
$loader = false;

if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    $loader = include __DIR__.'/../vendor/autoload.php';
}

if (file_exists(__DIR__.'/../../../autoload.php')) {
    $loader = include __DIR__.'/../../../autoload.php';
}

if (empty($loader)) {
    echo 'You must set up the project dependencies,'
        . 'run the following commands:'.PHP_EOL.
        'curl -s http://getcomposer.org/installer | php'.PHP_EOL.
        'php composer.phar install'.PHP_EOL;
    exit(1);
}

return $loader;