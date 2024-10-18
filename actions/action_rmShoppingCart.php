<?php
require_once('../database/connection.db.php'); 
require_once('../database/product.class.php');
require_once('../utils/session.php');

$session = new Session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Not supported.");
}

if (!isset($_POST['id'])) {
    http_response_code(400);
    die("No product.");
}

try {
    $productId = $_POST['id'];
  
    $db = getDatabaseConnection();

    $delete = $db->prepare('DELETE FROM ShoppingCart WHERE product_id = ? ;');
    if ($delete->execute([$productId])) {
        http_response_code(200);
        echo "Product removed.";
        header('Location: ../index.php');
    } else {
        http_response_code(500);
        echo "Error removing product.";
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}

?>
