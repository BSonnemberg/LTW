<?php
  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ .'/../templates/editProfile.php');
  require_once(__DIR__ .'/../templates/common.php');
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ .'/../templates/controlPanel.php');

  $db = getDatabaseConnection();


  $user_id = $session->getId();
  $user = User::getCurrentUser($db, $user_id);

  if($session->isLoggedIn() != true || $user->admin != true) {
    $session->addMessage('error_notAdmin', 'Error: you do not have permission');
    header('Location: ../../index');
  }

  makeHeader($session);
  makeControlPanel();
  drawFooter();
?>