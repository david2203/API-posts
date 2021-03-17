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

        function getPost($postId) {
            $sql = "SELECT userId, title, image, message, category, date FROM posts WHERE id=:postId_IN";
            $stmt = $this->database_connection->prepare($sql);
            $stmt->bindParam(":postId_IN", $postId);

            if( !$stmt->execute() || $stmt->rowCount() < 1 ) {
                $error = new stdClass();
                $error->message = "Post does not exist!";
                $error->code = "0003";
                print_r(json_encode($error));
                die();
            }

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->userId = $row['userId'];
            $this->title = $row['title'];
            $this->image = $row['image'];
            $this->message = $row['message'];
            $this->category = $row['category'];
            $this->date = $row['date'];
            
            return $row;

        }

        function deletePost($postId) {
            $sql = "DELETE FROM posts WHERE id=:postId_IN";
            $stmt = $this->database_connection->prepare($sql);
            $stmt->bindParam(":postId_IN", $postId);
            $stmt->execute();

            $message = new stdClass();
                if($stmt->rowCount() > 0) {
                    $message->text = "Post with id $postId removed!";
                return $message;
            }

                    $message->text = "No post with id=$postId was found!";
                return $message;
        }

        function updatePost($id, $userId="",$title="",$image="",$message="",$category="") {
            $error = new stdClass();
            $this->updateDate($id);
        if(!empty($userId)) {
            $error->message = $this->UpdateUserId($id, $userId);
        }
        if(!empty($title)) {
            $error->message = $this->Updatetitle($id, $title);
        }
        if(!empty($image)) {
            $error->message = $this->Updateimage($id, $image);
        }
        if(!empty($message)) {
            $error->message = $this->Updatemessage($id, $message);
        }
        if(!empty($category)) {
            $error->message = $this->Updatecategory($id, $category);
        }
        
       
        
       return $error;

        }

        function updateUserId($id, $userId) {
            $sql = "UPDATE posts SET userId=:userId_IN WHERE id=:id_IN";
            $statement = $this->database_connection->prepare($sql);
            $statement->bindParam(":id_IN",$id);
            $statement->bindParam(":userId_IN", $userId);
            $statement->execute();
    
           
            if($statement->rowCount() < 1) {
                return "No post with id=$id was found!";
            }
            else {
                return "Successfull edit!";
            }
        }
        function updateTitle($id, $title) {
            $sql = "UPDATE posts SET title=:title_IN WHERE id=:id_IN";
            $statement = $this->database_connection->prepare($sql);
            $statement->bindParam(":id_IN",$id);
            $statement->bindParam(":title_IN", $title);
            $statement->execute();
    
           
            if($statement->rowCount() < 1) {
                return "No post with id=$id was found!";
            }
            else {
                return "Successfull edit!";
            }
        }
        function updateImage($id, $image) {
            $sql = "UPDATE posts SET image=:image_IN WHERE id=:id_IN";
            $statement = $this->database_connection->prepare($sql);
            $statement->bindParam(":id_IN",$id);
            $statement->bindParam(":image_IN", $image);
            $statement->execute();
    
           
            if($statement->rowCount() < 1) {
                return "No post with id=$id was found!";
            }
            else {
                return "Successfull edit!";
            }
        }
        function updateMessage($id, $message) {
            $sql = "UPDATE posts SET message=:message_IN WHERE id=:id_IN";
            $statement = $this->database_connection->prepare($sql);
            $statement->bindParam(":id_IN",$id);
            $statement->bindParam(":message_IN", $message);
            $statement->execute();
    
           
            if($statement->rowCount() < 1) {
                return "No post with id=$id was found!";
            }
            else {
                return "Successfull edit!";
            }
        }
        function updateCategory($id, $category) {
            $sql = "UPDATE posts SET category=:category_IN WHERE id=:id_IN";
            $statement = $this->database_connection->prepare($sql);
            $statement->bindParam(":id_IN",$id);
            $statement->bindParam(":category_IN", $category);
            $statement->execute();
    
           
            if($statement->rowCount() < 1) {
                return "No post with id=$id was found!";
            }
            else {
                return "Successfull edit!";
            }
            
        }
        function updateDate($id) {
            $sql = "UPDATE posts SET updated=NOW() WHERE id=:id_IN";
            $statement = $this->database_connection->prepare($sql);
            $statement->bindParam(":id_IN",$id);
            $statement->execute();
        }
    }
?>