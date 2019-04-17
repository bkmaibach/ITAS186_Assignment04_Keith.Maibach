<?php

require_once("Database.php");
require_once("ActiveRecord.php");

class User implements ActiveRecord
{
    protected $id;
    protected $firstName;
    protected $lastName;
    protected $phone;
    protected $address;

    public function __construct() {

    }
    public static function find($id){
        try {
            $pdo = Database::connect();
            $result = $pdo->query("SELECT * FROM user WHERE id=$id");
            //var_dump($result);
            if ($result->rowCount() > 0) {
                $user = $result->fetchAll(PDO::FETCH_CLASS, "User");
                //var_dump($user);
                return $user[0];
            }

        } catch (PDOException $e) {
            echo "<br>Error retrieving user id $id: " . $e->getMessage();
        }
    }

    public static function findAll(){
        try {
            $pdo = Database::connect();
            $result = $pdo->query("SELECT * FROM user");
            $users = $result->fetchAll(PDO::FETCH_CLASS, "User");
            return $users;

        } catch (PDOException $e) {
            echo "<br>Error retrieving users: " . $e->getMessage();
        }
    }

    public function save()
    {
        $pdo = Database::connect();
        $id = $this->id;
        $name = $this->firstName;
        if ($id == null) {
            $id = "null";
        }
        $result = $pdo->query("SELECT * FROM `user` WHERE id=$id");

        if (!$result || $id == "null") {
            echo "<br>ID $id does not exist so inserting new row";
            $pdo->query("INSERT INTO user (name) VALUES ('$name')");
        } else {
            echo "<br>ID $id does exist so updating row";
            $pdo->exec("UPDATE user SET name='$name' WHERE id=$id");
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
                echo "<p>Deleted User from user using PDO</p>";
            } else {
                print_r($stmt->errorInfo());
            }

        } catch (PDOException $e) {
            echo "<br>Error deleting user: " . $e->getMessage();
        }
    }

    public function getPhotos() {

        try {
            $pdo = Database::connect();
            $user_id = $this->id;

            // Query using the foreign key for user
            $result = $pdo->query("SELECT * FROM photo WHERE user_id=$user_id");
            $photos = $result->fetchAll(PDO::FETCH_CLASS, 'Boat');
            return $photos;

        } catch (PDOException $e) {
            echo "<br>Error getting photos: " . $e->getMessage();
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

}