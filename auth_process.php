<?php


require_once("globals.php");
require_once("db.php");
require_once("models/user.php");
require_once("models/message.php");
require_once("dao/userDAO.php");

$message = new message($BASE_URL);
$userDAO = new userDAO($conn, $BASE_URL);

// Resgata o tipo do formulario
$type = filter_input(INPUT_POST, "type");

//verificação do tipo de formulario 
if($type === "register") {
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

// Verificação minima
if($name && $lastname && $email && $password){

    if($password === $confirmpassword){

        // verificar se o e-mail já esta cadastrado no sistema
        if($userDAO->findByEmail($email) === false) {
            $user = new user();

            // criação de  token e senha 
            $usertoken = $user->generateToken();
            $finalPassword = $user->generateToken($password);

            $user->name = $name;
            $user->lastname = $lastname;
            $user->email = $email;
            $user->password = $finalPassword;
            $user->token = $usertoken;
            
            $auth = true;

            $userDAO->create($user, $auth);
            
        }else{
                // Enviar uma msg de erro, usuario ja existe 
    $message->setmessage("Usuario já cadastrado, tente outro e-mail.", "error", "back");
        }
    }else {
            // Enviar uma msg de erro, Senhas nã batem
    $message->setmessage("As senhas não são iguais.", "error", "back");
    }
}else {
    // Enviar uma msg de erro, de dados faltante
    $message->setmessage("Por favor, preencha todos os campos.", "error", "back");
}

}else if($type === "login") {
  
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");

    //tenta autenticar usuario
    if($userDAO->authenticateUser($email, $password)){

        $message->setmessage("Seja bem-vindo!", "success", "editprofile.php");

        //Redireciona o usuario, caso não conseguir autenticar
    } else {
        $message->setmessage("Usuarios e/ou senha incorretos.", "error", "back");
    }
}else {

    $message->setmessage("Informações invalida!", "error", "index.php");
}