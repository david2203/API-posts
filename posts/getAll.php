<?php
include("../db.php");
include("Post.php");

$post = new Post ($pdo);
$posts = $post->getAllPosts();

print_r(json_encode($posts));

?>
