$v; }
public static function getFlash(string $k, $default = null) {
$v = $_SESSION['_flash'][$k] ?? $default;
if (isset($_SESSION['_flash'][$k])) unset($_SESSION['_flash'][$k]);
return $v;
}
// CSRF
public static function csrfToken(): string {
if (!isset($_SESSION['_csrf'])) {
$_SESSION['_csrf'] = bin2hex(random_bytes(16));
}
return $_SESSION['_csrf'];
}
public static function validateCsrf(?string $token): bool {
return isset($_SESSION['_csrf']) && hash_equals($_SESSION['_csrf'],
(string)$token);
}
}