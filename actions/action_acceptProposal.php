<?php
declare(strict_types = 1);
require_once('../database/connection.db.php');
require_once('../database/product.class.php');
require_once('../utils/session.php');

$session = new Session();
$db = getDatabaseConnection();

if (isset($_POST['proposal_id'])) {
    $proposalId = intval($_POST['proposal_id']);

    if (Product::acceptProposal($db, $proposalId)) {
        echo json_encode(array('status' => 'success'));
    } else {
        echo json_encode(array('status' => 'error'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid input'));
}
?>
