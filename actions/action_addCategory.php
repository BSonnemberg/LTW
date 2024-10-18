<?php

require_once('../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /'));

require_once('../database/connection.db.php');
require_once('../database/user.class.php');
require_once('../database/product.class.php');

$db = getDatabaseConnection();

  
$category = $_POST['category'];


$stmt = $db->prepare("SELECT COUNT(*) FROM Category WHERE name = ?");
$stmt->execute([$category]);
$count = $stmt->fetchColumn();


if ($count > 0) {
  $session->addMessage('Error', 'New category not added');
  error_log($count);
  header('Location: ../pages/controlPanel.php');
  exit();
}
else{
  $stmt = $db->prepare('INSERT INTO Category (name) VALUES (?)');
  $stmt->execute([$category]);
  $count = $stmt->fetchColumn();
  if ($stmt->rowCount() > 0) {
    $session->addMessage('Success', 'New category added!');
    header('Location: ../pages/controlPanel.php');
    exit();
  } else {
    $session->addMessage('Error', 'New category not added');
    header('Location: ../../index.php');
    exit();
  }
}


?>
