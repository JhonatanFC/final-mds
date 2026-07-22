#!/usr/bin/env bash

set -e

mkdir -p app/core app/controllers app/views/layouts app/views/home config public routes logs
touch public/.htaccess

cat > config/config.php <<'PHP'
<?php

declare(strict_types=1);

date_default_timezone_set('America/Lima');

const APP_NAME = 'RMRS';
const APP_ENV = 'development';
const APP_DEBUG = true;
const APP_URL = 'http://localhost/restaurant-system/public';
const BASE_PATH = __DIR__ . '/..';
PHP

cat > config/database.php <<'PHP'
<?php

declare(strict_types=1);

return [
    'host' => '127.0.0.1',
    'port' => '3306',
    'database' => 'rmrs',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
];
PHP

cat > app/core/Database.php <<'PHP'
<?php

declare(strict_types=1);

/**
 * Gestiona una única conexión PDO a MySQL.
 */
final class Database
{
    private static ?PDO $connection = null;

    /**
     * Obtiene la conexión PDO configurada.
     */
    public static function connection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $config = require BASE_PATH . '/config/database.php';

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            $config['host'],
            $config['port'],
            $config['database'],
            $config['charset']
        );

        self::$connection = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        return self::$connection;
    }

    private function __construct()
    {
    }
}
PHP

cat > app/core/Model.php <<'PHP'
<?php

declare(strict_types=1);

/**
 * Clase base para todos los modelos.
 */
abstract class Model
{
    protected PDO $db;

    /**
     * Inicializa la conexión de datos del modelo.
     */
    public function __construct()
    {
        $this->db = Database::connection();
    }
}
PHP

cat > app/core/Controller.php <<'PHP'
<?php

declare(strict_types=1);

/**
 * Clase base para todos los controladores.
 */
abstract class Controller
{
    /**
     * Renderiza una vista usando el layout principal.
     *
     * @param array<string, mixed> $data
     */
    protected function view(string $view, array $data = [], string $layout = 'main'): void
    {
        View::render($view, $data, $layout);
    }

    /**
     * Redirige a una ruta interna de la aplicación.
     */
    protected function redirect(string $path): never
    {
        header('Location: ' . APP_URL . $path);
        exit;
    }
}
PHP

cat > app/core/View.php <<'PHP'
<?php

declare(strict_types=1);

/**
 * Renderiza vistas y layouts del sistema.
 */
final class View
{
    /**
     * Carga una vista dentro de un layout.
     *
     * @param array<string, mixed> $data
     */
    public static function render(string $view, array $data = [], string $layout = 'main'): void
    {
        $viewFile = BASE_PATH . '/app/views/' . $view . '.php';
        $layoutFile = BASE_PATH . '/app/views/layouts/' . $layout . '.php';

        if (!is_file($viewFile) || !is_file($layoutFile)) {
            http_response_code(500);
            exit('Vista o layout no encontrado.');
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewFile;
        $content = (string) ob_get_clean();

        require $layoutFile;
    }

    private function __construct()
    {
    }
}
PHP

cat > app/core/Session.php <<'PHP'
<?php

declare(strict_types=1);

/**
 * Centraliza el manejo seguro de sesiones.
 */
final class Session
{
    /**
     * Inicia una sesión segura una sola vez.
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        session_name('rmrs_session');
        session_set_cookie_params([
            'httponly' => true,
            'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'samesite' => 'Lax',
        ]);

        session_start();
        session_regenerate_id(true);
    }

    /**
     * Guarda un valor en sesión.
     */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Obtiene un valor de sesión.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Elimina un valor de sesión.
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Destruye la sesión actual.
     */
    public static function destroy(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    private function __construct()
    {
    }
}
PHP

cat > app/core/Security.php <<'PHP'
<?php

declare(strict_types=1);

/**
 * Funciones de seguridad: CSRF y escape de salida.
 */
final class Security
{
    /**
     * Genera u obtiene el token CSRF de la sesión.
     */
    public static function csrfToken(): string
    {
        $token = Session::get('csrf_token');

        if (!is_string($token)) {
            $token = bin2hex(random_bytes(32));
            Session::set('csrf_token', $token);
        }

        return $token;
    }

    /**
     * Verifica un token CSRF enviado mediante formulario.
     */
    public static function verifyCsrf(?string $token): bool
    {
        $sessionToken = Session::get('csrf_token');

        return is_string($token)
            && is_string($sessionToken)
            && hash_equals($sessionToken, $token);
    }

