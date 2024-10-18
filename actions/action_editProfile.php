<?php
declare(strict_types=1);

require_once('../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    $session->addMessage('error', "Action not available");
    die(header('Location: /'));
}

require_once('../database/connection.db.php');
require_once('../database/user.class.php');

$db = getDatabaseConnection();

$email = $_POST['email'];
$username = $_POST['username'];
$bio = $_POST['bio'];
$password = $_POST['password'];
$city = $_POST['city'];
$phone = $_POST['phone'];
$name = $_POST['name'];

$user = User::getCurrentUser($db, $session->getId());


$photoPath = $user->photo; 

if (!empty($_FILES['photo']['name'])) {
    $photo = $_FILES['photo'];
    $photoDir = '../uploads/';
    $photoName = uniqid('', true) . '.' . pathinfo($photo['name'], PATHINFO_EXTENSION);
    $photoPath = $photoDir . $photoName;
    error_log($photoPath);

    if (!move_uploaded_file($photo['tmp_name'], $photoPath)) {
        $session->addMessage('error', 'Error uploading photo');
        header('Location: ../pages/homepage.php');
        exit();
    }
}



if ($user->updateUser($db, htmlentities($phone), htmlentities($email), htmlentities($name), htmlentities($username), htmlentities($password), htmlentities($city), htmlentities($bio), $photoPath)) {
    $session->addMessage('success', 'Changes made successfully!');
    header('Location: ../../index.php');
    exit();
} else {
    $session->addMessage('error', 'Error, unsaved changes');
    header('Location: ../pages/homepage.php');
    exit();
}
?>
