<?php
    include("../db.php");
    include("Post.php");

    $id = "";
    $userId = "";
    $title = "";
    $image = "";
    $message = "";
    $category = "";
    $date = "";
     
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    } else {
        $error = new stdClass();
        $error->message = "id not specified";
        $error->code = "0004";
        echo json_encode($error);
        die();
    }

    if(isset($_GET['userId'])) {
        $userId = $_GET['userId'];
    }
    if(isset($_GET['title'])) {
        $title = $_GET['title'];
    }
    if(isset($_GET['image'])) {
        $image = $_GET['image'];
    }
    if(isset($_GET['message'])) {
        $message = $_GET['message'];
    }
    if(isset($_GET['category'])) {
        $category = $_GET['category'];
    }
    

    $post = new Post ($pdo);
    echo json_encode($post->updatePost($id,$userId,$title,$image,$message,$category));