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
    
    $stmt = $db->prepare('SELECT * FROM Wishlist WHERE userId = ? AND product_id = ?');
    $stmt->execute([$user_id, $product_id]);
    $wishlist_item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($wishlist_item) {
        $session->addMessage('error', 'Product already in wishlist.');
        header('Location: ../pages/homepage.php');
        exit();
    }

    $wishlist_id = uniqid('wishlist_', true);
    $stmt = $db->prepare('INSERT INTO Wishlist ( userId, product_id) VALUES (?, ?)');
    $stmt->execute([$user_id, $product_id]);

    $session->addMessage('success', 'Product added to wishlist!');
    header('Location: ../../pages/homepage.php');
    exit();

?>