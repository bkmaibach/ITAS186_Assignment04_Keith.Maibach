<?php
// login.php

// we will need the User class
require_once("User.php");
require_once("header.php");
// start the session!
session_start();

// check if they have posted the form with the new username/passwod
if (isset($_POST['username'])) {

	// Sanitize the username and password from POST:
	$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
	$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

	// Call the User class to check if this a valid user in the database
	$user = User::checkUser($username, $password);

	if ($user != null) {
		// Create a new user
		$_SESSION['username'] = $user->getUsername();

		echo "<br>Welcome back: " . $username;
		echo "<br><a href='index.php'>Back to main page</a>";
	} else {
		echo "<br>Sorry try again";
	}

// else show them the login form
} else {
?>

<form id='login' action='login.php' method='POST' accept-charset='UTF-8'>

<fieldset >

<legend>Login</legend>

<input type='hidden' name='submitted' id='submitted' value='1'/>

<label for='username' >Username*:</label>

<input type='text' name='username' id='username'  maxlength="50" />

<label for='password' >Password*:</label>

<input type='password' name='password' id='password' maxlength="50" />

<input type='submit' name='Submit' value='Submit' />
<?php

// close the else statement
}
echo "<br><a href='index.php'>Back to the main page</a>";

require_once("footer.php");
?>

