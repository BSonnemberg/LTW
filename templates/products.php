<?php 
declare(strict_types=1);
require_once('../database/product.class.php');
require_once('../database/user.class.php'); 

function drawProducts(array $products, Session $session) { ?>
  <head>
    <title>Produtos</title>
    <link rel="stylesheet" href="../css/products.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="../javascript/product.js" defer></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const filterToggle = document.getElementById('filter-toggle');
        const filterContainer = document.getElementById('filter-container');
        filterToggle.addEventListener('click', function() {
          filterContainer.classList.toggle('show');
        });
      });
    </script>
  </head>
  <body>
    <div class="container-products">
      <h1>Produtos</h1>
      <div id="filter-container" class="filter-container">
        <form id="filter-form" method="get" action="">
          <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
          <label for="category">Categoria:</label>
          <select name="category" id="category">
            <option value="">Todas</option>
            <?php
            $db = getDatabaseConnection();
            $stmt = $db->prepare('SELECT DISTINCT category FROM Product');
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $selected = (isset($_GET['category']) && $_GET['category'] == $row['category']) ? 'selected' : '';
              echo "<option value=\"{$row['category']}\" $selected>{$row['category']}</option>";
            }
            ?>
          </select>

          <label for="condition">Condição:</label>
          <select name="condition" id="condition">
            <option value="">Todas</option>
            <?php
            $stmt = $db->prepare('SELECT DISTINCT condition FROM Product');
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $selected = (isset($_GET['condition']) && $_GET['condition'] == $row['condition']) ? 'selected' : '';
              echo "<option value=\"{$row['condition']}\" $selected>{$row['condition']}</option>";
            }
            ?>
          </select>

          <label for="price-min">Preço Mínimo:</label>
          <input type="number" name="price_min" id="price-min" value="<?= isset($_GET['price_min']) ? htmlspecialchars($_GET['price_min']) : '' ?>">

          <label for="price-max">Preço Máximo:</label>
          <input type="number" name="price_max" id="price-max" value="<?= isset($_GET['price_max']) ? htmlspecialchars($_GET['price_max']) : '' ?>">

          <label for="order">Ordenar por:</label>
          <select name="order" id="order">
            <option value="asc" <?= (isset($_GET['order']) && $_GET['order'] == 'asc') ? 'selected' : '' ?>>Preço: Menor para Maior</option>
            <option value="desc" <?= (isset($_GET['order']) && $_GET['order'] == 'desc') ? 'selected' : '' ?>>Preço: Maior para Menor</option>
          </select>

          <button type="submit">Filtrar</button>
        </form>
      </div>

      <div class="listProduct">
        <?php 
        $db = getDatabaseConnection();
        $categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
        $conditionFilter = isset($_GET['condition']) ? $_GET['condition'] : '';
        $priceMinFilter = isset($_GET['price_min']) ? $_GET['price_min'] : '';
        $priceMaxFilter = isset($_GET['price_max']) ? $_GET['price_max'] : '';
        $order = isset($_GET['order']) ? $_GET['order'] : 'asc';

        $products = Product::getFilteredProducts($db, $categoryFilter, $conditionFilter, $priceMinFilter, $priceMaxFilter, $order);

        foreach ($products as $product): 
          $user = User::getUserById($db, $product->userId); 
          $productPhotos = Product::getPhotoUrls($db, $product->id); 
          $productPhoto = !empty($productPhotos) ? htmlspecialchars($productPhotos[0]) : '../images/item.jpeg';
          
          if ($session->isLoggedIn()):
            $user_id = $session->getId();
            if ($product->userId !== $user_id): ?>
              <div class="item">
                <div class="user-info">
                  <a href="../pages/profile.php?user_id=<?= $user->user_id ?>" class="user-name"><?= $user->name ?></a>
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
    </div>
  </body>
<?php } ?>

