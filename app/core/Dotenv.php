
<?php
namespace App\Core;
/**
* Very small .env loader.
* Loads lines like KEY=VALUE into $_ENV (and getenv).
*/
class Dotenv
{
private string $path;
public function __construct(string $path) {
$this->path = $path;
}
public function load(): void {
if (!file_exists($this->path)) return;
$lines = file($this->path, FILE_IGNORE_NEW_LINES |
FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
if (str_starts_with(trim($line), '#')) continue;
if (!str_contains($line, '=')) continue;
[$key, $val] = explode('=', $line, 2);
$key = trim($key);
$val = trim($val);
// remove surrounding quotes
$val = preg_replace('/^"(.*)"$/', '$1', $val);
$val = preg_replace("/^'(.*)'$/", '$1', $val);
$_ENV[$key] = $val;
putenv("$key=$val");
}
}
}
?>