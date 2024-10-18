<?php

  require_once('../database/connection.db.php');
  require_once('../database/user.class.php');
  require_once('../utils/session.php');

  $session = new Session();  
  $db = getDatabaseConnection();

  

  $user = User::getUser($db, $_POST['email'], $_POST['password']);

  if ($user!=null) {
    $session->setId($user->user_id);
    $session->set('user', $user);
    $session->addMessage('sucess', 'Logged in!');
    header('Location: ../../index.php');
    exit();

  } else{
    $session->addMessage('error', 'Login failed');
    header('Location: ../pages/login.php');
    exit();
  }
?>