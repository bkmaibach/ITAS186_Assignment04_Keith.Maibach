<?php
require_once("header.php");
// logout.php

// important the call to session start is at the start of your scripts
session_start();

// check if their is a user set in the session, and if so,
// unset the username key
//
if (isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
	unset($_SESSION['username']);

	echo "<br>See you later $username";
}

echo "<br><a href='index.php'>Back to the main page</a>";

require_once("footer.php");