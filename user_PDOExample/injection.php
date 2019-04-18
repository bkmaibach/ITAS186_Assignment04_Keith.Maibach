<?php

require_once("Database.php");
$pdo = Database::connect();
?>
<h1>PHP Injection Example</h1>
<form action="" method="post">
<table width="50%">
    <tr>
        <td>User</td>
        <td><input type="text" name="user"></td>
    </tr>
    <tr>
        <td>Pass</td>
        <td><input type="text" name="password"></td>
    </tr>
</table>
    <input type="submit" value="Login" name="s">
</form>

<?php

if($_POST['User2']){
    $user = $_POST['User2'];
    $pass = $_POST['password'];

    // use this in user input
    // 1' OR 1 LIMIT 1; --
    // From: 
    // https://stackoverflow.com/questions/15758185/php-mysql-injection-example

    echo "<br>RAW username: <u>" . $user . "</u>";
    $user = filter_var($_POST['User2'], FILTER_SANITIZE_STRING);
    echo "<br>NEW username: <u>" . $user . "</u>";

    // NOTE this function removes special html tags only
    $user2 = htmlspecialchars($_POST['User2']);

    // trying to inject something like
    // $sql = "select * from user where name='1' OR 1 LIMIT 1; -- and password='$pass'"'
    $sql = "select * from user where name='$user' and password='$pass'";
    echo "<br>Here is the SQL: " . $sql;

    $re = $pdo->query($sql);

    echo "<br>Here are the results:<br>";
    //var_dump($re);

    while ($row = $re->fetch(PDO::FETCH_ASSOC)) {
    	echo "<br>Row: " . $row['name'] . ' Password: ' . $row['password'];
    }
    //if(mysql_num_rows($re) == 0){       
    //    echo '0';
    //}else{
    //    echo '1';
    //}
}