<head>
    <title>Registration</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/custom.css"/>
</head>

<?php

if (isset($_POST['submit'])) {

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




    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['r_category']);
    $ieee_membership_id = mysqli_real_escape_string($conn, $_POST['membership_id']);
    $Institution = mysqli_real_escape_string($conn, $_POST['institution']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['phone']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['pay_m']);
    $date =  date("d/m/Y").",
    ". date("h:i:sa");

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


                    $sql = "INSERT INTO registration (name, category, ieee_membership_id, Institution, email, mobile, country, address, payment_method, uploaded_file_name, date) VALUES ('$name', '$category', '$ieee_membership_id', '$Institution', '$email', '$mobile', '$country', '$address', '$payment_method', '$fileNameNew', '$date')";
                    if ($conn->query($sql) === TRUE) {
                        move_uploaded_file($fileTmpName, $fileDestination);
                        echo  "<h1 align='center'>File uploaded!! Record saved!!</h1>";
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
        $sql = "INSERT INTO registration (name, category, ieee_membership_id, Institution, email, mobile, country, address, payment_method, date) VALUES ('$name', '$category', '$ieee_membership_id', '$Institution', '$email', '$mobile', '$country', '$address', '$payment_method','$date')";
        if ($conn->query($sql) === TRUE) {
            echo "<h1 align='center'>Record saved!!</h1>";
            echo "<h1 align='center'><a href='pages/data.php?email=$email' > <button class='btn-success'>Generate your printable receipt</button></a></h1>";
        } else {
            echo $conn->error;
        }
    }


}

?>