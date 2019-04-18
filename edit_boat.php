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
    $boatToEdit = Boat::find($id);
}
?>

<form action="" method="POST">

    <label for="boatNameEdit">Name:</label>
    <input type="text" name="boatNameEdit" value="<?php echo $boatToEdit->getName() ?>"><br>

    <label for="boatRegEdit">Registration #:</label>
    <input type="text" name="boatRegEdit" value="<?php echo $boatToEdit->getRegNumber() ?>"><br>

    <label for="boatLengthEdit">Length:</label>
    <input type="number" min="0" max="100" step="0.25" name="boatLengthEdit" value="<?php echo $boatToEdit->getLength() ?>"><br>

    <label for="boatUserIdEdit">User:</label>
    <select name="boatUserIdEdit">
        <?php
        $users = User::findAll();

        foreach($users as $user){
            if ($user->getUserType() == 0){
                $id = $user->getId();
                $username = $user->getUsername();
                echo "<option value=\"$id\">$username</option>";
            }
        }

        ?>
    </select><br><br>
    <input type="submit" name="boatSubmitEdit"><br><br>
    <input type="hidden" name="boatIdEdit" value="<?php echo $boatToEdit->getId() ?>"><br>
</form>

<?php

if(isset($_POST["boatNameEdit"]) ){
    $id = filter_var($_POST["boatIdEdit"], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($_POST["boatNameEdit"], FILTER_SANITIZE_STRING);
    $reg = filter_var($_POST["boatRegEdit"], FILTER_SANITIZE_STRING);
    $length = filter_var($_POST["boatLengthEdit"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $userId = filter_var($_POST["boatUserIdEdit"], FILTER_SANITIZE_NUMBER_INT);

    // var_dump($id);
    $boat = Boat::find($id);
    $boat->setName($name);
    $boat->setRegNumber($reg);
    $boat->setLength($length);
    $boat->setUserId($userId);
    $boat->save();
    echo "<br>Success";
}
?>
