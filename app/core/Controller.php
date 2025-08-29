<?php
namespace App\Core;
class Controller
{
protected function view(string $view, array $params = []): void
{
extract($params, EXTR_SKIP);
ob_start();
require __DIR__ . "/../Views/{$view}.php";
$content = ob_get_clean();
require __DIR__ . "/../Views/layouts/main.php";
}
protected function redirect(string $to): void
{
header("Location: {$to}");
exit;
}
protected function validateCsrfOrDie(): void
{
$token = $_POST['_csrf'] ?? null;
if (!Session::validateCsrf($token)) {
Session::flash('error', 'Invalid CSRF token.');
$this->redirect('/'); // or die
}
}