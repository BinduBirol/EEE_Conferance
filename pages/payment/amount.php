<?php

$sqlget = "SELECT * FROM mst_category WHERE id='" . $category . "' and membership='" . $_POST['iee_m'] . "'";
$sqldata = mysqli_query($conn, $sqlget) or die('ERROR!!');

while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
    $am_amount = $row['amount'];
    $am_currency = $row['currency'];

}