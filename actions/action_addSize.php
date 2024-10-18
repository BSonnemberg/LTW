<?php

require_once('../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /'));

require_once('../database/connection.db.php');
require_once('../database/user.class.php');
require_once('../database/product.class.php');

$db = getDatabaseConnection();

  
$size = $_POST['size'];

$stmt = $db->prepare("SELECT COUNT(*) FROM Size WHERE name = ?");
$stmt->execute([$size]);
$count = $stmt->fetchColumn();


if ($count > 0) {
  $session->addMessage('Error', 'New size not added');
  error_log($count);
  header('Location: ../pages/controlPanel.php');
  exit();
}
else{
  $stmt = $db->prepare('INSERT INTO Size (name) VALUES (?)');
  $stmt->execute([$size]);
  $count = $stmt->fetchColumn();
  if ($stmt->rowCount() > 0) {
    $session->addMessage('Success', 'New size added!');
    header('Location: ../pages/controlPanel.php');
    exit();
  } else {
    $session->addMessage('Error', 'New size not added');
    header('Location: ../../index.php');
    exit();
  }
}
?>