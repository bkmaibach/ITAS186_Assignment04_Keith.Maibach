<?php
require_once('User2.php');

if (isset($_POST['name'])) {
	$name = $_POST['name'];
	$user = new User2();
	$user->setFirstName($name);
	$user->save();
	
	echo "<br>Added a new user with name: " . $name . " and id: " . $user->getId(); 
}