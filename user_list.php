<?php
// user_list.php
require_once('User.php');
require_once('Boat.php');
require_once("header.php");
$users = User::findAll();
//var_dump($users);
echo "<table>";
foreach($users as $user)
{
    //var_dump($user);
    echo '<tr>';
    echo '<td>' . $user->getId() . ' </td><td> ' . $user->getFirstName()  . ' </td><td> ' . $user->getLastName()  . ' </td><td> ' . $user->getAddress()   . ' </td><td> ' . $user->getPhone() . '</td>';
    echo '</tr>';
}
echo "</table>";
echo "<br><br>";

?>



<form action="" method="POST">
    <label for="idRead">ID:</label>
    <input type="text" name="idRead"><br>
    <label for="submitRead">Read:</label>
    <input type="submit" name="submitRead"><br><br>
</form>


<form action="" method="POST">
    <label for="idUpdate">ID:</label>
    <input type="text" name="idUpdate"><br>
    <label for="nameUpdate">Name:</label>
    <input type="text" name="nameUpdate"><br>
    <label for="submitUpdate">Update:</label>
    <input type="submit" name="submitUpdate"><br><br>
</form>


<form action="" method="POST">
    <label for="idDelete">ID:</label>
    <input type="text" name="idDelete"><br>
    <label for="submitDelete">Delete:</label>
    <input type="submit" name="submitDelete"><br><br>
</form>

<form action="" method="POST" enctype="multipart/form-data">
    <label for="idUserUpload">User ID:</label>
    <input type="text" name="idUserUpload"><br>
    <label for="image">ID:</label>
    <input type="file" name="image"><br>
    <label for="submitFile">Upload:</label>
    <input type="submit" name="submitUpload"><br><br>
</form>

<form action="" method="POST">
    <label for="idUserPhotos">User ID:</label>
    <input type="text" name="idUserPhotos"><br>
    <label for="submitGetPhotos">Get photos:</label>
    <input type="submit" name="submitGetPhotos"><br><br>
</form>

<?php

if (isset($_POST["nameCreate"])) {
    $nameCreate = $_POST["nameCreate"];
    echo "<br>Creating new User $nameCreate<br>";
    $user = new User();
    $user->setFirstName($nameCreate);
    $user->save();
}

if (isset($_POST["idRead"])) {
    $idRead = $_POST["idRead"];
    echo "<br>Reading User $idRead<br>";
    $user = User::find($idRead);
    if ($user) {
        echo $user->getId() . ' ' . $user->getFirstName();
    } else {
        echo "<br>Could not find User $idRead<br>";
    }
}

if (isset($_POST["idUpdate"]) && isset($_POST["nameUpdate"])) {
    $idUpdate = $_POST["idUpdate"];
    $nameUpdate = $_POST["nameUpdate"];
    echo "<br>Updating User $idUpdate<br>";
    $user = User::find($idUpdate);
    //var_dump($user);
    $user->setFirstName($nameUpdate);
    $user->save();
}

if (isset($_POST["idDelete"])) {
    $idDelete = $_POST["idDelete"];
    echo "<br>Deleting User $idDelete<br>";
    $user = User::find($idDelete);
    if($user) {
        $user->delete();
    } else {
        echo "<br>Could not find User $idDelete<br>";
    }
}

if(isset($_FILES['image']) && isset($_POST["idUserUpload"]) ){
    $userId = $_POST["idUserUpload"];
    $errors= array();
    $file_name = $_FILES['image']['name'];
    $file_size =$_FILES['image']['size'];
    $file_tmp =$_FILES['image']['tmp_name'];
    $file_type=$_FILES['image']['type'];

    $exploded = explode('.',$file_name);
    $end = end($exploded);
    $file_ext=strtolower($end);

    $extensions= array("jpeg","jpg","png");

    if(in_array($file_ext,$extensions)=== false){
        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }

    if($file_size > 2097152){
        $errors[]='File size must be less than 2 MB';
    }

    if(empty($errors)==true){
        move_uploaded_file($file_tmp,"images/".$file_name);
        $boat = new Boat();
        $boat->setImage($file_name);
        $boat->setUserId($userId);
        $boat->save();
        echo "<br>Success";
    }else{
        print_r($errors);
    }
}

if (isset($_POST["idUserPhotos"])) {
    $idUserPhotos = $_POST["idUserPhotos"];
    echo "<br>Getting photos for User $idUserPhotos<br>";
    $user = User::find($idUserPhotos);
    if ($user) {
        $photos = $user->getBoats();
        foreach($photos as $boat){
            //var_dump($photos);
            $filename = $boat->getImage();
            echo "<br><img src=\"images/$filename\" alt=\"User image\">";
        }
    } else {
        echo "<br>Could not find User $idRead<br>";
    }
}
