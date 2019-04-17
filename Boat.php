<?php

require_once("Database.php");
require_once("ActiveRecord.php");

class Boat implements ActiveRecord
{
    protected $id;
    protected $image;
    protected $user_id;

    public function __construct() {

    }

    public static function find($id){
        try {
            $pdo = Database::connect();
            $result = $pdo->query("SELECT * FROM photo WHERE id=$id");
            if ($result->rowCount() > 0) {
                $photo = $result->fetchAll(PDO::FETCH_CLASS, "Photo");
                return $photo[0];
            }
        } catch (PDOException $e) {
            echo "<br>Error retrieving photo id $id: " . $e->getMessage();
        }
    }

    public static function findAll(){
        try {
            $pdo = Database::connect();
            $result = $pdo->query("SELECT * FROM user");
            $photo = $result->fetchAll(PDO::FETCH_CLASS, "Photo");
            return $photo;
        } catch (PDOException $e) {
            echo "<br>Error retrieving photo: " . $e->getMessage();
        }
    }

    public function save()
    {
        $pdo = Database::connect();
        $id = $this->id;
        $image = $this->image;
        $user_id = $this->user_id;
        if ($id == null) {
            $id = "null";
        }
        $result = $pdo->query("SELECT * FROM `photo` WHERE id=$id");

        if (!$result || $id == "null") {
            echo "<br>ID $id does not exist so inserting new row";
            $pdo->query("INSERT INTO photo (image, user_id) VALUES ('$image', '$user_id')");
        } else {
            echo "<br>ID $id does exist so updating row";
            $pdo->exec("UPDATE photo SET image='$image', user_id='$user_id' WHERE id=$id");
        }
        $pdo = null;
    }


    public function delete(){
        try {
            $pdo = Database::connect();
            $sql = "DELETE FROM `user` WHERE id = (:id)";
            $stmt = $pdo->prepare($sql);
            $id = $this->id;
            $stmt->bindParam(':id', $id);
            if ($stmt->execute()) {
                echo "<p>Deleted Photo from user using PDO</p>";
            } else {
                print_r($stmt->errorInfo());
            }

        } catch (PDOException $e) {
            echo "<br>Error deleting photo: " . $e->getMessage();
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }



}