<?php

class Product {

    public $condition;
    public $userId;
    public $category;
    public $name;
    public $price;
    public $model;
    public $brand;
    public $size;
    public $id;
    public $description;
    public $isPurchased;


    public function __construct($condition, $userId, $category, $name, $price, $model, $brand, $size, $id = null, $description = null, $isPurchased = false){
      $this->condition = $condition;
      $this->userId = $userId;
      $this->category = $category;
      $this->name = $name;
      $this->price = $price;
      $this->model = $model;
      $this->brand = $brand;
      $this->size = $size;
      $this->id = $id ?? uniqid($userId . $name, true);
      $this->description = $description;
      $this->isPurchased = $isPurchased;
    }

  public static function getProductsFromUser(PDO $db, $userId) {
    try {
        if($userId !== null) {
            $stmt = $db->prepare('SELECT * FROM Product WHERE userId = ?');
            $stmt->execute([strtolower($userId)]);
        } else {
            $stmt = $db->prepare('SELECT * FROM Product');
            $stmt->execute();
        }

        $products_array = array();
        while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $products_array[] = new Product(
            $product['condition'],
            $product['userId'],
            $product['category'],
            $product['name'],
            $product['price'],
            $product['model'],
            $product['brand'],
            $product['size'],
            $product['id'],
            $product['description'],
            $product['isPurchased']
          );        }

          return $products_array;
        } catch (PDOException $e) {
        return [];
    }
  }

    static function getProducts(PDO $db) : array {
        $stmt = $db->prepare('SELECT *
          FROM Product p
          ');
        $stmt->execute(array());
    
        $products_array = array();
      
        while ($product = $stmt->fetch()) {
          $products_array[] = new Product(
            $product['condition'],
            $product['userId'],
            $product['category'],
            $product['name'],
            $product['price'],
            $product['model'],
            $product['brand'],
            $product['size'],
            $product['id'],
            $product['description'],
            $product['isPurchased']
          );
        }
    
        return $products_array;
      }

    public function saveProduct(PDO $db) : bool{
        $stmt = $db->prepare('INSERT INTO PRODUCT (condition, userId, category, name,  price, model, brand, size, id, description, isPurchased ) VALUES (?,?,?,?,?,?,?,?,?,?,?)');
        $stmt->execute([
            $this->condition,
            $this->userId,
            $this->category,
            $this->name,
            $this->price,
            $this->model,
            $this->brand,
            $this->size,
            $this->id,
            $this->description,
            $this->isPurchased
        ]);
        return true;
    }

    public static function deleteProduct(PDO $db, string $id): bool {
      try {
          
          $photoUrls = self::getPhotoUrls($db, $id);

          
          $db->beginTransaction();

          
          $deletePhotos = $db->prepare('DELETE FROM Photo WHERE product_id = ?');
          $deletePhotos->execute([$id]);

        
          $deleteProduct = $db->prepare('DELETE FROM Product WHERE id = ?');
          if ($deleteProduct->execute([$id])) {
             
              $db->commit();

              foreach ($photoUrls as $photoUrl) {
                  if (file_exists($photoUrl)) {
                      unlink($photoUrl);
                  }
              }

              return true;
          } else {
             
              $db->rollBack();
              return false;
          }
      } catch (PDOException $e) {
          
          if ($db->inTransaction()) {
              $db->rollBack();
          }
          return false;
      }
  }
    public function addToWishlist(PDO $db, $userId) : bool {
      $wishlistId = uniqid('wishlist_', true);
      $stmt = $db->prepare('INSERT INTO Wishlist (id, userId, product_id) VALUES (?, ?, ?)');
      $stmt->execute([
          $wishlistId,
          $userId,
          $this->id
      ]);
      return true;
  }

  public static function getWishlistItems(PDO $db, $userId) {
      $stmt = $db->prepare('
          SELECT Product.condition, Product.id, Product.category, Product.name, Product.description, Product.price, Product.model, Product.brand, Product.size 
          FROM Wishlist 
          JOIN Product ON Wishlist.product_id = Product.id 
          WHERE Wishlist.userId = ?
      ');
      $stmt->execute([$userId]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


  public static function getShoppingCart(PDO $db, $user_Id) {
    $stmt = $db->prepare('
        SELECT Product.condition, Product.id, Product.category, Product.name, Product.description, Product.price, Product.model, Product.brand, Product.size 
        FROM ShoppingCart
        JOIN Product ON ShoppingCart.product_id = Product.id 
        WHERE ShoppingCart.user_Id = ?
    ');
    $stmt->execute([$user_Id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

static function getProductById(PDO $db, $id): ?Product {
  $stmt = $db->prepare('SELECT Condition, userId, category, name, price, model, brand, size, id, description, isPurchased FROM Product WHERE id  = ?');
  $stmt->execute([$id]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  if($product){
    return new Product(
      $product['condition'],
      $product['userId'],
      $product['category'],
      $product['name'],
      $product['price'],
      $product['model'],
      $product['brand'],
      $product['size'],
      $product['id'],
      $product['description'],
      $product['isPurchased']
      
    );
  }else{
    return null;
  }
  
}

public static function getCartItemCount(PDO $db, $userId): int {
  $stmt = $db->prepare('SELECT COUNT(DISTINCT product_id) as itemCount FROM ShoppingCart WHERE user_id = ?');
  $stmt->execute([$userId]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return (int) $result['itemCount'];
}
public static function addProposal(PDO $db, $productId, $userId, $amount): bool {
  $stmt = $db->prepare('INSERT INTO Proposals (productId, userId, amount, dateTime) VALUES (?, ?, ?, ?)');
  return $stmt->execute([
      $productId,
      $userId,
      $amount,
      (new DateTime())->format('Y-m-d H:i:s')
  ]);
}

public static function getProposalsByProduct(PDO $db, $productId): array {
  $stmt = $db->prepare('SELECT * FROM Proposals WHERE productId = ?');
  $stmt->execute([$productId]);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public static function acceptProposal(PDO $db, $proposalId): bool {
  $db->beginTransaction();
  try {
  
      $stmt = $db->prepare('SELECT * FROM Proposals WHERE id = ?');
      $stmt->execute([$proposalId]);
      $proposal = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if (!$proposal) {
          throw new Exception('Proposal not found');
      }

      $updateStmt = $db->prepare('UPDATE Product SET price = ? WHERE id = ?');
      $updateSuccess = $updateStmt->execute([$proposal['amount'], $proposal['productId']]);
      
      if (!$updateSuccess) {
          throw new Exception('Failed to update product price');
      }

     
      $deleteStmt = $db->prepare('DELETE FROM Proposals WHERE id = ?');
      $deleteSuccess = $deleteStmt->execute([$proposalId]);

      if (!$deleteSuccess) {
          throw new Exception('Failed to delete proposal');
      }

      $db->commit();
      return true;
  } catch (Exception $e) {
      $db->rollBack();
      return false;
  }
}


public function update(PDO $db) {
  $stmt = $db->prepare('UPDATE Product SET name = ?, price = ?, category = ?, condition = ?, description = ?, model = ?, brand = ?, size = ? WHERE id = ?');
  $stmt->execute([
      $this->name,
      $this->price,
      $this->category,
      $this->condition,
      $this->description,
      $this->model,
      $this->brand,
      $this->size,
      $this->id
  ]);
}

public static function getPhotoUrls(PDO $db, string $productId): array {
  $stmt = $db->prepare('SELECT url_photo FROM Photo WHERE product_id = ?');
  $stmt->execute([$productId]);
  return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public static function getFilteredProducts(PDO $db, $category = '', $condition = '', $priceMin = '', $priceMax = '', $order = 'asc') {
  $query = 'SELECT * FROM Product WHERE 1=1';
  $params = [];

  if (!empty($category)) {
      $query .= ' AND category = ?';
      $params[] = $category;
  }

  if (!empty($condition)) {
      $query .= ' AND `condition` = ?';
      $params[] = $condition;
  }

  if (!empty($priceMin)) {
      $query .= ' AND price >= ?';
      $params[] = $priceMin;
  }

  if (!empty($priceMax)) {
      $query .= ' AND price <= ?';
      $params[] = $priceMax;
  }

  $order = strtolower($order) === 'desc' ? 'DESC' : 'ASC';
  $query .= " ORDER BY price $order";

  $stmt = $db->prepare($query);
  $stmt->execute($params);

  $products = [];
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $products[] = new Product(
          $row['condition'],
          $row['userId'],
          $row['category'],
          $row['name'],
          $row['price'],
          $row['model'],
          $row['brand'],
          $row['size'],
          $row['id'],
          $row['description'],
          $row['isPurchased']
      );
  }

  return $products;
}

public static function searchProducts(PDO $db, string $query): array {
  $stmt = $db->prepare('SELECT * FROM Product WHERE name LIKE ? OR description LIKE ?');
  $stmt->execute(["%$query%", "%$query%"]);
  return $stmt->fetchAll(PDO::FETCH_OBJ);
}

public static function getProductsByCategory(PDO $db, string $category): array {
  $stmt = $db->prepare('SELECT * FROM Product WHERE category = ?');
  $stmt->execute([$category]);

  $products = [];
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $products[] = new Product(
          $row['condition'],
          $row['userId'],
          $row['category'],
          $row['name'],
          $row['price'],
          $row['model'],
          $row['brand'],
          $row['size'],
          $row['id'],
          $row['description'],
          $row['isPurchased']
      );
  }

  return $products;
}
}
?>
