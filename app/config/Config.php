<?php// load .env and return config as array
$envPath = __DIR__ . '/../.env';
require_once __DIR__ . '/../app/Core/Dotenv.php';
$dotenv = new App\Core\Dotenv($envPath);
$dotenv->load();
// helper to fetch env with default
function env($key, $default = null) {
return $_ENV[$key] ?? $default;
}
return [
'app' => [
'env' => env('APP_ENV', 'production'),
'debug' => filter_var(env('APP_DEBUG', false),
FILTER_VALIDATE_BOOLEAN),
'url' => env('APP_URL', 'http://localhost'),
'key' => env('APP_KEY', ''),
],
'db' => [
'dsn' => sprintf(
'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
env('DB_HOST', '127.0.0.1'),
env('DB_PORT', '3306'),
env('DB_DATABASE', 'school')
),
'user' => env('DB_USERNAME', 'root'),
'pass' => env('DB_PASSWORD', '')
],
'storage' => [
'logs' => __DIR__ . '/../storage/logs',
'uploads' => __DIR__ . '/../storage/uploads',
]
];
?>