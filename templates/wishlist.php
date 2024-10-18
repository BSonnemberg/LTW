<?php 
require_once('../database/product.class.php');
require_once('../database/user.class.php');

function drawWishlistProducts(array $wishlistProducts) { ?>
    <head>
        <title>Wishlist</title>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="../css/wishlist.css" />
        <script src="../javascript/product.js" defer></script>
    </head>
    <body>
        <div class="container-wishlist">
            <h1>Wishlist</h1>
            <div class="listProduct">
                <?php foreach ($wishlistProducts as $wishlistProduct) { ?>  
                    <div class="item" id="product-<?= htmlspecialchars($wishlistProduct['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <a href="../pages/displayProduct.php?product_id=<?php echo htmlspecialchars($wishlistProduct['id']); ?>" class="search-icon">
                            <i class="fa-solid fa-magnifying-glass icon"></i>
                        </a>
                        <img src="../images/item.jpeg" alt="<?= htmlspecialchars($wishlistProduct['name']) ?>">
                        <h2><?= htmlspecialchars($wishlistProduct['name']) ?></h2>
                        <div><?= htmlspecialchars($wishlistProduct['category']) ?></div>
                        <p><?= htmlspecialchars($wishlistProduct['description']) ?></p>
                        <div><h4>Preço: <?= htmlspecialchars($wishlistProduct['price']) ?>€</h4></div>
                        <div class="button-container">
                            <button onclick="addShoppingCart('<?= htmlspecialchars($wishlistProduct['id']) ?>')"><i class='bx bx-cart'></i></button>
                            <button class="delete-wishlist" onclick="removeWishlist('<?= htmlspecialchars($wishlistProduct['id'], ENT_QUOTES, 'UTF-8') ?>')" class="trash-icon">
                                <i class='bx bx-trash' ></i>
                            </button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </body>
<?php } ?>