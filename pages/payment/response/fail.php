<?php

$tran_id = $_POST['tran_id'];
$amount = $_POST['amount'];
$card_type = $_POST['card_type'];
$card_no = $_POST['card_no'];
$bank_tran_id = $_POST['bank_tran_id'];
$tran_date = $_POST['tran_date'];
$currency = $_POST['currency'];
$currency_amount = $_POST['currency_amount'];
$currency_rate = $_POST['currency_rate'];
$card_issuer = $_POST['card_issuer'];
$card_brand = $_POST['card_brand'];


include "../../connection.php";
$conn = new mysqli($server, $user, $pass, $dbname);


//Checking connection

if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

$sql = "UPDATE registration SET  p_status='F' WHERE trans_id= '".$tran_id."'";

$sql2= "INSERT INTO tran_info(trans_id, val_id, bank_tran_id, amount,card_issuer, card_issuer_country, tran_date,p_status) VALUES ('$tran_id','F','$bank_tran_id','$amount','$card_issuer','F','$tran_date','F')";


if ($conn->query($sql) === TRUE) {
    $conn->query($sql2);
    echo "<h2><p style='text-align: center' class='alert alert-danger'>Your payement was failed!!</p></h2><br/> <a href='../pay_again.php?amount=$amount&currency=$currency&tran_id=$tran_id'>Go for payment one more time</a> <a href='../../../RegistrationForm.php'>Try again</a>";
} else {
    echo "Error updating record: " . $conn->error;
}