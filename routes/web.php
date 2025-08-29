<?php
use App\Controllers\AuthController;
use App\Controllers\StudentsController;
/*
* Public routes
*/
$router->get('/', function() {
header('Location: /students');
});
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);
/*
* Student routes (protected)
*/
$router->get('/students', [StudentsController::class, 'index'], ['auth']);
$router->get('/students/create', [StudentsController::class, 'create'],
['auth']);
$router->post('/students', [StudentsController::class, 'store'], ['auth']);
$router->get('/students/{id}', [StudentsController::class, 'show'],
['auth']);
$router->post('/students/delete', [StudentsController::class, 'destroy'],
['auth']);
?>