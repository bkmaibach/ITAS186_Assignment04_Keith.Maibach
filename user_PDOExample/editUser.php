<?php
//editUser.php

require_once('User2.php');

if (isset($_GET['id'])) {
	echo "Editing user with id: " . $_GET['id'];

	// retrieve this User object!
	$user = User2::find($_GET['id']);
	$name = $user->getFirstName();
	$id = $user->getId();

	echo "<form method='POST' action='updateUser.php'>";
	echo "<input type=text name='name' value='$name'>";
	echo "<input type=hidden name='id' value='$id'>";
	echo "<input type='submit'>";
}

