<?php
namespace App\Core;
use PDO;
use PDOException;
final class App
{
private static ?PDO $pdo = null;
private static array $config = [];
public static function init(array $config): void
{
self::$config = $config;
$db = $config['db'];
try {
self::$pdo = new PDO(
$db['dsn'],
$db['user'],
$db['pass'],
[
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]
);
} catch (PDOException $e) {
// Log and show friendly message
Logger::log("DB connection failed: " . $e->getMessage());
if ($config['app']['debug']) {
die("DB connection error: " . $e->getMessage());
}
http_response_code(500);
echo "Application error. Check logs.";
exit;
}
// Ensure storage directories exist
if (!is_dir($config['storage']['logs']))
mkdir($config['storage']['logs'], 0777, true);
if (!is_dir($config['storage']['uploads']))
mkdir($config['storage']['uploads'], 0777, true);
}
public static function db(): PDO
{
if (self::$pdo === null) {
throw new \RuntimeException("Database not initialized. Call
App::init()");
}
return self::$pdo;
}
public static function config(): array
{
return self::$config;
}
}