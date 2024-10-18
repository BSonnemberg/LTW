<?php
require_once('../database/connection.db.php');
require_once('../database/product.class.php');
require_once('../utils/session.php');

$session = new Session();
$db = getDatabaseConnection();

$product_id = $_POST['product_id'];
$name = isset($_POST['name']) ? $_POST['name'] : null;
$price = isset($_POST['price']) ? $_POST['price'] : null;
$category = isset($_POST['category']) ? $_POST['category'] : null;
$condition = isset($_POST['condition']) ? $_POST['condition'] : null;
$description = isset($_POST['description']) ? $_POST['description'] : null;
$model = isset($_POST['model']) ? $_POST['model'] : null;
$brand = isset($_POST['brand']) ? $_POST['brand'] : null;
$size = isset($_POST['size']) ? $_POST['size'] : null;

$product = Product::getProductById($db, $product_id);
if ($product && $product->userId == $session->getId()) {
    if ($name !== null) {
        $product->name = $name;
    }
    if ($price !== null) {
        $product->price = $price;
    }
    if ($category !== null) {
        $product->category = $category;
    }
    if ($condition !== null) {
        $product->condition = $condition;
    }
    if ($description !== null) {
        $product->description = $description;
    }
    if ($model !== null) {
        $product->model = $model;
    }
    if ($brand !== null) {
        $product->brand = $brand;
    }
    if ($size !== null) {
        $product->size = $size;
    }
    
    $product->update($db);
}

header('Location: ../pages/profile.php');
exit();
?>
