<?php

class user {

    public $id;
    public $name;
    public $lastname;
    public $email;
    public $password;
    public $image;
    public $bio;
    public $token;

    public function generateToken(){
        return bin2hex(random_bytes(50));
    }

    public function generatePassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
        
    }
}

interface userDAOinterface {
    public function buildUser($data);
    public function create(user $user, $authUser = false);
    public function update(user $user, $redirect = true);
    public function verifyToken($protected = false);
    public function setTokenSession($token, $redirect = true);
    public function authenticateUser($email, $password);
    public function findByemail($email);
    public function findByid($id);
    public function findByToken($token);
    public function destroyToken();
    public function changePassword(user $user);
}