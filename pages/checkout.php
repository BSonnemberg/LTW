<?php

require_once('../utils/session.php');
require_once('../database/connection.db.php');
require_once('../database/product.class.php');
require_once('../templates/common.php');
require_once('../templates/checkout.php');

$session = new Session();
$db = getDatabaseConnection();

$userId = $session->getId();
$productIds = isset($_POST['product_ids']) ? $_POST['product_ids'] : [];

makeHeader($session);
checkout($userId, $productIds, $session); 
drawFooter();
?>
