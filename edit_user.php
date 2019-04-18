<?php
/**
 * Editd by PhpStorm.
 * User: bmaib
 * Date: 4/18/2019
 * Time: 1:28 PM
 */
require_once("Boat.php");
require_once("User.php");
require_once("header.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $userToEdit = User::find($id);
}
?>

<form action="" method="POST">

    <label for="passwordEdit">Password:</label>
    <input type="text" name="passwordEdit" value="<?php echo $userToEdit->getPassword() ?>"><br>

    <label for="userTypeEdit">User Type:</label>
    <select name="userTypeEdit" value="
        <?php
            if($userToEdit->getUserType() == 0){
                echo "Owner";
            } else {
                echo "Regular";
            }
        ?>
    ">
        <option value="0">Owner</option>
        <option value="1">Regular</option>
    </select><br>

    <label for="userTypeEdit">User Type:</label>
    <input type="text" name="userTypeEdit" value="<?php echo $userToEdit->getUserType() ?>"><br>

    <label for="firstNameEdit">First Name:</label>
    <input type="text" name="firstNameEdit" value="<?php echo $userToEdit->getFirstName() ?>"><br>

    <label for="lastNameEdit">Last Name:</label>
    <input type="text" name="lastNameEdit" value="<?php echo $userToEdit->getLastName() ?>"><br>

    <label for="phoneEdit">Phone #:</label>
    <input type="text" name="phoneEdit" value="<?php echo $userToEdit->getPhone() ?>"><br>

    <label for="addressEdit">Address:</label>
    <input type="text" name="addressEdit" value="<?php echo $userToEdit->getAddress() ?>"><br><br>

    <input type="submit" name="boatSubmitEdit"><br><br>
    <input type="hidden" name="userIdEdit" value="<?php echo $userToEdit->getId() ?>"><br>
</form>

<?php

if(isset($_POST["passwordEdit"]) ){
    $id = filter_var($_POST["userIdEdit"], FILTER_SANITIZE_NUMBER_INT);
    $password = filter_var($_POST["passwordEdit"], FILTER_SANITIZE_STRING);
    $userType = filter_var($_POST["userTypeEdit"], FILTER_SANITIZE_NUMBER_INT);
    $firstName = filter_var($_POST["firstNameEdit"], FILTER_SANITIZE_STRING);
    $lastName = filter_var($_POST["lastNameEdit"], FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST["phoneEdit"], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST["addressEdit"], FILTER_SANITIZE_STRING);

    $user = User::find($id);
    $user->setPassword($password);
    $user->setUserType($userType);
    $user->setFirstName($firstName);
    $user->setLastName($lastName);
    $user->setPhone($phone);
    $user->setAddress($address);

    echo "<br>Success";
}
require_once("footer.php");
?>
