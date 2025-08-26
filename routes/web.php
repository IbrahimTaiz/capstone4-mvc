<?php

use App\Controllers\AdminController;
use App\Core\Router;


$router=new Router();

$router->get('/CAPSTONE4-MVC/public/',[PostController::class,'index']);

$router->get('/CAPSTONE4-MVC/public/create',[PostController::class,'create']);

$router->post('/CAPSTONE4-MVC/public/store',[PostController::class,'store']);
