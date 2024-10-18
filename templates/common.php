<?php 

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/product.class.php');
require_once(__DIR__ .'/../templates/common.php');
require_once(__DIR__ .'/../templates/homepage.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/products.php');

function makeHeader(Session $session) {
    $db = getDatabaseConnection();
    $user_id = $session->get('id');
    $user = User::getCurrentUser($db, $user_id);
    $cartItemCount = Product::getCartItemCount($db, $user_id);
    ?>
    <head>
        <link rel="icon" href="../images/logo.png">
        <title>Binted</title>
        <link rel="stylesheet" href="../css/header.css" />
        <link rel="stylesheet" href="../css/shoppingCart.css" />
        <script src="../javascript/product.js" defer></script>
        <script
            src="https://kit.fontawesome.com/24ad015d00.js"
            crossorigin="anonymous"
        ></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap');
        </style>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&family=Just+Another+Hand&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        </style>
    </head>
    <body class="showCart">
        <header>
            <section id="headerSection">
                <div class="left-header">
                  <a href="../pages/homepage.php" class="logo">Binted</a>
                    <?php if ($session->isLoggedIn()): ?>
                        <?php if ($user->admin): ?>
                            <h5>Admin</h5>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <form id="search-form" class="search-form" method="get" action="../pages/searchResults.php">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                    <input type="text" name="query" placeholder="Pesquisa um artigo...">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
                <input type="checkbox" id="check">
                <label for="check" class="checkbtn">
                  <i class="fa-solid fa-bars"></i>
                </label>
                <ul id="navbar">
                    <?php if (isset($_SESSION['id'])): ?>
                        <li><a href="#divOne" class="addicon">+</a></li>
                    <?php endif; ?>
                    <li><a href="../pages/wishlist.php"><i class="fa-regular fa-heart"></i></a></li>
                    <li>
                        <button class="cart-button" onclick="toggleShoppingCartSection()">
                            <i class="fa-solid fa-cart-shopping icon"></i>
                            <?php if ($cartItemCount > 0): ?>
                                <span class="cart-count"><?= $cartItemCount ?></span>
                            <?php endif; ?>
                        </button>
                    </li>
                    <?php if (isset($_SESSION['id'])): ?>
                        <li><a href="../pages/profile.php"><i class="fa-solid fa-user icon"></i></a></li>
                    <?php else: ?>
                        <li><a href="../pages/login.php"><i class="fa-solid fa-user icon"></i></a></li>
                    <?php endif; ?>
                    
                </ul>
            </section>
            <section class="ad_box">
                <h2>#1 site de produtos usados</h2>
            </section>
        </header>
        
    <div class="overlay" id="divOne">
      <div class="wrapper">
        <h2>Complete os espaços para adicionar o item</h2>
        <a href="#" class="close">&times;</a>
        <div class="content">
          <div class="container-add">
            <form action="../actions/action_addProduct.php" method="post" enctype="multipart/form-data" class="addproduct-form">
              <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
              <label>Produto</label>
              <input type="text" name="name" id="name" placeholder="Name" required>
              <label for="categoria">Categoria</label>
                <select name="category" id="category" required>
                 <?php $stmt = $db->prepare('SELECT *FROM Category c');
                  $stmt->execute(array());
                  $category_array = array();
                  while ($category = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $category_array[] = $category;
                  }
                  foreach ($category_array as $category) { ?>
                    <option><?=$category->name?></option>
                  <?php } ?> 
                </select>
              <label>Preço</label>
              <input type="number" name="price" id="price" placeholder="Price" step="0.01" min="0" required>
              <label>Condition</label>
              <select name="condition" id="condition" required>
                 <?php $stmt = $db->prepare('SELECT *FROM Condition c');
                  $stmt->execute(array());
                  $condition_array = array();
                  while ($condition = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $condition_array[] = $condition;
                  }
                  foreach ($condition_array as $condition) { ?>
                    <option><?=$condition->name?></option>
                  <?php } ?>
              </select>
              <div class="size-brand">  
                <div class="division-size-branch">  
                  <label>Size</label>
                  <select name="size" id="size">
                    <?php $stmt = $db->prepare('SELECT *FROM Size s');
                    $stmt->execute(array());
                    $size_array = array();
                    while ($size = $stmt->fetch(PDO::FETCH_OBJ)) {
                      $size_array[] = $size;
                    }
                    foreach ($size_array as $size) { ?>
                      <option><?=$size->name?></option>
                    <?php } ?>
                  </select>  
                </div> 
                <div class="division-size-branch"> 
                  <label>Brand</label>
                  <input type="text" name="brand" id="brand" placeholder="Brand">
                </div>
              </div>  
              <label>Description</label>
              <textarea placeholder="Descrição..." name="description" id="description"></textarea>
              <label>Upload Photos</label>
              <input type="file" name="photos[]" id="photos" multiple>
              <input type="submit" value="Submit">
            </form>
          </div>
        </div>
      </div>
      <a href=""></a>
    </div>
    <?php if (isset($_SESSION['id'])): ?>   
      <div class="carTab" id="carTab">
        <div class="shoppinCart">
          <h1>Shopping Cart</h1>
          <button class="close-cart-button" onclick="toggleShoppingCartSection()">
            <i class="fa-solid fa-times icon"></i>
          </button>
        </div>
        <div class="listCart">
          <?php
            $totalPrice = 0;
            $shoppingCart = Product::getShoppingCart($db, $user_id);
            foreach ($shoppingCart as $cartItem) {
              $totalPrice += $cartItem['price'];
          ?>  
          <div class="item" id="product-<?= htmlspecialchars($cartItem['id'], ENT_QUOTES, 'UTF-8') ?>">
            <div class="image">
              <img src="../images/item.jpeg" alt="<?= htmlspecialchars($cartItem['name']) ?>">
            </div>
            <div class="name">
              <?= htmlspecialchars($cartItem['name']) ?>
            </div>
            <div class="totalPrice">
              <?= htmlspecialchars($cartItem['price']) ?>€
            </div>
            <div class="button-container" ?>
              <button class="delete-product" onclick="removeShoppingCart('<?= htmlspecialchars($cartItem['id'], ENT_QUOTES, 'UTF-8') ?>', '<?= $totalPrice ?>', '<?= htmlspecialchars($cartItem['price'], ENT_QUOTES, 'UTF-8')?>')">
                <i class="fa-solid fa-trash icon"></i>
              </button>
            </div>
          </div>
          <?php } ?>
        </div>
        <div class="btn">
          <button class="totalPrice" id="total-price" >Preço Total: <?= $totalPrice ?>€</button>
          <button id="checkout-button" class="checkOut" onclick="checkout()">Check Out</button>
        </div>
      </div>
    <?php endif; ?>
  </body>
<?php } ?>


<?php function drawFooter() { ?>
    </main>

    <footer>
      Binted &copy; 2024
    </footer>
  </body>
</html>
<?php } ?>