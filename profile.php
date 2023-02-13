<?php 
    require_once("templates/header.php");
    //Verifica se usuario esta autenticado
    require_once("models/user.php");
    require_once("dao/userDAO.php");
    require_once("dao/MovieDao.php");

    $user = new user();
    $userDAO = new userDAO($conn, $BASE_URL);
    $movieDao = new MovieDAO($conn, $BASE_URL);

    //Receber id do usuário
    $id = filter_input(INPUT_GET, "id");

    if(empty($id)) {

        if(!empty($userData)) {

            $id = $userData->id;

        }else{
            $message->setMessage("Usuario não encontrado!", "error", "index.php");
        }
    }else{

        $userData = $userDAO->findById($id);

        // Se não encontrar usuario
        if(!$userData){
            $message->setMessage("Usuario não encontrado!", "error", "index.php");
        }
    }

    $fullName = $user->getFullName($userData);

    if($userData->image == "") {
        $userData->image = "user.png";
    }

    //Filmes que o usuário adicionou
    $userMovies = $movieDao->getMoviesByUserId($id);

?>

    <div id="main-container" class="container-fluid">
        <div class="col-md-7 offset-md-2">
            <div class="row-profile-container">
                <div class="col-md-12">
                    <h1 class="page-title"><?= $fullName ?></h1>
                    <div id="profile-image-container" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
                    <h3 class="about-title">Sobre:</h3>
                    <?php if(!empty($userData->bio)): ?>
                        <p class="profile-description"><?= $userData->bio ?></p>
                    <?php else: ?>
                        <p class="profile-description">O usuário ainda não escreveu nada aqui...</p>   
                    <?php endif; ?>    
                </div>
                <div class="col-md-12 added-movies-container">
                   <h3>Filmes que enviou:</h3> 
                   <?php foreach($userMovies as $movie): ?>
                        <?php require("templates/movie_card.php"); ?>
                    <?php endforeach; ?>
                    <?php if(count($userMovies) === 0 ): ?>
                        <p class="empyt-list">O usuário ainda não enviou filmes</p>
                    <?php endif ; ?>   
                </div>
            </div>
        </div>
    </div>

<?php 
   require_once("templates/footer.php");
?>