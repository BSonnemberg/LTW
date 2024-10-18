<?php

require_once('../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /'));

require_once('../database/connection.db.php');
require_once('../database/user.class.php');

$db = getDatabaseConnection();

$id = $_POST['user_id'];

$userToPromote = User::getCurrentUser($db, $id);

if ($userToPromote->promoteToAdmin($db)) {
  $session->addMessage('sucess', 'User promote successfully!');
  header('Location: ../../index.php');
  exit();
}
else {
  $session->addMessage('error', 'Error, unsaved changes');
  header('Location: ../pages/homepage.php');
  exit();
}