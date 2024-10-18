
<?php 
require_once('../database/product.class.php');
require_once('../database/user.class.php');
require_once('../database/connection.db.php');
?>

<?php function displayProduct(Product $product, Session $session) { ?>
    <head>
        <title>Produtos</title>
        <link rel="stylesheet" href="../css/displayProduct.css" />
    </head>
    <body>
        <div class="container-displayProducts">
            <div class="product">
                <div class="item">
                    <div class="image-gallery">
                        <?php
                        $db = getDatabaseConnection();
                        $photoUrls = Product::getPhotoUrls($db, $product->id);
                        if (!empty($photoUrls)) {
                            foreach ($photoUrls as $index => $url) {
                                echo "<img src=\"" . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "\" class=\"product-photo\" data-index=\"$index\" style=\"display: " . ($index === 0 ? 'block' : 'none') . ";\">";
                            }
                        } else {
                            echo "<img src=\"../images/item.jpeg\" alt=\"" . htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8') . "\" class=\"product-photo\" style=\"display: block;\">";
                        }
                        ?>
                        <?php if (count($photoUrls) > 1): ?>
                            <button class="prev" onclick="changePhoto(-1)">&#10094;</button>
                            <button class="next" onclick="changePhoto(1)">&#10095;</button>
                        <?php endif; ?>
                    </div>
                    <h2><?= htmlspecialchars($product->name) ?></h2>
                    <div><?= htmlspecialchars($product->category) ?></div>
                    <p><?= htmlspecialchars($product->description) ?></p>
                    <div class="price-and-button">
                        <h4>Preço: <?= htmlspecialchars((string)$product->price) ?>€</h4>
                        <?php if ($session->getId() !== $product->userId): ?>
                            <button class="propose-price-button" data-product-id="<?= htmlspecialchars($product->id) ?>" onclick="toggleProposalInput(this)">Propor um novo preço</button>
                            <div id="proposal-input-container-<?= htmlspecialchars($product->id) ?>" style="display: none;">
                                <textarea placeholder="Proponha um novo preço..." id="proposal-input-<?= htmlspecialchars($product->id) ?>"></textarea>
                                <button class="submit-proposal" data-product-id="<?= htmlspecialchars($product->id) ?>" onclick="submitProposal(this)">Enviar Proposta</button>
                            </div>
                        <?php else: ?>
                            <button class="view-proposals-button" onclick="toggleProposalList()">Ver Propostas</button>
                            <div id="proposal-list" style="display: none;">
                                <h2>Propostas de Preço</h2>
                                <div class="proposals-container">
                                    <?php
                                    $proposals = Product::getProposalsByProduct($db, $product->id);
                                    foreach ($proposals as $proposal) {
                                        $user = User::getUserById($db, $proposal['userId']);
                                        ?>
                                        <div class="proposal" id="proposal-<?= htmlspecialchars((string)$proposal['id'], ENT_QUOTES, 'UTF-8') ?>">
                                            <div class="proposal-meta" >
                                                <span class="proposal-author"><?= htmlspecialchars($user->name) ?> | </span>
                                                <span class="proposal-date"><?= htmlspecialchars((string)(new DateTime($proposal['dateTime']))->format('d/m/Y H:i')) ?></span>
                                                <span class="proposal-amount"><?= htmlspecialchars((string)$proposal['amount']) ?>€</span>
                                                <button class="accept-proposal" onclick="acceptProposal(<?= htmlspecialchars((string)$proposal['id']) ?>, <?= htmlspecialchars((string)$proposal['amount']) ?>)">✔</button>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="comment-section">
                <h2>Comentários</h2>
                <div class="comments-container">   
                <textarea placeholder="Adicione um comentário..."></textarea>
                <button class="submit-comment" data-product-id="<?= htmlspecialchars($product->id) ?>" onclick='addComment(this.getAttribute("data-product-id"))'>Enviar Comentário</button>
                <?php
                    $comments = Comment::getCommentsByProduct($db, $product->id);
                    foreach ($comments as $comment) {
                        $user = User::getUserById($db, $comment->userId);
                        ?>
                        <div class="comment">
                            <div class="comment-meta">
                                <span class="comment-author"><?= htmlspecialchars($user->name) ?> | </span>
                                <span class="comment-date"><?= htmlspecialchars((string)$comment->dateTime->format('d/m/Y H:i')) ?></span>
                            </div>
                            <div class="comment-content">
                                <?= htmlspecialchars($comment->comment) ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                <script src="../javascript/comment.js"></script>
                </div>
            </div>
        </div>
        <script src="../javascript/proposal.js"></script>
        <script src="../javascript/gallery.js"></script>
    </body>
<?php } ?>
