<?php

$tran_id = $_POST['tran_id'];
$amount = $_POST['amount'];
$tran_date = $_POST['tran_date'];

include "../../connection.php";
$conn = new mysqli($server, $user, $pass, $dbname);


//Checking connection

if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

$sql = "DELETE FROM registration WHERE trans_id= '".$tran_id."'";

$sql2= "INSERT INTO tran_info(trans_id, val_id, bank_tran_id, amount,card_issuer, card_issuer_country, tran_date,p_status) VALUES ('$tran_id','C','C','$amount','C','C','$tran_date','C')";


if ($conn->query($sql) === TRUE) {
    $conn->query($sql2);
    echo "<h2><p style='text-align: center' class='alert alert-danger'>Your payment has cancelled!! Your registration is cancelled too.</p></h2><br/> <a class='btn btn-link pull-right' href='../../../RegistrationForm.php'>Try again</a>";
} else {
    echo "Error updating record: " . $conn->error;
}