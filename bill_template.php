<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productNames = $_POST['productName'];
    $productPrices = $_POST['productPrice'];
    $productQuantities = $_POST['productQuantity'];
    $totalAmount = 0;
}
?>
<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <title>તમારો બિલ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>તમારો બિલ</h1>
        <div class="bill-details">
            <table>
                <thead>
                    <tr>
                        <th>ઉત્પાદન નામ</th>
                        <th>ભાવ</th>
                        <th>જથ્થો</th>
                        <th>કુલ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productNames as $index => $productName) {
                        $price = $productPrices[$index];
                        $quantity = $productQuantities[$index];
                        $total = $price * $quantity;
                        $totalAmount += $total;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($productName); ?></td>
                        <td>₹<?php echo htmlspecialchars($price); ?></td>
                        <td><?php echo htmlspecialchars($quantity); ?></td>
                        <td>₹<?php echo htmlspecialchars($total); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <h2>કુલ રકમ: ₹<?php echo $totalAmount; ?></h2>
            <button id="shareWhatsapp">વોટ્સએપ પર શેર કરો</button>
        </div>
    </div>
    <script>
        document.getElementById('shareWhatsapp').addEventListener('click', function() {
            let message = "તમારો બિલ:\n\n";
            <?php foreach ($productNames as $index => $productName) { ?>
                message += "ઉત્પાદન: <?php echo htmlspecialchars($productName); ?>\n";
                message += "ભાવ: ₹<?php echo htmlspecialchars($productPrices[$index]); ?>\n";
                message += "જથ્થો: <?php echo htmlspecialchars($productQuantities[$index]); ?>\n";
                message += "કુલ: ₹<?php echo htmlspecialchars($productPrices[$index] * $productQuantities[$index]); ?>\n\n";
            <?php } ?>
            message += "કુલ રકમ: ₹<?php echo $totalAmount; ?>\n";

            let whatsappUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
        });
    </script>
</body>
</html>
