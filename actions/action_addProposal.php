<?php
declare(strict_types = 1);
require_once('../database/connection.db.php');
require_once('../database/product.class.php');
require_once('../utils/session.php');

$session = new Session();
$db = getDatabaseConnection();

if (isset($_POST['product_id']) && isset($_POST['amount'])) {
    $productId = $_POST['product_id'];
    $userId = $session->getId();
    $amount = floatval($_POST['amount']);



    if (Product::addProposal($db, $productId, $userId, $amount)) {
        echo json_encode(array('status' => 'success'));
    } else {
        echo json_encode(array('status' => 'error'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid input'));
}
?>
