<?php
require_once('../database/connection.db.php');
require_once('../database/product.class.php');
require_once('../utils/session.php');
require_once('../templates/productsByCategory.php');
require_once('../templates/products.php');
require_once('../templates/common.php');

$session = new Session();
$db = getDatabaseConnection();

$category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '';

$products = Product::getProductsByCategory($db, $category);

makeHeader($session);
productsByCategory($category);
drawProducts($products, $session);
drawFooter();

?>