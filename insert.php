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
                        echo  "<h2 align='center'>Registration Complete!!</h2>";
                        echo "<h2 align='center'><a href='pages/data.php?email=$email' > <button class='btn btn-success'>Generate your printable receipt</button></a></h2>";
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
            echo "<h2 align='center'>Registration Complete!!</h2>";
            echo "<h2 align='center'><a href='pages/data.php?email=$email' > <button id='d_pdf' class='btn btn-success'>Generate your printable receipt then go for Online payment</button></a></h2>";
        } else {
            echo $conn->error;
        }
    }


}

?>

<div align="center" id="paymentlink">

    <h3 class="alert alert-success">Your registration receipt has downloaded!</h3>


    <p class="subheading"><h4>Online Mode of Payment (using the ‘PAY NOW’ button):</h4></p>
    <p> Debit/Credit Cards, Mobile Banking, e-Fund Transfer (for local and international)</p>
    <ul >

        <li>Conventional and e-banking channels (please see the icons below)<br/>
            <img class="" style="height: 65px; width: 600px;" src="images\payWith.png"></img>
        </li>
    </ul>
    <p class="h6 alert alert-warning">***These services are available through an online service provider, so the
        receiver’s (organizer) bank account or
        destination mobile number will not be required.</p>

    <div class="text-center" >
        <a href="https://www.google.com">
            <button style="width: 300px;" class="btn btn-primary" >Pay Now</button>
        </a>
    </div>

</div>

<script>
    $("#paymentlink").hide();
    $("#d_pdf").click(function () {
        $("#paymentlink").slideDown();
    });



</script>
