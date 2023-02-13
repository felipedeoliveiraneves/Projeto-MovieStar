<?php 

    require_once("models/user.php");

    $userModel = new user();

    $fullName = $userModel->getFullName($review->user);


    //checar se o filme tem image 
    if($review->user->image == "") {
        $movie->user->image = "user.png";
    }
?>

<div class="col-md-12 review">
    <div class="row">
        <div class="col-md-1">
            <div class="profile-image-container review-image" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $review->user->image ?>')"></div>
                </div>
                    <div class="col-md-9 author-details-container">
                        <h4 class="author-name">
                            <a href="#"><?= $fullName ?></a>
                        </h4>
                        <p><i class="fas fa-star"></i><?= $review->rating ?></p>
                    </div>
                <div class="col-md-12">
                     <p class="comment-title">Comentario:</p>
                     <p><?= $review->review ?></p>
            </div>
        </div>
    </div>