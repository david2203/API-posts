<?php 
include("../db.php");
include("Post.php");

$post = new Post($pdo);
$post->CreatePost("1", "title", "imageURL", "messageP", "categoryP");


?>