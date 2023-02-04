<?php

require_once("models/user.php");

class userDAO implements userDAOinterface {

    private $conn;
    private $url;

    public function __construct(PDO $conn, $url) {
        $this->conn = $conn;
        $this->url = $url; 
    }

    public function buildUser($data) {

        $user = new user();

        $user->id = $data["id"];
        $user->name = $data["name"];
        $user->lastname = $data["lastname"];
        $user->email = $data["email"];
        $user->password = $data["password"];
        $user->image = $data["image"];
        $user->bio = $data["bio"];
        $user->token = $data["token"];

        return $user;
    }
    public function create(user $user, $authUser = false){

    }
    public function update(user $user) {

    }
    public function verifyToken($protected = false) {

    }
    public function setTokenSession($token, $redirect = true) {

    }
    public function authenticateUser($email, $password) {

    }
    public function findByemail($email) {

    }
    public function findByid($id) {

    }
    public function findByToken($token) {

    }
    public function changePassword(user $user) {

    }
}