<?php

require_once("models/Review.php");
require_once("models/message.php");

require_once("dao/userDAO.php");

class ReviewDao implements ReviewDAOInterface {
  
    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url) {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new message($url);
     }

     public function buildReview($data){
        
        $reviewObject = new Review();

        $reviewObject->id = $data["id"];
        $reviewObject->rating = $data["rating"];
        $reviewObject->review = $data["review"];
        $reviewObject->users_id = $data["users_id"];
        $reviewObject->movies_id = $data["movies_id"];

        return $reviewObject;

     }
     public function create( Review $review){

      $stmt = $this->conn->prepare("INSERT INTO reviews (
         rating, review, users_id, movies_id
      ) VALUES (
         :rating, :review, :users_id, :movies_id
      )");

      $stmt->bindParam(":rating", $review->rating);
      $stmt->bindParam(":review", $review->review);
      $stmt->bindParam(":users_id", $review->users_id);
      $stmt->bindParam(":movies_id", $review->movies_id);
   
      $stmt->execute();

       // Mensagem de sucesso por adcionar filmes
       $this->message->setMessage("Critica adicionado com sucesso!", "success", "index.php");
     }
     public function getMoviesReview($id){

     }
     public function hasAlreadyReviewd($id, $userId){

     }
     public function getRatings($id){

     }
 
}