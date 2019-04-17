<?php
// User.php

require_once("ActiveRecord.php");
require_once("Database.php");

// NOTE:
// create statement for MySQL table will be something like:
// CREATE TABLE `user` (
//	`id` INT NOT NULL AUTO_INCREMENT,
//	`name` VARCHAR(50) NOT NULL DEFAULT 'noname',
//	PRIMARY KEY (`id`)
// );

/**
 * User class implements ActiveRecord for all basic CRUD applications.
 * croftd: TODO - complete delete functionality
 */
class User implements ActiveRecord {
	
	private $id;
	private $name;

	public function getId() { return $this->id; } 

	// we shouldn't let users manually change the id, it is set
	// by the database as unique and auto_increment
    public function setId($id) { $this->id = $id; } 

    public function getName() { return $this->name; } 

    public function setName($name) { $this->name = $name; } 

    public static function find($id) {
    	try {
     	 $db = Database::connect();
	      
			// check to see if this user already exists to decide if we are going
			// to UPDATE or INSERT
	    	$result = $db->query("SELECT * FROM user WHERE id=$id");
	    	if ($result->rowCount() > 0) {
	    		$user = new User();

	    		$row = $result->fetch(PDO::FETCH_OBJ);
	    		$user->setId($row->id);
	    		$user->setName($row->name);

	    		return $user;
	    	} 
	    } catch (PDOException $e) {
	      echo "<br>Error saving customer: " . $e->getMessage();
	    }
	}

	/**
	 * findAll should return an array with all the Users
	 */
	public static function findAll() {
    	try {
	      $db = Database::connect();

			// check to see if this user already exists to decide if we are going
			// to UPDATE or INSERT
	    	$result = $db->query("SELECT * FROM user");
	    	$users = $result->fetchAll(PDO::FETCH_CLASS);

	    	return $users;
	    	
	    } catch (PDOException $e) {
	      echo "<br>Error saving customer: " . $e->getMessage();
	    }
	}

    public function save() {
	    try {
      	  $db = Database::connect();
	
	      // if id is a number then fine, but if $this->id is null
	      // we need to convert to the word 'null' for the SQL query
	      $id = $this->id;
	      if ($this->id == null) {
	        $id = 'null';
	      }
	      echo '<br>Checking for existing user with id: ' . $id;

	      $result = $db->query("SELECT * FROM user WHERE id=$id");

	      if ($result->rowCount() > 0) {
	      	echo '<br>Updating existing user';
	      	$user = $db->exec("UPDATE user SET name='$this->name' WHERE id=$this->id");

	      } else {
	      	echo '<br>Creating new user';
			// check to see if this user already $u to decide if we are going
			// to UPDATE or INSERT
		    $db->query("INSERT INTO user (name) VALUES ('$this->name')");
		    
		    // retrieve the id and set this for our User object
		    $this->id = $db->lastInsertId();
		  }
	    } catch (PDOException $e) {
	      echo "<br>Error saving User: " . $e->getMessage();
	    }

    }

    public function delete() {

    	// croftd TODO: need to implement the delete method
    }

    public function __toString() {
    	return $this->name;
	}

}