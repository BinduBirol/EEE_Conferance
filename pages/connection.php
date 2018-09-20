<?php
$server = "localhost";
$user = "root";
$pass = "";
$dbname = "eee_c";

//Creating connection for mysqli

$conn = new mysqli($server, $user, $pass, $dbname);


//Checking connection

if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

?>