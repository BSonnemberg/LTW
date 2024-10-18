<?php


require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/product.class.php');
require_once(__DIR__ . '/../database/comment.class.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/products.php');
require_once(__DIR__ . '/../templates/displayProduct.php');
require_once(__DIR__ .'/../templates/common.php');

makeHeader($session);
$product_id = $_GET['product_id'];
$db = getDatabaseConnection();
$currentProduct = Product::getProductById($db,$product_id);
displayProduct($currentProduct, $session);
drawFooter();
?> 