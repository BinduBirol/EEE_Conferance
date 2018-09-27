<?php

$tran_id = $_POST['tran_id'];

include "../../connection.php";
$conn = new mysqli($server, $user, $pass, $dbname);


//Checking connection

if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

$sql = "DELETE FROM registration WHERE trans_id= '".$tran_id."'";

if ($conn->query($sql) === TRUE) {
    echo "<h2><p style='text-align: center' class='alert alert-danger'>Your payement was cancelled!! Your registration was cancelled too.</p></h2><br/> <a href='../../../RegistrationForm.php'>Try again</a>";
} else {
    echo "Error updating record: " . $conn->error;
}