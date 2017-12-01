<?php

   require("fpdf/fpdf.php");
    include("db_connect.php");
    $date=date("Y-m-d H:i:s");
    $pdf = new FPDF();
    $orderid = $_REQUEST['order_id'];
    $sqlquery=mysqli_query($conn,"UPDATE ti_orders SET status_id=15 WHERE order_id='$orderid'");
    $sqlqueryx=mysqli_query($conn,"INSERT INTO `ti_status_history`(`object_id`,`status_id`,`status_for`,`date_added`) VALUES('$orderid','15','order','$date')");
    $sqlquery1=mysqli_query($conn,"SELECT * FROM ti_orders join ti_addresses on ti_orders.address_id=ti_addresses.address_id WHERE order_id='$orderid'");
    while($row1=mysqli_fetch_array($sqlquery1)){
        $pdf->AddPage();
$pdf->SetFont('Arial','B',15);
$message="<html><body>ANNAPURNA-CAFE<br><br><body></html>";
$pdf->MultiCell(190,10,'INVOICE',1,'C');
$bill_name=$row1['first_name'].' '.$row1['last_name'];
$add1=$row1['address_1'];
$add2=$row1['address_2'];
$ct=$row1['city'];
$st=$row1['state'];
$pin=$row1['postcode'];
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(190,10,'Bill On The Account Of:- '.$bill_name,0,'L',false);
$pdf->MultiCell(190,10,'Address:- '.$add1.','.$add2.','.$ct.','.$st.','.$pin.','.'INDIA',0,'L',false);
$pdf->MultiCell(190,10,'Contact:- '.$row1['telephone'],0,'L',false);

$pdf->SetFont('Arial','B',15);
$pdf->MultiCell(190,10,'Receipt Invoice',1,'C');
$pdf->SetFont('Arial','',12);

$pdf->MultiCell(190,10,'Invoice No:'.$row1['invoice_prefix'],0,'L',false);
$pdf->MultiCell(190,10,'Date and Time of Order :- '.$row1['order_date'].' '.$row1['order_time'],0,'L',false);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(30,7,'Quantity',1,0,'C');
$pdf->Cell(120,7,'Items',1,0,'C');
$pdf->Cell(30,7,'Total',1,1,'C');
$sqlquery3=mysqli_query($conn,"SELECT * FROM ti_order_menus WHERE order_id='$orderid'");
if(mysqli_num_rows($sqlquery3)>0){
	while($row3=mysqli_fetch_array($sqlquery3)){
$pdf->Cell(30,5,$row3['quantity'],0,0,'C');
$pdf->Cell(120,5,$row3['name'],0,0,'C');
$pdf->Cell(30,5,$row3['subtotal'],0,1,'C');
}
}
$pdf->SetFont('Arial','B',14);
$pdf->Cell(30,6,' Total Due',1,0,'C');
$pdf->Cell(120,6,'Inclusive All Taxes',1,0,'C');
$pdf->Cell(30,6,$row1['order_total'],1,1,'C');
$pdf->Ln(4);
}
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(190,10,'Thank You Please Come Again ',0,'L',false);
$pdf->Output('../TastyIgniter-master/assets/bills/'.$orderid.'.pdf','F');
$response['message']='SUCCESS';
echo json_encode($response);
?>