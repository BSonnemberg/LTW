<?php
  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ .'/../templates/editProfile.php');
  require_once(__DIR__ .'/../templates/common.php');
  require_once(__DIR__ . '/../database/connection.db.php');

  $db = getDatabaseConnection();


  $user_id = $session->getId();
  $user = User::getCurrentUser($db, $user_id);

  makeHeader($session);
  editProfile($user);
  drawFooter();
?>