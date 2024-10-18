<?php
require_once('../utils/session.php');
require_once('../database/connection.db.php');
require_once('../database/user.class.php');
require_once('../database/product.class.php');

$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /'));

$db = getDatabaseConnection();

$product = new Product(
    $_POST['condition'],
    $session->getId(),
    $_POST['category'],
    $_POST['name'],
    $_POST['price'],
    $_POST['model'] ?? null,
    $_POST['brand'] ?? null,
    $_POST['size'] ?? null,
    null,
    $_POST['description'],
    false
);

if ($product->saveProduct($db)) {
    if (!empty($_FILES['photos']['name'][0])) {
        $photos = $_FILES['photos'];
        $photoDir = '../uploads/';
        error_log($photoDir);

        foreach ($photos['tmp_name'] as $index => $tmpName) {
            $photoName = uniqid('', true) . '.' . pathinfo($photos['name'][$index], PATHINFO_EXTENSION);
            $photoPath = $photoDir . $photoName;

            if (move_uploaded_file($tmpName, $photoPath)) {
                $stmt = $db->prepare('INSERT INTO Photo (url_photo, product_id) VALUES (?, ?)');
                if (!$stmt->execute([$photoPath, $product->id])) {
                    $session->addMessage('error', 'Error saving photo');
                }
            } else {
                $session->addMessage('error', 'Error uploading photo');
            }
        }
    }

    $session->addMessage('success', 'Product added successfully!');
    header('Location: ../../index.php');
    exit();
} else {
    $session->addMessage('error', 'Error adding product');
    header('Location: ../pages/homepage.php');
    exit();
}
?>

