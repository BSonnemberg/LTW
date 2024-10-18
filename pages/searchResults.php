<?php

require_once('../utils/session.php');
require_once('../database/connection.db.php');
require_once('../database/product.class.php');
require_once('../templates/common.php');
require_once('../templates/products.php');
require_once('../templates/searchResults.php');



$session = new Session();
$db = getDatabaseConnection();
$query = isset($_GET['query']) ? $_GET['query'] : '';
$productsSearch = Product::searchProducts($db, $query);
foreach($productsSearch as $productS) {
  error_log($productS->name);
}

makeHeader($session);
searchResults($query, $productsSearch, $session);
drawFooter();

?>

