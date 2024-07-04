<?php
session_start();
require_once(__DIR__ . '/../vendor/autoload.php');

if (isset($_SESSION['user_name']) && isset($_SESSION['totalBill']) && isset($_SESSION['amountPaid'])) {
    $user_name = $_SESSION['user_name'];
    $totalBill = $_SESSION['totalBill'];
    $amountPaid = $_SESSION['amountPaid'];
    $change = $amountPaid - $totalBill;

    // Generate PDF receipt
    class PDF extends FPDF {
        function Header() {
            $this->SetFont('Arial','B',12);
            $this->Cell(0,10,'Receipt',0,1,'C');
            $this->Ln(10);
        }
    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0,10,"Name: $user_name",0,1);
    $pdf->Cell(0,10,"Total Bill: PHP ".number_format($totalBill, 2),0,1);
    $pdf->Cell(0,10,"Amount Paid: PHP ".number_format($amountPaid, 2),0,1);
    $pdf->Cell(0,10,"Change: PHP ".number_format($change, 2),0,1);

    // Output the PDF directly to the browser
    $pdf->Output('D', 'receipt.pdf'); 

    // Clear session variables
    unset($_SESSION['amountPaid']);
    // header ('power-consumption.php');
} else {
    echo "No payment information found.";
}
?>
