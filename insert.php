<head>
    <title>Registration</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="pages/css/custom.css"/>
</head>

<?php
include "pages/email_validation.php";


if (isset($_POST['submit'])) {
    
    if ($response == "Y") {

        include "pages/connection.php";
//Creating connection for mysqli

        $conn = new mysqli($server, $user, $pass, $dbname);


//Checking connection

        if ($conn->connect_error) {
            die("Connection failed:" . $conn->connect_error);
        }


        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $category = mysqli_real_escape_string($conn, $_POST['r_category']);
        $ieee_membership_id = mysqli_real_escape_string($conn, $_POST['membership_id']);
        $iee_m = $_POST['iee_m'];
        $Institution = mysqli_real_escape_string($conn, $_POST['institution']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $mobile = mysqli_real_escape_string($conn, $_POST['phone']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $payment_method = mysqli_real_escape_string($conn, $_POST['pay_m']);
        $date = date("d/m/Y") . ",
    " . date("h:i:sa");

        if ($payment_method == 'Offline') {

            $file = $_FILES['file'];
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileType = $file['type'];
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
            $allowed = array('zip', 'rar', 'pdf', 'jpeg', 'jpg');
            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 8388608) {
                        //$fileNameNew = uniqid('', true).".".$fileActualExt;
                        $fileNameNew = $email . "." . $fileActualExt;
                        $fileDestination = 'uploads/' . $fileNameNew;

                        //header("Location: index.php?uploadsuccess");


                        $sql = "INSERT INTO registration (name, category,membership_status, ieee_membership_id, Institution, email, mobile, country, address, payment_method, uploaded_file_name, date) VALUES ('$name', '$category', '$iee_m','$ieee_membership_id', '$Institution', '$email', '$mobile', '$country', '$address', '$payment_method', '$fileNameNew', '$date')";
                        if ($conn->query($sql) === TRUE) {
                            move_uploaded_file($fileTmpName, $fileDestination);
                            echo "<h2><p style='text-align: center' class='alert alert-success'>Registration complete!!</p></h2>";
                            echo "<h2 align='center'><a href='pages/receipt_offline.php?email=$email&m_status=$iee_m' > <button class='btn btn-success'>Generate your printable receipt</button></a></h2>";
                        } else {
                            echo $conn->error;
                        }
                    } else {
                        echo "File too large";
                    }
                } else {
                    echo $fileError;
                }
            } else {
                echo "file type not supported <br/>";
            }
        } else {
            $trans_id = substr($_POST['email'], 0, 5) . "_" . uniqid();
            $sql = "INSERT INTO registration (name, category, membership_status, ieee_membership_id, Institution, email, mobile, country, address, payment_method, date,trans_id) VALUES ('$name', '$category','$iee_m', '$ieee_membership_id', '$Institution', '$email', '$mobile', '$country', '$address', '$payment_method','$date','$trans_id')";
            if ($conn->query($sql) === TRUE) {
                include "pages/payment/payment.php";
            } else {
                echo $conn->error;
            }
        }
    }else{
        echo "<script>alert('There is another registration found with this similar Information!!!');window.location.replace('RegistrationForm.php');// window.open('RegistrationForm.php');</script>";
    }
}
?>

