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

<form action="" method="POST" enctype="multipart/form-data">
    <label for="boatNameCreate">Name:</label>
    <input type="text" name="boatNameCreate"><br>

    <label for="boatRegCreate">Registration #:</label>
    <input type="text" name="boatRegCreate"><br>

    <label for="boatLengthCreate">Length:</label>
    <input type="number" min="0" max="100" step="0.25" name="boatLengthCreate"><br>

    <label for="boatUserIdCreate">User:</label>
    <select name="boatUserIdCreate">
        <?php
            $users = User::findAll();

            foreach($users as $user){

                // var_dump($user);
                $id = $user->getId();
                $username = $user->getUsername();
                echo "<option value=\"$id\">$username</option>";
            }

        ?>
    </select><br>
    <label for="boatImageCreate">Photo:</label>
    <input type="file" name="boatImageCreate"><br><br>
    <input type="submit" name="boatSubmitCreate"><br><br>
</form>
<?php

if(isset($_FILES['boatImageCreate']) && isset($_POST["boatNameCreate"]) ){
    $name = filter_var($_POST["boatNameCreate"], FILTER_SANITIZE_STRING);
    $reg = filter_var($_POST["boatRegCreate"], FILTER_SANITIZE_STRING);
    $length = filter_var($_POST["boatLengthCreate"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $userId = filter_var($_POST["boatUserIdCreate"], FILTER_SANITIZE_NUMBER_INT);
    $errors= array();
    $fileName = filter_var($_FILES['boatImageCreate']['name'], FILTER_SANITIZE_STRING);
    $fileSize =$_FILES['boatImageCreate']['size'];
    $fileTmp =$_FILES['boatImageCreate']['tmp_name'];
    $fileType=$_FILES['boatImageCreate']['type'];

    $exploded = explode('.',$fileName);
    $end = end($exploded);
    $file_ext=strtolower($end);

    $extensions= array("jpeg","jpg","png");

    if(in_array($file_ext,$extensions)=== false){
    $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }

    if($fileSize > 2097152){
    $errors[]='File size must be less than 2 MB';
    }

    if(empty($errors) == true){
        move_uploaded_file($fileTmp,"images/".$fileName);
        $boat = new Boat();
        $boat->setName($name);
        $boat->setRegNumber($reg);
        $boat->setLength($length);
        $boat->setImage($fileName);
        $boat->setUserId($userId);
        $boat->save();
        echo "<br>Success";
    } else {
        print_r($errors);
    }
}
require_once("footer.php");
?>

