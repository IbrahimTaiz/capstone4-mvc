<?php
namespace App\Core;
class Router
{
private array $routes = [];
public function add(string $method, string $path, $handler, array
$middleware = []): void
{
$this->routes[] = compact('method', 'path', 'handler', 'middleware');
}
public function get(string $path, $handler, array $middleware = []): void
{
$this->add('GET', $path, $handler, $middleware);
}
public function post(string $path, $handler, array $middleware = []):
void
{
$this->add('POST', $path, $handler, $middleware);
}
public function dispatch(string $method, string $uri): void
{
$path = parse_url($uri, PHP_URL_PATH) ?: '/';
foreach ($this->routes as $route) {
if ($route['method'] !== $method) continue;
$params = $this->match($route['path'], $path);
if ($params !== false) {
// middleware
foreach ($route['middleware'] as $m) {
if ($m === 'auth' &&
!\App\Controllers\AuthController::check()) {
header('Location: /login');
exit;
}
}
$handler = $route['handler'];
if (is_array($handler)) {
[$class, $action] = $handler;
$controller = new $class();
call_user_func_array([$controller, $action], $params);
return;
} elseif (is_callable($handler)) {
call_user_func_array($handler, $params);
return;
}
}
}
http_response_code(404);
echo "404 Not Found";
}
private function match(string $routePath, string $actualPath)
{
$routePath = rtrim($routePath, '/');
$actualPath = rtrim($actualPath, '/');
if ($routePath === '') $routePath = '/';
if ($actualPath === '') $actualPath = '/';
$routeParts = explode('/', trim($routePath, '/'));
$pathParts = explode('/', trim($actualPath, '/'));
if ($routePath === '/' && $actualPath === '/') return [];
if (count($routeParts) !== count($pathParts)) {
return false;
}
$params = [];
foreach ($routeParts as $i => $rp) {
if (preg_match('/^\{(.+)\}$/', $rp, $m)) {
$params[] = $pathParts[$i];
} elseif ($rp !== $pathParts[$i]) {
return false;
}
}
return $params;
}
}