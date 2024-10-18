<?php

require_once('../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /'));

require_once('../database/connection.db.php');
require_once('../database/user.class.php');
require_once('../database/product.class.php');

$db = getDatabaseConnection();

  
$condition = $_POST['condition'];

$stmt = $db->prepare("SELECT COUNT(*) FROM Condition WHERE name = ?");
$stmt->execute([$condition]);
$count = $stmt->fetchColumn();


if ($count > 0) {
  $session->addMessage('Error', 'New condition not added');
  header('Location: ../pages/controlPanel.php');
  exit();
}
else{
  $stmt = $db->prepare('INSERT INTO Condition (name) VALUES (?)');
  $stmt->execute([$condition]);
  $count = $stmt->fetchColumn();
  if ($stmt->rowCount() > 0) {
    $session->addMessage('Success', 'New condition added!');
    header('Location: ../pages/controlPanel.php');
    exit();
  } else {
    $session->addMessage('Error', 'New condition not added');
    header('Location: ../../index.php');
    exit();
  }
}
?>


