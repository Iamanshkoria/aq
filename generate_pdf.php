<?php

require('C:\xampp\htdocs\1\TCPDF-main\TCPDF-main/tcpdf.php'); // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerName = $_POST['customerName'];
    $date = $_POST['date'];
    $productNames = $_POST['productName'];
    $productPrices = $_POST['productPrice'];
    $productQuantities = $_POST['productQuantity'];
    $totalAmount = 0;

    // Create new PDF document
    $pdf = new TCPDF();
    $pdf->SetMargins(10, 10, 10); // Set margins
    $pdf->SetAutoPageBreak(TRUE, 10); // Auto page break with 10mm bottom margin

    // Add a page
    $pdf->AddPage();

    // Add the custom font for Gujarati
    $fontPath = 'C:\Users\Asus\AppData\Local\Microsoft\Windows\Fonts\shruti.ttf';
    $fontname = TCPDF_FONTS::addTTFfont($fontPath, 'TrueTypeUnicode', '', 96);
    $pdf->SetFont($fontname, '', 12); // Set default font

    // Title Section with Background Rectangle
    $pdf->SetFont($fontname, 'B', 24);
    $pdf->SetXY(10, 10);
    $pdf->SetFillColor(255, 255, 0); // Yellow background for title
    $pdf->MultiCell(0, 20, 'લુણાઈ ગરબા સેન્ટર', 0, 'C', true, 1);

    // Company Information
    $pdf->SetFont($fontname, '', 12);
    $pdf->SetXY(10, 30);
    $pdf->Cell(0, 10, 'તમારા સર્જનાત્મક ઉપયોગ માટે શ્રેષ્ઠ ક્લે દુકાન.', 0, 1, 'C');
    $pdf->Ln(5);

    // Customer and Date details with Border
    $pdf->SetFont($fontname, '', 14);
    $pdf->SetFillColor(220, 220, 220); // Light grey background for details section
    $pdf->Cell(0, 10, 'ગ્રાહકનું નામ: ' . htmlspecialchars($customerName, ENT_QUOTES, 'UTF-8'), 0, 1, 'L', true);
    $pdf->Cell(0, 10, 'તારીખ: ' . htmlspecialchars($date, ENT_QUOTES, 'UTF-8'), 0, 1, 'L', true);
    $pdf->Ln(10);

    // Table Header with Border and CSS-like Styling
    $pdf->SetFont($fontname, 'B', 16); // Increase font size and bold
    $pdf->SetLineWidth(0.5); // Border thickness
    $pdf->SetFillColor(0, 0, 0); // Black background for table header
    $pdf->SetTextColor(255, 255, 255); // White text color for table header
    
    $pdf->Cell(80, 12, 'વસ્તુનું નામ', 1, 0, 'C', true);
    $pdf->Cell(40, 12, 'ભાવ', 1, 0, 'C', true);
    $pdf->Cell(30, 12, 'નંગ', 1, 0, 'C', true);
    $pdf->Cell(40, 12, 'કુલ', 1, 0, 'C', true);
    $pdf->Ln();

    // Table Content with Alternating Row Colors
    $pdf->SetFont($fontname, '', 14);
    $pdf->SetTextColor(0, 0, 0); // Reset text color to black
    $rowColor = [255, 255, 255]; // White background for rows
    foreach ($productNames as $index => $productName) {
        $price = $productPrices[$index];
        $quantity = $productQuantities[$index];
        $total = $price * $quantity;
        $totalAmount += $total;

        // Alternating row colors
        $rowColor = ($rowColor == [255, 255, 255]) ? [240, 240, 240] : [255, 255, 255];
        $pdf->SetFillColor($rowColor[0], $rowColor[1], $rowColor[2]);

        $pdf->Cell(80, 12, htmlspecialchars($productName, ENT_QUOTES, 'UTF-8'), 1, 0, 'L', true);
        $pdf->Cell(40, 12, '₹ ' . number_format(htmlspecialchars($price, ENT_QUOTES, 'UTF-8')), 1, 0, 'R', true);
        $pdf->Cell(30, 12, htmlspecialchars($quantity, ENT_QUOTES, 'UTF-8'), 1, 0, 'R', true);
        $pdf->Cell(40, 12, '₹ ' . number_format(htmlspecialchars($total, ENT_QUOTES, 'UTF-8')), 1, 0, 'R', true);
        $pdf->Ln();
    }

    // Total Amount with Border
    $pdf->SetFont($fontname, 'B', 14);
    $pdf->Cell(150, 12, 'કુલ રકમ', 1, 0, 'R', true);
    $pdf->Cell(40, 12, '₹ ' . number_format(htmlspecialchars($totalAmount, ENT_QUOTES, 'UTF-8')), 1, 0, 'R', true);
    $pdf->Ln(20);

    // Contact and Address details
    $pdf->SetFont($fontname, '', 14);
    $pdf->Cell(0, 10, 'સંપર્ક કરો:', 0, 1);
    $pdf->Cell(0, 10, 'મોબાઇલ: 9725551246', 0, 1);
    $pdf->Cell(0, 10, 'વોટ્સએપ: 7984167154', 0, 1);
    $pdf->Cell(0, 10, 'ઘરનું સરનામું: Your Home Address', 0, 1);
    $pdf->Cell(0, 10, 'માલિકનું નામ: મહેશભાઈ ગોરધનભાઈ કોરિયા', 0, 1);

    // Output the PDF to the browser
    $pdf->Output('bill.pdf', 'I');
}
?>
