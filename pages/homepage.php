<?php


require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ .'/../templates/common.php');
require_once(__DIR__ .'/../templates/homepage.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/products.php');

$db = getDatabaseConnection();
$products = Product::getProducts($db);

makeHeader($session);
homePage();
drawProducts($products, $session);
drawFooter()


?> 