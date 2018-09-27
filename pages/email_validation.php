<?php
include('connection.php');

$email = $_POST['email'];

$response= "Y";

$sqlget = "SELECT * FROM registration WHERE EMAIL='" . $email . "'";

$sqldata = mysqli_query($conn, $sqlget) or die('ERROR!!');
while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
    $response="N";
}
