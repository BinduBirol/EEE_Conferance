<?php

$tran_id = $_POST['tran_id'];
$val_id = $_POST['val_id'];
$amount = $_POST['amount'];
$card_type = $_POST['card_type'];
$store_amount = $_POST['store_amount'];
$card_no = $_POST['card_no'];
$bank_tran_id = $_POST['bank_tran_id'];
$tran_date = $_POST['tran_date'];
$currency = $_POST['currency'];
$currency_amount = $_POST['currency_amount'];
$currency_rate = $_POST['currency_rate'];
$card_issuer = $_POST['card_issuer'];
$card_brand = $_POST['card_brand'];
$card_issuer_country = $_POST['card_issuer_country'];
$card_issuer_country_code = $_POST['card_issuer_country_code'];
$store_id = $_POST['store_id'];
$verify_sign = $_POST['verify_sign'];
$base_fair = $_POST['base_fair'];




include "../../connection.php";
$conn = new mysqli($server, $user, $pass, $dbname);


//Checking connection

if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

$sql = "UPDATE registration SET val_id='".$val_id."' , p_status='S' WHERE trans_id= '".$tran_id."'";

$sql2= "INSERT INTO tran_info(trans_id, val_id, bank_tran_id, amount,card_issuer, card_issuer_country, tran_date,p_status) VALUES ('$tran_id','$val_id','$bank_tran_id','$amount','$card_issuer','$card_issuer_country','$tran_date','S')";

if ($conn->query($sql) === TRUE) {
    $conn->query($sql2);
    echo "<h2><p style='text-align: center' class='alert alert-success'>Registration complete!!</p></h2>";
    echo "<h2 align='center'><a href='../../receipt_online.php?tran_id=$tran_id' > <button class='btn btn-success'>Generate your printable receipt</button></a></h2>";
} else {
    echo "Error updating record: " . $conn->error;
}