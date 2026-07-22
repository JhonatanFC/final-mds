<?php

declare(strict_types=1);

$defaultConfig = [
    'host' => '127.0.0.1',
    'port' => '3306',
    'database' => 'restaurante',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
];

$localFile = __DIR__ . '/database.local.php';

if (is_file($localFile)) {
    $localConfig = require $localFile;

    if (is_array($localConfig)) {
        return array_replace($defaultConfig, $localConfig);
    }
}

return $defaultConfig;