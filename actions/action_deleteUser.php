<?php

require_once('../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /'));

require_once('../database/connection.db.php');
require_once('../database/user.class.php');
require_once('../database/product.class.php');

$db = getDatabaseConnection();

$id = $_POST['user_id'];

$userToRemove = User::getCurrentUser($db, $id);
$user_products = Product::getProductsFromUser($db, $id);

foreach($user_products as $delete_product) {
  error_log(delete_product->id);
  $delete = $db->prepare('DELETE FROM Product WHERE id = ? ;');
  $delete->execute([$delect_product->id]);
}



if (User::deleteUser($db, $id)) {
  $session->addMessage('sucess', 'User promote successfully!');
  header('Location: ../../index.php');
  exit();
}
else {
  $session->addMessage('error', 'Error, unsaved changes');
  header('Location: ../pages/homepage.php');
  exit();
}