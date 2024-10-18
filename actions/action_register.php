<?php

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$session = new Session();
$db = getDatabaseConnection();

function InvalidInput($session, $message) {
    $session->addMessage('error_register', $message);
    header('Location: ../pages/register.php');
    exit();
}

$admin;
$photo;
$user_id;
$email = $_POST['email'];
$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'] ?? null;
$city = $_POST['city'];
$phone = $_POST['phone'];
$bio = $_POST['bio'];

$usernameExists = User::usernameAlreadyExists($db, $username);
$userEmailExists = User::userEmailAlreadyExists($db, $email);
$userPhoneExists = User::userPhoneAlreadyExists($db, $phone);

if (empty($email)) {
    InvalidInput($session, 'Please enter an email.');
} elseif (empty($username)) {
    InvalidInput($session, 'Please enter a username');
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    InvalidInput($session, 'Email is invalid.');
} elseif (strlen($username) > 30) {
    InvalidInput($session, 'Username is too long.');
} elseif (!empty($username) && preg_match('/\s/', $username)) {
    InvalidInput($session, 'Username cannot contain white spaces.');
} elseif (!preg_match("#[0-9]+#", $password)) {
    InvalidInput($session, 'Password must contain a number.');
} else if ($userEmailExists) {
    InvalidInput($session, "Email already registered!");
}else if ($usernameExists){
    InvalidInput($session, 'Username already registered!');
}else if ($phoneExists){
    InvalidInput($session, 'Phone already registered!');
}else if ($_POST['password'] !== $_POST['password2']){ 
    InvalidInput($session, 'Passwords don\'t match!');
}else if(strlen($password) < '6'){
    InvalidInput($session, 'Password too small.');
}

  $user = new User($admin, $photo,$phone, $email,$name, $username, $password, $city, $user_id, $bio);
  
    if ($user->saveUser($db)) {
        $session->setId($user->user_id);
        $session->set('user', $user);
        $session->addMessage('register-success', 'Registration successful');
        header('Location: ../../index.php');
        exit();
    } else {
        $session->addMessage('error_signup', 'Error in sign up');
        header('Location: ../pages/register.php');
        exit();
    }

  ?>