    /**
     * Escapa texto para mostrarlo de forma segura en HTML.
     */
    public static function escape(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    private function __construct()
    {
    }
}
PHP

cat > app/core/Validator.php <<'PHP'
<?php

declare(strict_types=1);

/**
 * Validador reutilizable para datos de formularios.
 */
final class Validator
{
    /**
     * Indica si un texto es un correo electrónico válido.
     */
    public static function email(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Indica si un texto requerido contiene valor.
     */
    public static function required(?string $value): bool
    {
        return trim((string) $value) !== '';
    }

    /**
     * Valida que un texto tenga una longitud dentro de un rango.
     */
    public static function length(string $value, int $minimum, int $maximum): bool
    {
        $length = mb_strlen(trim($value));

        return $length >= $minimum && $length <= $maximum;
    }

    private function __construct()
    {
    }
}
PHP

cat > app/core/Functions.php <<'PHP'
<?php

declare(strict_types=1);

/**
 * Escapa una cadena antes de enviarla a una vista.
 */
function e(?string $value): string
{
    return Security::escape($value);
}
PHP

cat > app/core/Router.php <<'PHP'
<?php

declare(strict_types=1);

/**
 * Registra y resuelve las rutas HTTP de la aplicación.
 */
final class Router
{
    /** @var array<string, array<string, callable|array{0: string, 1: string}>> */
    private array $routes = [];

    /**
     * Registra una ruta GET.
     */
    public function get(string $path, callable|array $action): void
    {
        $this->add('GET', $path, $action);
    }

    /**
     * Registra una ruta POST.
     */
    public function post(string $path, callable|array $action): void
    {
        $this->add('POST', $path, $action);
    }

    /**
     * Ejecuta la acción correspondiente a la solicitud.
     */
    public function dispatch(): void
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $basePath = parse_url(APP_URL, PHP_URL_PATH) ?: '';

        if ($basePath !== '' && str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath)) ?: '/';
        }

        $uri = '/' . trim($uri, '/');
        $uri = $uri === '/' ? '/' : rtrim($uri, '/');

        $action = $this->routes[$method][$uri] ?? null;

        if ($action === null) {
            http_response_code(404);
            View::render('errors/404', ['title' => 'Página no encontrada']);
            return;
        }

        if (is_callable($action)) {
            $action();
            return;
        }

        [$controller, $methodName] = $action;
        $instance = new $controller();
        $instance->{$methodName}();
    }

    /**
     * Registra una ruta por método HTTP.
     */
    private function add(string $method, string $path, callable|array $action): void
    {
        $path = '/' . trim($path, '/');
        $path = $path === '/' ? '/' : rtrim($path, '/');

        $this->routes[$method][$path] = $action;
    }
}
PHP

cat > app/controllers/HomeController.php <<'PHP'
<?php

declare(strict_types=1);

/**
 * Controlador inicial del sistema.
 */
final class HomeController extends Controller
{
    /**
     * Muestra la pantalla principal temporal del sistema.
     */
    public function index(): void
    {
        $this->view('home/index', [
            'title' => 'RMRS | Restaurant Management & Reservation System',
        ]);
    }
}
PHP

cat > app/views/layouts/main.php <<'PHP'
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <main>
        <?= $content ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
PHP

cat > app/views/home/index.php <<'PHP'
<section class="min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="card border-0 shadow-sm mx-auto" style="max-width: 720px;">
            <div class="card-body p-5 text-center">
                <i class="bi bi-shop fs-1 text-primary"></i>
                <h1 class="h2 mt-3">RMRS</h1>
                <p class="text-secondary mb-0">
                    Núcleo MVC inicial configurado correctamente.
                </p>
            </div>
        </div>
    </div>
</section>
PHP

cat > app/views/errors/404.php <<'PHP'
<section class="min-vh-100 d-flex align-items-center">
    <div class="container text-center">
        <h1 class="display-1 fw-bold">404</h1>
        <p class="lead">La página solicitada no existe.</p>
        <a class="btn btn-primary" href="<?= APP_URL ?>/">Volver al inicio</a>
    </div>
</section>
PHP

cat > routes/web.php <<'PHP'
<?php

declare(strict_types=1);

$router->get('/', [HomeController::class, 'index']);
PHP

cat > public/index.php <<'PHP'
<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';

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
PHP

cat > public/.htaccess <<'APACHE'
Options -Indexes
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]

RewriteRule ^ index.php [QSA,L]
APACHE

echo "Fase 1 completada."