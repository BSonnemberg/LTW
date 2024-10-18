
<?php

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ .'/../templates/profile.php');
require_once(__DIR__ .'/../templates/common.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../templates/login.php');
require_once(__DIR__ . '/../templates/productsByUser.php');

$session = new Session();
$db = getDatabaseConnection();

$user_id = $_GET['user_id'] ?? $session->getId();
$user = User::getUserById($db, $user_id);

if ($user === null) {
    login();
} else {
    makeHeader($session);
    makeProfile($user, $session, $db);
    
    $user_products = Product::getProductsFromUser($db, $user_id);
    if ($user_products != null) {
        drawProductsByUser($user_products, $session, $user);
    }
} 
drawFooter();
?>