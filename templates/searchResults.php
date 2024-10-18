<?php function searchResults(string $query, array $productsSearch, Session $session) { ?>
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Search Results <?= htmlspecialchars($query) ?></title>
      <link rel="stylesheet" href="../css/search.css" />
      <link rel="stylesheet" href="../css/products.css" />
  </head>
  <body>
    <div class="container-products">
        <h1>Search Results: <?= htmlspecialchars($query) ?></h1>
    </div>
    <div class="listProduct">
      <?php 
      $db = getDatabaseConnection();
      foreach ($productsSearch as $product): 
          $user = User::getUserById($db, $product->userId); 
          $productPhotos = Product::getPhotoUrls($db, $product->id); 
          $productPhoto = !empty($productPhotos) ? htmlspecialchars($productPhotos[0]) : '../images/item.jpeg';
          
          if ($session->isLoggedIn()):
            $user_id = $session->getId();
            if ($product->userId !== $user_id): ?>
              <div class="item">
                <div class="user-info">
                  <a href="../pages/profile.php?user_id=<?= $user->user_id ?>" class="user-name"><?= htmlspecialchars($user->name) ?></a>
                </div>
                <?php if (!$product->isPurchased): ?>
                  <a href="../pages/displayProduct.php?product_id=<?= htmlspecialchars($product->id) ?>" class="search-icon">
                    <i class="fa-solid fa-magnifying-glass icon"></i>
                  </a>
                <?php endif; ?>
                <img src="<?= $productPhoto ?>" alt="<?= htmlspecialchars($product->name) ?>">
                <h2><?= htmlspecialchars($product->name) ?></h2>
                <div><?= htmlspecialchars($product->category) ?></div>
                <div><?= htmlspecialchars($product->condition) ?></div>
                <p><?= htmlspecialchars($product->description) ?></p>
                <div><h4>Preço: <?= htmlspecialchars((string)$product->price) ?>€</h4></div>
                <div class="button-container">
                  <?php if ($product->isPurchased): ?>
                    <span>Vendido</span>
                  <?php else: ?>
                    <button onclick="addShoppingCart('<?= htmlspecialchars($product->id, ENT_QUOTES, 'UTF-8') ?>')"><i class='bx bx-cart'></i></button>
                    <form action="../actions/action_addWishlist.php" method="post">
                      <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                      <input type="hidden" name="product_id" value="<?= htmlspecialchars($product->id) ?>">
                      <button type="submit" class="heart-button"><i class='bx bx-heart' ></i></button>
                    </form>
                  <?php endif; ?>
                </div>
              </div>
            <?php endif; ?>
          <?php else: ?>
            <div class="item">
              <div class="user-info">
                <a href="../pages/profile.php?user_id=<?= htmlspecialchars($user->user_id) ?>" class="user-name"><?= htmlspecialchars($user->name) ?></a>
              </div>
              <img src="<?= $productPhoto ?>" alt="<?= htmlspecialchars($product->name) ?>">
              <h2><?= htmlspecialchars($product->name) ?></h2>
              <div><?= htmlspecialchars($product->category) ?></div>
              <div><?= htmlspecialchars($product->condition) ?></div>
              <p><?= htmlspecialchars($product->description) ?></p>
              <div><h4>Preço: <?= htmlspecialchars((string)$product->price) ?>€</h4></div>
            </div>
          <?php endif; 
      endforeach; ?>
    </div>    
  </body>
<?php } ?>