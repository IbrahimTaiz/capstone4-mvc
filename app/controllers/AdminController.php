<?php

namespace App\Controllers;

use App\Models\Admin;

class AdminController{

    function index(){
        $admin=new Admin();

        $admins=$admin->all();

        require __DIR__.'./../views/admins/index.php';
    }

    function show(){

    }

    function create(){

        require __DIR__.'./../views/admins/create.php';
    }

    function store(){
        $admin =new Admin();
        $admin->create($_POST['name'],$_POST['email']);

        $this->index();
    }
}