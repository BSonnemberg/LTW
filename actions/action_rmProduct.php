<?php
require_once('../database/connection.db.php'); 
require_once('../database/product.class.php');
require_once('../utils/session.php');

$session = new Session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Not supported.");
}

if (!isset($_POST['id'])) {
    http_response_code(400);
    die("No product.");
}

try {
    $productId = $_POST['id'];
    
    $db = getDatabaseConnection();

    $stmt = $db->prepare('SELECT url_photo FROM Photo WHERE product_id = ?');
    $stmt->execute([$productId]);
    $photoUrls = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $db->beginTransaction();

    $deletePhotos = $db->prepare('DELETE FROM Photo WHERE product_id = ?');
    $deletePhotos->execute([$productId]);

    $deleteProduct = $db->prepare('DELETE FROM Product WHERE id = ?');
    if ($deleteProduct->execute([$productId])) {
        $db->commit();

        foreach ($photoUrls as $photoUrl) {
            if (file_exists($photoUrl)) {
                unlink($photoUrl);
            }
        }

        http_response_code(200);
        echo "Product and associated photos removed.";
        header('Location: ../index.php');
    } else {
        $db->rollBack();
        http_response_code(500);
        echo "Error removing product.";
    }
} catch (PDOException $e) {
    if ($db->inTransaction()) {
        $db->rollBack();
    }
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}
?>
