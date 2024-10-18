<?php
require_once('../database/connection.db.php');
require_once('../database/product.class.php');
require_once('../utils/session.php');

$session = new Session();
$db = getDatabaseConnection();

$userId = $_POST['user_id'];
$productIds = isset($_POST['product_ids']) ? $_POST['product_ids'] : [];
$email = $_POST['email'];
$address = $_POST['address'];
$paymentMethod = $_POST['payment_method'];
$totalPrice = 0;
$items = [];

try {
    $db->beginTransaction();
    error_log("olaaa");
    foreach ($productIds as $productId) {
        error_log($productId);
        $stmt = $db->prepare('UPDATE Product SET isPurchased = 1 WHERE id = ?');
        $stmt->execute([$productId]);

        $product = Product::getProductById($db, $productId);
        if ($product) {
            $totalPrice += $product->price;
            $items[] = $product;
        }

        $stmt = $db->prepare('DELETE FROM ShoppingCart WHERE user_id = ? AND product_id = ?');
        $stmt->execute([$userId, $productId]);
    }

    $db->commit();

    $purchaseDetails = [
        'email' => $email,
        'address' => $address,
        'payment_method' => $paymentMethod,
        'items' => $items,
        'total_price' => $totalPrice
    ];

    $session->set('purchase_details', serialize($purchaseDetails));

    header('Location: ../pages/finalpage.php');
    exit();
} catch (Exception $e) {
    $db->rollBack();
    echo "Erro ao finalizar a compra: " . $e->getMessage();
}
?>
