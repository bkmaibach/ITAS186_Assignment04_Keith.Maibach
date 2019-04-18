<?php
/**
 * Created by PhpStorm.
 * User: bmaib
 * Date: 4/18/2019
 * Time: 11:34 AM
 */
require_once("Boat.php");
require_once("User.php");
require_once("header.php");
?>

<form action="" method="POST">
    <label for="usernameUserCreate">Username:</label>
    <input type="text" name="usernameUserCreate"><br>

    <label for="passwordUserCreate">Password:</label>
    <input type="password" name="passwordUserCreate"><br>

    <label for="userTypeUserCreate">User Type:</label>
    <select name="userTypeUserCreate">
        <option value="0">Owner</option>
        <option value="1">Regular</option>
    </select><br>

    <label for="firstNameUserCreate">First Name:</label>
    <input type="text" name="firstNameUserCreate"><br>

    <label for="lastNameUserCreate">Last Name:</label>
    <input type="text" name="lastNameUserCreate"><br>

    <label for="phoneUserCreate">Phone #:</label>
    <input type="text" name="phoneUserCreate"><br>

    <label for="addressUserCreate">Address:</label>
    <input type="text" name="addressUserCreate"><br><br>

    <input type="submit" name="userSubmitCreate"><br><br>
</form>

<?php

if (isset($_POST["usernameUserCreate"])) {
    $username = filter_var($_POST["usernameUserCreate"], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST["passwordUserCreate"], FILTER_SANITIZE_STRING);
    $userType = filter_var($_POST["userTypeUserCreate"], FILTER_SANITIZE_NUMBER_INT);
    $firstName = filter_var($_POST["firstNameUserCreate"], FILTER_SANITIZE_STRING);
    $lastName = filter_var($_POST["lastNameUserCreate"], FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST["phoneUserCreate"], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST["addressUserCreate"], FILTER_SANITIZE_STRING);
    echo "<br>Creating new user $username<br>";
    $user = new User();
    $user->setUsername($username);
    $user->setPassword($password);
    $user->setUserType($userType);
    $user->setFirstName($firstName);
    $user->setLastName($lastName);
    $user->setPhone($phone);
    $user->setAddress($address);
    $user->save();
}