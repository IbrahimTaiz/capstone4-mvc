<?php

namespace App\Models;

use App\Core\App;

class Admin{

    function all(){

        $stm=App::db()->prepare("SELECT * FROM admins");

        $stm->execute();
        
       return $stm->fetchAll();
    }

    function find($id){
        $stm=App::db()->prepare("SELECT * FROM Admin WHERE id=:id");
        $stm->execute(['id'=>$id]);
        $stm->fetchAll();
    }

    function create($name,$email){

        $stm=App::db()->prepare("INSERT INTO admins(name,email) VALUES (:name,:email)");
        $stm->execute(['name'=>$name,'email'=>$email]);
    }

    function update($id, $name, $email){
        $stm= App::db()->prepare("UPDATE admins SET name=:name, email=:email WHERE id=:id");
        $stm->execute(['id'=>$id, 'name'=>$name, 'email'=>$email]);
    }

    function delete($id){
        $stm= App::db()->prepare("DELETE FROM admins WHERE id=:id");
        $stm->execute(['id'=>$id]);
    }
}