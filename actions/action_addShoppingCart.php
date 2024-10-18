
<?php

require_once('../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /'));

require_once('../database/connection.db.php');
require_once('../database/user.class.php');
require_once('../database/product.class.php');

$db = getDatabaseConnection();

$product_id = $_POST['product_id'];
$user_id = $session->getId();


    $stmt = $db->prepare('SELECT * FROM Product WHERE id = ?');
    $stmt->execute([$product_id]);
    $product_data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $stmt = $db->prepare('SELECT * FROM ShoppingCart WHERE user_id = ? AND product_id = ?');
    $stmt->execute([$user_id, $product_id]);
    $shoppingcart_item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($shoppingcart_item) {
        $session->addMessage('error', 'Product already in shoppingcart.');
        header('Location: ../pages/homepage.php');
        exit();
    }


    $stmt = $db->prepare('INSERT INTO ShoppingCart(user_id, product_id) VALUES (?, ?)');
    $stmt->execute([$user_id, $product_id]);

    $session->addMessage('success', 'Product added to shoppingcart!');
    exit();

?>
