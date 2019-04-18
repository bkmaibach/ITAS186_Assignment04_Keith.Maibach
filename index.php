<?php
/**
 * index.php
 * Main entry point into the marina application
 *
 */

require_once("Boat.php");
require_once("User.php");
require_once("Database.php");
require_once("header.php");

// Start a session to maintain program state between requests
session_start();

// include the header.php on all pages
require_once("header.php");

$db = Database::connect();

$boats = Boat::findAll();

// var_dump($boats);

echo "<table border='1'>";
echo "<tr>";
echo "<th>Name</th>";
echo "<th>Registration #</th>";
echo "<th>Length</th>";
echo "<th>Owner</th>";
echo "<th>Image</th>";
echo "<th>Action</th>";
echo "</tr>";

foreach ($boats as $boat) {
    // var_dump($boat);
    $user = User::find($boat->getUserId());

    echo "<tr>";
    echo "<td>" . $boat->getName() . "</td>";
    echo "<td>" . $boat->getRegNumber() . "</td>";
    echo "<td>" . $boat->getLength() . "</td>";
    echo "<td>" . $user->getFirstName() . " " . $user->getLastName() . "</td>";

    // The list view for boats only needs to show the first photo (or none)
    $photo = $boat->getImage();
    echo "<td>";
    if ($photo != null) {
        echo "<img src=\"./images/" . $boat->getImage() . '" height="40" width="40">';
    } else { // use the default boat image
        echo "<img src=\"./images/boat1.jpg" . '" height="40" width="40">';
    }
    echo "</td>";
    echo "<td>";

    // Put the id of the boat in the URL using GET protocol

    echo "<a href='edit_boat.php?id={$boat->getId()}'>[ Edit ]</a>";

    echo "<a href='delete_boat.php?id={$boat->getId()}'>[ Delete ]</a>";
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
echo "<br>";



