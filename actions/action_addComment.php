<?php
require_once('../utils/session.php');
require_once('../database/connection.db.php');
require_once('../database/comment.class.php');

$session = new Session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Error");
}

if (!isset($_POST['id'], $_POST['comment'])) {
    http_response_code(400);
    die("Error adding comment.");
}

    $userId = $session->getId();
    $productId = $_POST['id'];
    $comment = $_POST['comment'];

    date_default_timezone_set('Europe/Lisbon');
    $dateTime = new DateTime();

    $db = getDatabaseConnection();

    $insert = $db->prepare('INSERT INTO Comment (userId, productId, comment, dateTime) VALUES (?, ?, ?, ?)');
  
    if ($insert->execute(array($userId, $productId, $comment, $dateTime->format('Y-m-d H:i:s')))) {
      http_response_code(201);
      echo "Add comment!";
    } else {
      http_response_code(500);
      echo "Error, comment not added";
    }

?>