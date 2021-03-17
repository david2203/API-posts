<?php
    
    class Post {

        private $database_connection;
        private $userId;
        private $title;
        private $image;
        private $message;
        private $category;
        private $date;
        private $updated;

        function __construct($db) {
            $this->database_connection = $db;
        }

        
        function createPost ($userId_IN,$title_IN,$image_IN,$message_IN,$category_IN) {
            if(!empty($userId_IN)&& !empty($title_IN) && !empty($image_IN)&& !empty($message_IN) && !empty($category_IN)) {

                $sql = "INSERT INTO posts (userId,title,image,message,category,date) VALUES(:userId_IN, :title_IN, :image_IN, :message_IN, :category_IN, NOW())";
                $stmt = $this->database_connection->prepare($sql);
                $stmt->bindParam(":userId_IN", $userId_IN);
                $stmt->bindParam(":title_IN", $title_IN);
                $stmt->bindParam(":image_IN", $image_IN);
                $stmt->bindParam(":message_IN", $message_IN);
                $stmt->bindParam(":category_IN", $category_IN);
                
            

            if (!$stmt->execute()) {
                echo "could not create post!";
                die();
            }


            } else {
                $error = new stdClass();
                $error->message = "All arguments need a value!";
                $error->code = "0001";
                print_r(json_encode($error));
                die();
            }  
        }

        function getAllPosts() {
            $sql = "SELECT userId, title, image, message, category, date FROM posts";
            $stm = $this->database_connection->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>