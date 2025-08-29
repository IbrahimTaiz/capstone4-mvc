<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Session;
use App\Core\App;
use App\Core\Logger;
class AuthController extends Controller
{
public static function check(): bool
{
return (bool)(Session::get('user_id') ?? false);
}
public function showLogin(): void
{
$error = Session::getFlash('error');
$this->view('auth/login', ['error' => $error]);
}
public function login(): void
{
$this->validateCsrfOrDie();
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
if ($email === '' || $password === '') {
Session::flash('error', 'Email and password are required.');
$this->redirect('/login');
}
$pdo = App::db();
$stmt = $pdo->prepare("SELECT id, name, email, password FROM users
WHERE email = :email LIMIT 1");
$stmt->execute([':email' => $email]);
$user = $stmt->fetch();
if ($user && password_verify($password, $user['password'])) {
Session::set('user_id', (int)$user['id']);
Session::set('user_name', $user['name']);
Logger::log("User {$user['email']} logged in.");
$this->redirect('/students');
}
Session::flash('error', 'Invalid credentials.');
$this->redirect('/login');
}
public function showRegister(): void
{
$error = Session::getFlash('error');
$this->view('auth/register', ['error' => $error]);
}
public function register(): void
{
$this->validateCsrfOrDie();
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$password2 = $_POST['password2'] ?? '';
if ($name === '' || $email === '' || $password === '') {
Session::flash('error', 'Please fill required fields.');
$this->redirect('/register');
}
if ($password !== $password2) {
Session::flash('error', 'Passwords do not match.');
$this->redirect('/register');
}
$pdo = App::db();
// check exists
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
$stmt->execute([':email' => $email]);
if ($stmt->fetch()) {
Session::flash('error', 'Email already exists.');
$this->redirect('/register');
}
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (name, email, password)
VALUES (:n, :e, :p)");
$stmt->execute([':n' => $name, ':e' => $email, ':p' => $hash]);
Logger::log("New user registered: $email");
Session::flash('success', 'Account created. Please login.');
$this->redirect('/login');
}
public function logout(): void
{
Session::forget('user_id');
Session::forget('user_name');
$this->redirect('/login');
}
}