<?php
include('connection.php');

$tran_id = $_GET['tran_id'];
$date = date("D M d, Y G:i");


$sqlget = "SELECT registration.*, mst_category.name as c_name FROM registration, mst_category WHERE mst_category.id=registration.category  and mst_category.membership = membership_status and trans_id='" . $tran_id . "'";
$sqldata = mysqli_query($conn, $sqlget) or die('Connection ERROR!!');
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
    $pdf->Cell(0, 8, $row['c_name'], 0, 1, 'L');

    if (!($row['ieee_membership_id'] == null)) {
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


    $sqlget2 = "SELECT * FROM tran_info WHERE p_status='S' and trans_id='" . $tran_id . "'";
    $sqldata2 = mysqli_query($conn, $sqlget2) or die('Connection ERROR!!');

    while ($row2 = mysqli_fetch_array($sqldata2, MYSQLI_ASSOC)) {

        $pdf->SetFont("Times", "", 12);
        $pdf->Cell(40, 8, "Transaction ID:", 0, 0, 'L');
        $pdf->SetFont("Courier", "B", 12);
        $pdf->Cell(40, 8, $row2['trans_id'], 0, 1, 'L');

        $pdf->SetFont("Times", "", 12);
        $pdf->Cell(40, 8, "Amount:", 0, 0, 'L');
        $pdf->SetFont("Courier", "B", 12);
        $pdf->Cell(40, 8, $row2['amount']." Tk.", 0, 1, 'L');

        $pdf->SetFont("Times", "", 12);
        $pdf->Cell(40, 8, "Card Issuer:", 0, 0, 'L');
        $pdf->SetFont("Courier", "B", 12);
        $pdf->Cell(40, 8, $row2['card_issuer'], 0, 1, 'L');

        $pdf->SetFont("Times", "", 12);
        $pdf->Cell(40, 8, "Transection date:", 0, 0, 'L');
        $pdf->SetFont("Courier", "B", 12);
        $pdf->Cell(40, 8, $row2['tran_date'], 0, 1, 'L');
    }

    $pdf->SetFont("Times", "", 12);
    $pdf->Cell(40, 80, "", 0, 10, 'L');

    $pdf->SetFont("Times", "", 12);
    $pdf->Cell(40, 8, "Please keep this page.", 0, 1, 'L');
    $pdf->Cell(40, 8, "Executed time: " . $date, 0, 1, 'L');

    $pdf->output('D', $tran_id . '.pdf');
}
?>






