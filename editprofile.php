<?php 
    require_once("templates/header.php");
    require_once("dao/userDAO.php");

    $userDAO = new userDAO($conn, $BASE_URL);

    $userData = $userDAO->verifyToken(true);
?>
    <div id="main-container" class="container-fluid">
        <h1>Edição de Perfil</h1>
    </div>

<?php 
     require_once("templates/footer.php");
?>