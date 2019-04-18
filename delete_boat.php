<?php
/**
 * Created by PhpStorm.
 * User: bmaib
 * Date: 4/18/2019
 * Time: 11:34 AM
 */
require_once("Boat.php");
require_once("header.php");

if (isset($_GET["id"])) {
    $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
    echo "<br>Deleting boat with ID $id<br>";
    $boatToDelete = Boat::find($id);
    $boatToDelete->delete();
}