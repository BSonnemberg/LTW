<?php


require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/product.class.php');
require_once(__DIR__ .'/../templates/common.php');
require_once(__DIR__ .'/../templates/homepage.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/products.php');
require_once(__DIR__ . '/../templates/wishlist.php');
require_once(__DIR__ . '/../templates/login.php');

$db = getDatabaseConnection();
$user_id = $session->getId();
$wishlistProducts = Product::getWishlistItems($db,$user_id);
$user = User::getCurrentUser($db, $user_id);
if($user === null) {
    login();
}
else{makeHeader($session);
drawWishlistProducts($wishlistProducts);}
drawFooter();
?> 