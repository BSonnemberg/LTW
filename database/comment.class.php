<?php
declare(strict_types = 1);

class Comment {
    public int $id;
    public $userId;
    public $productId;
    public string $comment;
    public DateTime $dateTime;

    public function __construct(int $id, $userId, $productId, string $comment, string $dateTime) {
        $this->id = $id;
        $this->userId = $userId;
        $this->productId = $productId;
        $this->comment = $comment;
        $this->dateTime = $dateTime ? new DateTime($dateTime) : new DateTime();
    }

    static function getCommentsByProduct(PDO $db, $productId): array {
        $stmt = $db->prepare('SELECT * FROM Comment WHERE productId = ?');
        $stmt->execute([$productId]);
        $comments = [];
        while ($comment = $stmt->fetch()) {    
            $dateTime = $comment['dateTime'] ? new DateTime($comment['dateTime']) : new DateTime();
            $comments[] = new Comment(
                (int) $comment['id'],
                $comment['userId'],
                $comment['productId'],
                $comment['comment'],
                $comment['dateTime']
            );
        }
        return $comments;
    }
    

}
?>
