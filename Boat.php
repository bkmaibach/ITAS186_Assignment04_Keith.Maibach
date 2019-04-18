<?php

require_once("Database.php");
require_once("ActiveRecord.php");

class Boat implements ActiveRecord
{
    protected $id;
    protected $name;
    protected $reg_number;
    protected $length;
    protected $image;
    protected $user_id;

    public function __construct() {

    }

    public static function find($id){
        try {
            $pdo = Database::connect();
            $result = $pdo->query("SELECT * FROM boat WHERE id=$id");
            if ($result->rowCount() > 0) {
                $boat = $result->fetchAll(PDO::FETCH_CLASS, "Boat");
                return $boat[0];
            }
        } catch (PDOException $e) {
            echo "<br>Error retrieving boat id $id: " . $e->getMessage();
        }
    }

    public static function findAll(){
        try {
            $pdo = Database::connect();
            $result = $pdo->query("SELECT * FROM boat");
            $boat = $result->fetchAll(PDO::FETCH_CLASS, "Boat");
            return $boat;
        } catch (PDOException $e) {
            echo "<br>Error retrieving boat: " . $e->getMessage();
        }
    }

    public function save()
    {
        $pdo = Database::connect();

        $id = $this->getId();
        $name = $this->getName();
        $regNumber = $this->getRegNumber();
        $length = $this->getLength();
        $image = $this->getImage();
        $userId = $this->getUserId();

        if ($id == null) {
            $id = "null";
        }
        $result = $pdo->query("SELECT * FROM `photo` WHERE id=$id");

        if (!$result || $id == "null") {
            echo "<br>ID $id does not exist so inserting new row";
            $pdo->query("INSERT INTO `boat` (name, reg_number, length, image, user_id)
              VALUES ('$name', '$regNumber', '$length', '$image', '$userId')");
        } else {
            echo "<br>ID $id does exist so updating row";
            $pdo->exec("UPDATE boat
              SET name='$name',
                  reg_number='$regNumber',
                  length='$length',
                  image='$image', 
                  user_id='$userId'
              WHERE id=$id");
        }
    }


    public function delete(){
        try {
            $pdo = Database::connect();
            $sql = "DELETE FROM `boat` WHERE id = (:id)";
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
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getRegNumber()
    {
        return $this->reg_number;
    }

    /**
     * @param mixed $reg_number
     */
    public function setRegNumber($reg_number): void
    {
        $this->reg_number = $reg_number;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length): void
    {
        $this->length = $length;
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