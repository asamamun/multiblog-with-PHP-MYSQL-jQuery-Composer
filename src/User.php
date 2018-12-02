<?php
namespace App;
class User{
    public function index(){
        return "hello from user index";
    }
    public function createuser(){
        return "create user called";
    }
    public function deleteuser($id){
        return "user $id deleted";
    }
}