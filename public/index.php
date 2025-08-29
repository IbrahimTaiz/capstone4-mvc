<?php
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) === 0) {
        $relative = str_replace('\\', '/', substr($class, strlen($prefix)));
        $file = __DIR__ . '/../app/' . $relative . '.php';
        if (file_exists($file)) require $file;
    }
});
$router = new App\Core\Router();
require __DIR__ . '/../routes/web.php';
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

declare(strict_types=1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Start session early
session_start();
// Autoloader (simple PSR-4-ish for App\ namespace)
spl_autoload_register(function ($class) {
$prefix = 'App\\';
if (strpos($class, $prefix) === 0) {
$relative = str_replace('\\', '/', substr($class, strlen($prefix)));
$file = __DIR__ . '/../app/' . $relative . '.php';
if (file_exists($file)) require $file;
}
});
// Load config (reads .env)
$config = require __DIR__ . '/../config/config.php';
// Boot App (DB etc.)
App\Core\App::init($config);
// Instantiate router and load routes
$router = new App\Core\Router();
require __DIR__ . '/../routes/web.php';
// Dispatch
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);



?>