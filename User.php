<?php

require_once("Database.php");
require_once("ActiveRecord.php");

class User implements ActiveRecord
{
    protected $id;
    protected $username;
    protected $password;
    protected $user_type;
    protected $first_name;
    protected $last_name;
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
        $username = $this->getUsername();
        $password = $this->getPassword();
        $userType = $this->getUserType();
        $firstName = $this->getFirstName();
        $lastName = $this->getLastName();
        $phone = $this->getPhone();
        $address = $this->getAddress();

        if ($id == null) {
            $id = "null";
        }
        $result = $pdo->query("SELECT * FROM `user` WHERE id=$id");

        if (!$result || $id == "null") {
            echo "<br>ID $id does not exist so inserting new row";

            $pdo->query("INSERT INTO user (username, password, user_type, first_name, last_name, phone, address)
              VALUES ('$username', '$password', '$userType', '$firstName', '$lastName', '$phone', '$address')");
        } else {
            echo "<br>ID $id does exist so updating row";
            $pdo->exec("UPDATE user 
                SET password='$password',
                    user_type='$userType',
                    first_name='$firstName',
                    last_name='$lastName',
                    phone='$phone',
                    address='$address'
                WHERE id=$id");
        }
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

    public function getBoats() {

        try {
            $pdo = Database::connect();
            $userId = $this->getId();

            // Query using the foreign key for user
            $result = $pdo->query("SELECT * FROM boat WHERE user_id=$userId");
            $photos = $result->fetchAll(PDO::FETCH_CLASS, 'Boat');
            return $photos;

        } catch (PDOException $e) {
            echo "<br>Error getting photos: " . $e->getMessage();
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
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        // echo $this->username;
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * @param mixed $user_type
     */
    public function setUserType($user_type): void
    {
        $this->user_type = $user_type;
    }


}