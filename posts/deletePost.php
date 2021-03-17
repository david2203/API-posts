<?php 
include("../db.php");
include("Post.php");

$post = new Post ($pdo);

    if(!empty($_GET['id'])) {
        echo json_encode($post->deletePost($_GET['id']));
    }
    else {
        $error = new stdClass();
            $error->message = "id not specified";
            $error->code = "0004";
            echo json_encode($error);
    }
