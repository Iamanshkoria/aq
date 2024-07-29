<?php

require('C:\xampp\htdocs\1\TCPDF-main\TCPDF-main/tcpdf.php'); // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerName = $_POST['customerName'];
    $date = $_POST['date'];
    $productNames = $_POST['productName'];
    $productPrices = $_POST['productPrice'];
    $productQuantities = $_POST['productQuantity'];
    $totalAmount = 0;

    // Sanitize customer name for filename
    $safeCustomerName = preg_replace('/[^a-zA-Z0-9_]/', '_', $customerName); // Replace invalid characters
    $filename = 'bill_' . $safeCustomerName . '.pdf'; // Construct filename

    // Create new PDF document
    $pdf = new TCPDF();

    // Add a page
    $pdf->AddPage();

    // Set font
    $fontname = TCPDF_FONTS::addTTFfont('C:\xampp\htdocs\1\Noto_Sans_Gujarati\static\NotoSansGujarati-Regular.ttf', 'TrueTypeUnicode', '', 96);
    $pdf->SetFont($fontname, '', 12); // Default font

    // Title Section
    $pdf->SetFont($fontname, 'B', 24); // Bold and increased font size
    $pdf->SetXY(10, 10);
    $pdf->SetFillColor(255, 215, 0); // Gold background for title
    $pdf->Cell(0, 20, 'લુણાઈ ગરબા ભંડાર', 0, 1, 'C', true); // Centered title with background color

    // Company Information
    $pdf->SetFont($fontname, '', 12);
    $pdf->SetXY(10, 30);
    $pdf->Cell(0, 10, 'ગુણવત્તાની ખાતરી સાથે, માટીની અદ્ભુત રચનાઓ.', 0, 1, 'C');
    $pdf->Ln(10);

    // Customer and Date details
    $pdf->SetFont($fontname, '', 14);
    $pdf->SetFillColor(240, 248, 255); // Alice Blue background for details section
    $pdf->Cell(0, 10, 'નામ: ' . htmlspecialchars($customerName), 0, 1, 'L', true);
    $pdf->Cell(0, 10, 'તારીખ: ' . htmlspecialchars($date), 0, 1, 'L', true);
    $pdf->Ln(10);

    // Table Header
    $pdf->SetFont($fontname, 'B', 16); // Increase font size and bold
    $pdf->SetLineWidth(0.5); // Increase border thickness
    $pdf->SetFillColor(0, 128, 0); // Dark Green background for table header
    $pdf->SetTextColor(255, 255, 255); // White text color for table header

    $pdf->Cell(70, 12, 'વસ્તુનું નામ', 1, 0, 'C', true);
    $pdf->Cell(30, 12, 'ભાવ', 1, 0, 'C', true);
    $pdf->Cell(30, 12, 'નંગ', 1, 0, 'C', true);
    $pdf->Cell(30, 12, 'કુલ', 1, 0, 'C', true);
    $pdf->Ln();

    // Table Content
    $pdf->SetFont($fontname, '', 14);
    $pdf->SetTextColor(0, 0, 0); // Reset text color to black
    $pdf->SetFillColor(255, 255, 255); // White background for table rows
    foreach ($productNames as $index => $productName) {
        $price = $productPrices[$index];
        $quantity = $productQuantities[$index];
        $total = $price * $quantity;
        $totalAmount += $total;

        $pdf->Cell(70, 12, htmlspecialchars($productName), 1, 0, 'L', true);
        $pdf->Cell(30, 12, '₹' . htmlspecialchars($price), 1, 0, 'R', true);
        $pdf->Cell(30, 12, htmlspecialchars($quantity), 1, 0, 'R', true);
        $pdf->Cell(30, 12, '₹' . htmlspecialchars($total), 1, 0, 'R', true);
        $pdf->Ln();
    }

    // Total Amount
    $pdf->SetFont($fontname, 'B', 14);
    $pdf->SetFillColor(240, 248, 255); // Alice Blue background for total
    $pdf->Cell(130, 12, 'કુલ રકમ', 1, 0, 'C', true);
    $pdf->Cell(30, 12, '₹' . $totalAmount, 1, 1, 'R', true);
    $pdf->Ln(20);

    // Contact and Address details
    $pdf->SetFont($fontname, '', 14);
    $pdf->SetFillColor(255, 255, 255); // White background for contact details
    $pdf->Cell(0, 10, 'Contact Us:', 0, 1);

    // Owner Information
    $pdf->SetFont($fontname, '', 14);
    $pdf->Image('C:\Users\Asus\Downloads\images (2).jpg', 10, $pdf->GetY(), 0, 10, 'jpg'); // Adjust width and height as needed
    $pdf->Cell(0, 10, '      : મહેશભાઈ ગોરધનભાઈ કોરીયા', 0, 1);

    // Mobile Icon and Number
    $pdf->SetFont($fontname, '', 14);
    $pdf->Image('C:\Users\Asus\Downloads\images.jpg', 10, $pdf->GetY(), 10, 10, 'jpg');
    $pdf->Cell(0, 10, '       : 9725551246', 0, 1);

    // WhatsApp Icon and Number
    $pdf->Image('C:\Users\Asus\Downloads\download (2).jpg', 10, $pdf->GetY(), 10, 10, 'jpg');
    $pdf->Cell(0, 10, '          : 7984167154', 0, 1);

    // Home Icon and Address
    $pdf->Image('C:\Users\Asus\Downloads\images (1).jpg', 10, $pdf->GetY(), 10, 10, 'jpg');
    $pdf->Cell(0, 10, '        : પોરબંદર બોખીરા કે.કે.નગર', 0, 1);

    // Add Thank You Sentence
    $pdf->Ln(10); // Add some space before the thank you message
    $pdf->SetFont($fontname, 'I', 18); // Italic font style for thank you message
    $pdf->SetTextColor(0, 102, 204); // Blue color for thank you message
    $pdf->Cell(0, 10, 'Thank you for your purchase!', 0, 1, 'C'); // Centered thank you message
    $pdf->SetFont($fontname, '', 14); // Reset font style

    // Output the PDF
    $pdf->Output($filename, 'D'); // Save the file with the customer's name
}
?>
