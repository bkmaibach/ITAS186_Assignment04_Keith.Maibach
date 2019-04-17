<?php
//updateUser.php

require_once('User.php');

if (isset($_POST['name'])) {
	$name = $_POST['name'];
	$id = $_POST['id'];

	$user = User::find($id);

	$user->setFirstName($name);
	$user->save();
}

echo '<br><a href="userList.php">Back to user list</a>';