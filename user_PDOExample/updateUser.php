<?php
//updateUser.php

require_once('User2.php');

if (isset($_POST['name'])) {
	$name = $_POST['name'];
	$id = $_POST['id'];

	$user = User2::find($id);

	$user->setFirstName($name);
	$user->save();
}

echo '<br><a href="userList.php">Back to user list</a>';