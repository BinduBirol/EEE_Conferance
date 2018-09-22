
<?php
include('connection.php');

$email = $_GET['email'];
$date = date("D M d, Y G:i");


$sqlget = "SELECT * FROM registration WHERE EMAIL='" . $email . "'";
$sqldata = mysqli_query($conn, $sqlget) or die('ERROR!!');
while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
    //echo $row['NAME'].'<br/>';
    require("fpdf/fpdf.php");

    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();
    $image1 = "images/ictp-logo.png";
    /*
    $pdf->Image('images/header.png',0,0,210,0);
    $pdf->Image('images/footer.png',0,258,210,0);
    //$pdf->Image('images/ieee3.png',30,10,0,0);
    */
    $pdf->SetFont("Courier", "", 12);
    $pdf->Cell(40, 50, "", 0, 10, 'L');


    $pdf->SetFont("Times", "", 12);
    $pdf->Cell(40, 8, "Name:", 0, 0, 'L');
    $pdf->SetFont("Courier", "B", 12);
    $pdf->Cell(0, 8, $row['name'], 0, 1, 'L');


    $pdf->SetFont("Times", "", 12);
    $pdf->Cell(40, 8, "Affiliation/ Institution:", 0, 0, 'L');
    $pdf->SetFont("Courier", "B", 12);
    $pdf->Cell(0, 8, $row['Institution'], 0, 1, 'L');


    $pdf->SetFont("Times", "", 12);
    $pdf->Cell(40, 8, "Category:", 0, 0, 'L');
    $pdf->SetFont("Courier", "B", 12);
    $pdf->Cell(0, 8, $row['category'], 0, 1, 'L');

    if(!($row['ieee_membership_id']==null)){
        $pdf->SetFont("Times", "", 12);
        $pdf->Cell(40, 8, "Ieee membership id:", 0, 0, 'L');
        $pdf->SetFont("Courier", "B", 12);
        $pdf->Cell(0, 8, $row['ieee_membership_id'], 0, 1, 'L');
    }

    $pdf->SetFont("Times", "", 12);
    $pdf->Cell(40, 8, "Address:", 0, 0, 'L');
    $pdf->SetFont("Courier", "B", 12);
    $pdf->Cell(0, 8, $row['address'], 0, 1, 'L');

    $pdf->SetFont("Times", "", 12);
    $pdf->Cell(40, 8, "Email:", 0, 0, 'L');
    $pdf->SetFont("Courier", "B", 12);
    $pdf->Cell(0, 8, $row['email'], 0, 1, 'L');

    $pdf->SetFont("Times", "", 12);
    $pdf->Cell(40, 8, "Phone:", 0, 0, 'L');
    $pdf->SetFont("Courier", "B", 12);
    $pdf->Cell(0, 8, $row['mobile'], 0, 1, 'L');

    $pdf->SetFont("Times", "", 12);
    $pdf->Cell(40, 8, "Country:", 0, 0, 'L');
    $pdf->SetFont("Courier", "B", 12);
    $pdf->Cell(0, 8, $row['country'], 0, 1, 'L');

    $pdf->SetFont("Times", "", 12);
    $pdf->Cell(40, 8, "Payment method:", 0, 0, 'L');
    $pdf->SetFont("Courier", "B", 12);
    $pdf->Cell(0, 8, $row['payment_method'], 0, 1, 'L');


    if ($row['payment_method'] == 'Offline') {
        $pdf->SetFont("Times", "", 12);
        $pdf->Cell(40, 8, "Uploaded file name:", 0, 0, 'L');
        $pdf->SetFont("Courier", 'B', 12);
        $pdf->Cell(0, 8, $row['uploaded_file_name'], 0, 1, 'L');
    }


    $pdf->SetFont("Times", "", 12);
    $pdf->Cell(40, 80, "", 0, 10, 'L');

    $pdf->SetFont("Times", "", 12);
    $pdf->Cell(40, 8, "Please keep this page.", 0, 1, 'L');
    $pdf->Cell(40, 8, "Executed time: " . $date, 0, 1, 'L');


    $pdf->output('D', $email . '.pdf');
}
?>




