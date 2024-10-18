<?php
require_once('../database/connection.db.php');
require_once('../database/product.class.php');
require_once('../utils/session.php');

$session = new Session();
$purchaseDetails = unserialize($session->get('purchase_details')); 
if (!$purchaseDetails) {
    die('No purchase details found.');
}

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="resumo_da_compra.html"');

echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo da Compra</title>
</head>
<body>
    <h1>Resumo da Compra</h1>
    <p>Email: ' . htmlspecialchars($purchaseDetails['email'] ?? '') . '</p>
    <p>Morada: ' . htmlspecialchars($purchaseDetails['address'] ?? '') . '</p>
    <p>Método de Pagamento: ' . htmlspecialchars($purchaseDetails['payment_method'] ?? '') . '</p>
    <h2>Itens Comprados:</h2>
    <ul>';

foreach ($purchaseDetails['items'] as $item) {
    echo '<li>' . htmlspecialchars($item->name ?? '') . ' - ' . htmlspecialchars($item->price ?? '') . '€</li>';
}

echo '</ul>
    <p>Preço Total: ' . htmlspecialchars($purchaseDetails['total_price'] ?? '') . '€</p>
</body>
</html>';
?>
