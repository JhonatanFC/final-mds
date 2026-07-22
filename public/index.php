<?php

declare(strict_types=1);



require_once dirname(__DIR__) . '/config/config.php';

ini_set('display_errors', APP_DEBUG ? '1' : '0');
ini_set('display_startup_errors', APP_DEBUG ? '1' : '0');
error_reporting(E_ALL);

set_exception_handler(static function (Throwable $exception): void {
    http_response_code(500);

    echo '<h2>Error de desarrollo</h2>';
    echo '<pre style="white-space: pre-wrap; padding: 20px; background: #fff3f3; color: #8b0000;">';
    echo htmlspecialchars(
        $exception::class . ': ' . $exception->getMessage()
        . PHP_EOL . PHP_EOL
        . $exception->getFile() . ':' . $exception->getLine()
        . PHP_EOL . PHP_EOL
        . $exception->getTraceAsString(),
        ENT_QUOTES,
        'UTF-8'
    );
    echo '</pre>';
});

spl_autoload_register(static function (string $class): void {
    $directories = [
        BASE_PATH . '/app/core/',
        BASE_PATH . '/app/controllers/',
        BASE_PATH . '/app/models/',
        BASE_PATH . '/app/middleware/',
        BASE_PATH . '/app/helpers/',
    ];

    foreach ($directories as $directory) {
        $file = $directory . $class . '.php';

        if (is_file($file)) {
            require_once $file;
            return;
        }
    }
});

require_once BASE_PATH . '/app/core/Functions.php';

Session::start();

$router = new Router();

require BASE_PATH . '/routes/web.php';

$router->dispatch();