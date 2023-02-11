<?php 
    require_once("templates/header.php");
    //Verifica se usuario esta autenticado
    require_once("models/user.php");
    require_once("dao/userDAO.php");
    require_once("dao/MovieDao.php");
    
    $user = new user();
    $userDAO = new userDAO($conn, $BASE_URL);

    $userData = $userDAO->verifyToken(true);

    $moviewDao = new MovieDAO($conn, $BASE_URL);

    $id = filter_input(INPUT_GET, "id");


    if(empty($id)){

        $message->setMessage("O filme não foi encontrado!", "error", "index.php");
    
    }else {
    
        $movie = $moviewDao->findById($id);
        
        // Verifica se o filme existe 
        if(!$movie) {
    
            $message->setMessage("O filme não foi encontrado!", "error", "index.php");
       
        }
    }

    //checar se o filme tem image 
    if($movie->image == "") {
        $movie->image = "movie_cover.jpg";
    }
    
?>

<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 offset-md-1">
                <h1><?= $movie->title ?></h1>
                <p class="page-description">Altere os dados do filme no formulario abaixo:</p>
                <form id="edit-movie-form" action="<?= $BASE_URL ?>movie_process.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="type" value="update">
                <input type="hidden" name="id" value="<?= $movie->id ?>">
                    <div class="form-group">
                    <label for="title">Titulo:</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Digite o título do seu filme" value="<?= $movie->title ?>">
                    </div>
                    <div class="form-group">
                        <label for="image">Imagem:</label>
                        <input type="file" class="form-control-file" name="image" id="image">
                    </div>
                    <div class="form-group">
                    <label for="length">Duração:</label>
                    <input type="text" class="form-control" id="length" name="length" placeholder="Digite a duração do filme" value="<?= $movie->length ?>">
                    </div>
                    <div class="form-group">
                    <label for="category">Categoria:</label>
                        <select name="category" id="category" class="form-control">
                        <option value="">Selecione</option>  
                        <option value="Ação" <?= $movie->category === "Ação" ? "selected" : "" ?> >Ação</option>  
                        <option value="Drama"  <?= $movie->category === "Drama" ? "selected" : "" ?> >Drama</option>  
                        <option value="Comédia"  <?= $movie->category === "Comédia" ? "selected" : "" ?> >Comédia</option>  
                        <option value="Fantasia / Ficcção" <?= $movie->category === "Fantasia / Ficcção" ? "selected" : "" ?> >Fantasia / Ficcção</option>  
                        <option value="Romance"  <?= $movie->category === "Romance" ? "selected" : "" ?> >Romance</option>   
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="trailer">Trailer:</label>
                        <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer" value="<?= $movie->trailer ?>">
                    </div>
                    <div class="form-group">
                    <label for="description">Duração:</label>
                        <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o filme..."> <?= $movie->description ?> </textarea>
                    </div>
                    <input type="submit" class="btn card-btn" value="Adicionar filmes">
                </form>
            </div>
                <div class="col-md-3">
                <div class="movie-container" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->image ?> ')"></div>
            </div>
        </div>
    </div>
</div>

<?php 
   require_once("templates/footer.php");
?>