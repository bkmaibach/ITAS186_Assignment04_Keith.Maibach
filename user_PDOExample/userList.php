<?php
// user_list.php

require_once('User.php');

try {

	$db = new PDO('mysql:host=localhost;dbname=user;', 'root', '');

	// this is useful for error checking – have PDO throw exceptions
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$results = $db->query('SELECT * FROM user'); 
	$users = $results->fetchAll(PDO::FETCH_CLASS, 'User');

	foreach($users as $user)
	{ 
		echo '<br>' . $user->getId() . ' ' . $user->getName(); 
		echo ' ';
		echo '<a href="editUser.php?id=' . $user->getId() . '">edit</a>';
		echo ' ';
		echo '<a href="deleteUser.php?id=' . $user->getId() . '">delete</a>';
	}

} catch(PDOException $e) { 
	// for production we wouldn’t want to echo, better to log to a file
	// and direct the user to some other page
	echo '<br>PDO error: ' . $e->getMessage(); 
}

// Test updating an existing user
$user2 = new User();
$user2->setId(9);
$user2->setFirstName('Bob');
$user2->save();

?>
<br>
<br>
<form method='POST' action='addUser.php'>
	Name:<input type="text" name="name">
	<input type="submit">
</form>
