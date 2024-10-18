<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = Session::getInstance();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/user.class.php');

  require_once(__DIR__ . '/../templates/common.php');
  require_once(__DIR__ . '/../templates/homepage.php');

  header('Location: homepage.php');
?>