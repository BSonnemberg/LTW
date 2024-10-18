<?php 
declare(strict_types=1); 
require_once('../database/product.class.php');
require_once('../database/connection.db.php');

function drawProductsByUser(array $products, Session $session, User $user) { 
  $db = getDatabaseConnection();
?>
  <head>
    <title>Produtos</title>
    <link rel="stylesheet" href="../css/productsByUser.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="../javascript/product.js" defer></script>
  </head>
  <body>
    <div class="container-products">
      <h1>Seus Produtos:</h1>
      <div class="box-profile-products">
        <div class="listProduct">
          <?php foreach ($products as $product) { ?>
            <?php if ($session->isLoggedIn()) { ?>
              <?php
                if ($product->userId === $user->user_id) { 
                  $photoUrls = Product::getPhotoUrls($db, $product->id);
                  $photoUrl = !empty($photoUrls) ? $photoUrls[0] : '../images/item.jpeg'; 
              ?>
                  <div class="item" id="product-<?= htmlspecialchars($product->id, ENT_QUOTES, 'UTF-8') ?>">
                    <div class="icon-container">
                    <?php if (!$product->isPurchased): ?>  
                      <a href="../pages/displayProduct.php?product_id=<?= $product->id; ?>" class="search-icon">
                        <i class="fas fa-search icon"></i>
                      </a>
                      <?php endif; ?>
                    </div>
                    <img src="<?= htmlspecialchars($photoUrl, ENT_QUOTES, 'UTF-8') ?>" alt="<?= $product->name ?>">
                    <h2><?= $product->name ?></h2>
                    <div class="category"><?= $product->category ?></div>
                    <div class="condition"><?= $product->condition ?></div>
                    <div class="size"><?= $product->size ?></div>
                    <div class="brand"><?= $product->brand ?></div>
                    <div class="model"><?= $product->model ?></div>
                    <p><?= $product->description ?></p>
                    <div class="price-field"><h4>Preço: </h4><div class="price"><h4><?= $product->price ?></h4></div><h4>€</h4></div>
                    <div class="button-container">
                        <?php if ($product->isPurchased): ?>
                          <span>Vendido</span>
                          <button class="rm-product" onclick="removeProduct('<?= htmlspecialchars($product->id, ENT_QUOTES, 'UTF-8') ?>')">
                            <i class="fas fa-trash icon"></i>
                          </button>
                        <?php else: ?>
                          <button class="edit-product" onclick="editProduct('<?= htmlspecialchars($product->id, ENT_QUOTES, 'UTF-8') ?>')">
                            <i class="fas fa-edit icon"></i>
                          </button>
                          <button class="rm-product" onclick="removeProduct('<?= htmlspecialchars($product->id, ENT_QUOTES, 'UTF-8') ?>')">
                            <i class="fas fa-trash icon"></i>
                          </button>
                        <?php endif; ?>
                    </div>
                  </div>
                <?php } 
                } 
              } 
                ?>
        </div>
      </div>
    </div> 

    <div id="edit-product-modal" class="modal">
      <div class="modal-content container-edit">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Editar Produto</h2>
        <form id="edit-product-form" action="../actions/action_editProduct.php" method="post">
          <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
          <input type="hidden" name="product_id" id="edit-product-id">

          <div class="box-inputs">
            <div class="input-field">
              <label for="edit-name">Nome:</label>
              <input type="text" name="name" id="edit-name">
            </div>

            <div class="input-field">
              <label for="edit-price">Preço:</label>
              <input type="number" name="price" id="edit-price" step="0.01" min="0" autocomplete="on">
            </div>

            <div class="input-field">
              <label for="edit-category">Categoria:</label>
              <select name="category" id="edit-category">
                <?php
                  $stmt = $db->prepare('SELECT * FROM Category');
                  $stmt->execute();
                  while ($category = $stmt->fetch(PDO::FETCH_OBJ)) {
                      echo "<option value=\"{$category->name}\">{$category->name}</option>";
                  }
                ?>
              </select>
            </div>

            <div class="input-field">
              <label for="edit-condition">Condição:</label>
              <select name="condition" id="edit-condition">
                <?php
                  $stmt = $db->prepare('SELECT * FROM Condition');
                  $stmt->execute();
                  while ($condition = $stmt->fetch(PDO::FETCH_OBJ)) {
                      echo "<option value=\"{$condition->name}\">{$condition->name}</option>";
                  }
                ?>
              </select>
            </div>

            <div class="input-field">
              <label for="edit-description">Descrição:</label>
              <textarea name="description" id="edit-description"></textarea>
            </div>

            <div class="input-field">
              <label for="edit-model">Modelo:</label>
              <input type="text" name="model" id="edit-model">
            </div>

            <div class="input-field">
              <label for="edit-brand">Marca:</label>
              <input type="text" name="brand" id="edit-brand">
            </div>

            <div class="input-field">
              <label for="edit-size">Tamanho:</label>
              <select name="size" id="edit-size">
                <?php
                  $stmt = $db->prepare('SELECT * FROM Size');
                  $stmt->execute();
                  while ($size = $stmt->fetch(PDO::FETCH_OBJ)) {
                      echo "<option value=\"{$size->name}\">{$size->name}</option>";
                  }
                ?>
              </select>
            </div>
          </div>

          <button type="submit" class="saveEdit">Salvar</button>
        </form>
      </div>
    </div>

  </body>
<?php } ?>

