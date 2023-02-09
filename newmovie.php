<?php 
    require_once("templates/header.php");
    require_once("models/user.php");
    require_once("dao/userDAO.php");
    //Verifica se usuario esta autenticado
    $user = new user();
    $userDAO = new userDAO($conn, $BASE_URL);

    $userData = $userDAO->verifyToken(true);

?>
    <div id="main-container" class="container-fluid">
      <div class="offset-md-4 col-md-4 new-movie-container">
        <h1 class="page-title">Adicionar Filmes</h1>
        <p class="page-description"> Adicione sua critica e compartilhe com o mundo!</p>
        <form action="<?= $BASE_URL ?>movie_process.php" id="add-movie-form" method="post" enctype="multipart/form-data">
           <input type="hidden" name="type" value="create" >
           <div class="form-group">
           <label for="title">Titulo:</label>
           <input type="text" class="form-control" id="title" name="title" placeholder="Digite o título do seu filme">
           </div>
           <div class="form-group">
            <label for="image">Imagem:</label>
            <input type="file" class="form-control-file" name="image" id="image">
           </div>
           <div class="form-group">
           <label for="length">Duração:</label>
           <input type="text" class="form-control" id="length" name="length" placeholder="Digite a duração do filme">
           </div>
           <div class="form-group">
           <label for="category">Categoria:</label>
            <select name="category" id="category" class="form-control">
              <option value="">Selecione</option>  
              <option value="Ação">Ação</option>  
              <option value="Drama">Drama</option>  
              <option value="Comédia">Comédia</option>  
              <option value="Fantasia / Ficcção">Fantasia / Ficcção</option>  
              <option value="Romance">Romance</option>   
            </select>
           </div>
           <div class="form-group">
            <label for="trailer">Trailer:</label>
            <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer">
           </div>
           <div class="form-group">
           <label for="description">Duração:</label>
            <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o filme..."></textarea>
           </div>
           <input type="submit" class="btn card-btn" value="Adicionar filmes">
        </form>
      </div>
    </div>

<?php 
     require_once("templates/footer.php");
?>