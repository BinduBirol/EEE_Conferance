<?php
include "../connection.php";

$am_amount = $_GET['amount'];
$am_currency = $_GET['currency'];
$trans_id = $_GET['tran_id'];


$post_data = array();
$post_data['store_id'] = "test_icece001test";
$post_data['store_passwd'] = "test_icece001test@ssl";
$post_data['total_amount'] = $am_amount;
$post_data['currency'] = $am_currency;
$post_data['tran_id'] = $trans_id;
$post_data['success_url'] = "http://localhost/EEE_C/pages/payment/response/response.php";
//$post_data['success_url'] = "http://www.google.com";
$post_data['fail_url'] = "http://localhost/EEE_C/pages/payment/response/response.php";
$post_data['cancel_url'] = "http://localhost/EEE_C/pages/payment/response/response.php";
# $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE

# EMI INFO
$post_data['emi_option'] = "1";
$post_data['emi_max_inst_option'] = "9";
$post_data['emi_selected_inst'] = "9";


$sqlget = "SELECT registration.*, mst_category.name as c_name FROM registration, mst_category WHERE mst_category.id=registration.category  and mst_category.membership = membership_status and trans_id='" . $trans_id . "'";
$sqldata = mysqli_query($conn, $sqlget) or die('Connection ERROR!!');

while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {


# CUSTOMER INFORMATION
    $post_data['cus_name'] = $row['name'];
    $post_data['cus_email'] = $row['email'];
    $post_data['cus_add1'] = $row['address'];
    $post_data['cus_country'] = $row['country'];
    $post_data['cus_phone'] = $row['mobile'];


# CART PARAMETERS
    $post_data['cart'] = json_encode(array(// array("product" => "DHK TO BRS AC A1", "amount" => "200.00")

    ));
    $post_data['product_amount'] = "1";


# REQUEST SEND TO SSLCOMMERZ
    $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";

    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $direct_api_url);
    curl_setopt($handle, CURLOPT_TIMEOUT, 30);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($handle, CURLOPT_POST, 1);
    curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


    $content = curl_exec($handle);

    $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

    if ($code == 200 && !(curl_errno($handle))) {
        curl_close($handle);
        $sslcommerzResponse = $content;
    } else {
        curl_close($handle);
        echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
        exit;
    }

# PARSE THE JSON RESPONSE
    $sslcz = json_decode($sslcommerzResponse, true);

    if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
        # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
        # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
        echo "<meta http-equiv='refresh' content='0;url=" . $sslcz['GatewayPageURL'] . "'>";
        # header("Location: ". $sslcz['GatewayPageURL']);
        exit;
    } else {
        echo "JSON Data parsing error!";
    }

# REQUEST SEND TO SSLCOMMERZ
    $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";

    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $direct_api_url);
    curl_setopt($handle, CURLOPT_TIMEOUT, 30);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($handle, CURLOPT_POST, 1);
    curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


    $content = curl_exec($handle);

    $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

    if ($code == 200 && !(curl_errno($handle))) {
        curl_close($handle);
        $sslcommerzResponse = $content;
    } else {
        curl_close($handle);
        echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
        exit;
    }

# PARSE THE JSON RESPONSE
    $sslcz = json_decode($sslcommerzResponse, true);

    if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
        # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
        # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
        echo "<meta http-equiv='refresh' content='0;url=" . $sslcz['GatewayPageURL'] . "'>";
        # header("Location: ". $sslcz['GatewayPageURL']);
        exit;
    } else {
        echo "JSON Data parsing error!";
    }
}
?>