<?php

require_once("models/user.php");
require_once("models/message.php");

class userDAO implements userDAOinterface {

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url) {
        $this->conn = $conn;
        $this->url = $url; 
        $this->message = new message($url);
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
    public function create(User $user, $authuser = false){
      $stmt = $this->conn->prepare("INSERT INTO users
       ( name, lastname, email, password, token)
      VALUES (:name, :lastname, :email, :password, :token)");

      $stmt->bindParam(":name", $user->name);
      $stmt->bindParam(":lastname", $user->lastname);
      $stmt->bindParam(":email", $user->email);
      $stmt->bindParam(":password", $user->password);
      $stmt->bindParam(":token", $user->token);

      $stmt->execute();
        // Executar usuario, caso usuario der true
        if($authuser) {
          $this->setTokenSession($user->token);

        }
    }
    public function update(user $user, $redirect = true) {

     $stmt = $this->conn->prepare("UPDATE users SET 
      name = :name,
      lastname = :lastname,
      email = :email,
      image = :image,
      bio = :bio,
      token = :token
      WHERE id = :id
     ");
     $stmt->bindParam(":name", $user->name);
     $stmt->bindParam(":lastname", $user->lastname);
     $stmt->bindParam(":email", $user->email);
     $stmt->bindParam(":image", $user->image);
     $stmt->bindParam(":bio", $user->bio);
     $stmt->bindParam(":token", $user->token);
     $stmt->bindParam(":id", $user->id);

    $stmt->execute(); 

     if($redirect) {

      // Redireciona para o perfil do usuario
      $this->message->setmessage("Dados atualizado com sucesso!", "success", "editprofile.php");
    }

    }
    public function verifyToken($protected = false) {

        if(!empty($_SESSION["token"])) {
          // Pega o token da session 
          $token = $_SESSION["token"];

          $user = $this->findByToken($token);
          
          if($user) {
            return $user;
          }else if($protected){
            // Redireciona  usuario não autenticado
            $this->message->setmessage("Faça a autenticação para acessar esta pagina!", "error", "index.php");
         }

          }else if($protected){
            // Redireciona  usuario não autenticado
           $this->message->setmessage("Faça a autenticação para acessar esta pagina!", "error", "index.php");
             }
      }
    public function setTokenSession($token, $redirect = true) {
      // Salvar token na sessio
      $_SESSION["token"] = $token;

      if($redirect) {

        // Redireciona para o perfil do usuario
        $this->message->setmessage("Seja bem-vindo!", "success", "editprofile.php");
      }
    }
    public function authenticateUser($email, $password) {

      $user = $this->findByEmail($email);

      if($user) {
        // checar se as senhas batem
        if(password_verify($password, $user->password)){

          // Gerar um token e inserir na session
          $token = $user->generateToken();
          $this->setTokenSession($token,false);

          // Atualizar token no usuario
          $user->token = $token;

          $this->update($user, false);

          return true;

        } else {
          return false;
        }

      }else {
        return false;
      }
    }
    public function findByEmail($email) {

        if($email != "") {

          $stmt =$this->conn->prepare("SELECT * FROM users WHERE email = :email");
          
          $stmt->bindParam(":email", $email);
          $stmt->execute();

          if($stmt->rowCount() > 0) {

            $data = $stmt->fetch();
            $user = $this->buildUser($data);

            return $user;

          }else{
            return false;
          }
        }else{
            return false;
        }
    }
    public function findByid($id) {

    }
    public function findByToken($token) {

      if($token != "") {

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = :token");
        
        $stmt->bindParam(":token", $token);
        $stmt->execute();

        if($stmt->rowCount() > 0) {

          $data = $stmt->fetch();
          $user = $this->buildUser($data);

          return $user;

        }else{
          return false;
        }
      }else{
          return false;
      }
    }

    public function destroyToken() {
      // Remove o token da session
      $_SESSION["token"] = "";

      // Redirecinar e apresentar a mensagem de sucesso
      $this->message->setmessage("Você fez o logout com sucesso!", "success", "index.php");
    }

    public function changePassword(user $user) {

    }
}