function removeProduct(productId) {
  if (confirm("Are you sure you want to delete this product?")) { 
      const request = new XMLHttpRequest();
      request.open("POST", "../actions/action_rmProduct.php", true);
      request.setRequestHeader(
          "Content-Type",
          "application/x-www-form-urlencoded"
      );
      const data = "id=" + encodeURIComponent(productId);

      request.onload = function () {
          if (request.status >= 200 && request.status < 400) {
              console.log("Product deleted successfully:", request.responseText);
              const productElement = document.getElementById('product-' + productId);

              if (productElement) {
                  productElement.parentNode.removeChild(productElement);
              }
          } else {
              console.error("Error removing product:", request.statusText);
          }
      };

      request.onerror = function () {
          console.error("Error during AJAX request.");
      };

      request.send(data);
  }
}

function removeWishlist(productId) {
  const request = new XMLHttpRequest();
  request.open("POST", "../actions/action_rmWishlist.php", true);
  request.setRequestHeader(
      "Content-Type",
      "application/x-www-form-urlencoded"
  );
  const data = "id=" + encodeURIComponent(productId);

  request.onload = function () {
      if (request.status >= 200 && request.status < 400) {
          console.log("Product deleted successfully:", request.responseText);
          const productElement = document.getElementById('product-' + productId);

          if (productElement) {
              productElement.parentNode.removeChild(productElement);
          }
      
      } else {
          console.error("Error removing product:", request.statusText);
      }
  };

  request.onerror = function () {
      console.error("Error during AJAX request.");
  };

  request.send(data);
}

function removeShoppingCart(productId, priceTotal, price) {
  
  const request = new XMLHttpRequest();
  request.open("POST", "../actions/action_rmShoppingCart.php", true);
  request.setRequestHeader(
    "Content-Type",
    "application/x-www-form-urlencoded"
  );
  const data = "id=" + productId;

  request.onload = function () {

    if (request.status >= 200 && request.status < 400) {
      console.log("Product deleted successfully:", request.responseText);
      const productElement = document.getElementById('product-' + productId);
      const productElement2 = document.getElementById('total-price');

      if (productElement) {
        productElement.parentNode.removeChild(productElement);
      }

      if (productElement2) {
        productElement2.textContent = "Preço Total: " + (priceTotal - price) + "€";
      }
      
    } else {
      console.error("Error removing product:", request.statusText);
    }
  };

  request.onerror = function () {
    console.error("Error during AJAX request.");
  };

  request.send(data);

}
document.addEventListener('DOMContentLoaded', function() {
window.toggleShoppingCartSection = function() {
    var shoppingCartSection = document.getElementById('carTab'); 
    shoppingCartSection.style.display = (shoppingCartSection.style.display === 'none' || shoppingCartSection.style.display === '') ? 'block' : 'none';
};
});

function addShoppingCart(productId) {
  const request = new XMLHttpRequest();
  request.open("POST", "../actions/action_addShoppingCart.php", true);
  request.setRequestHeader(
      "Content-Type",
      "application/x-www-form-urlencoded"
  );
  const data = "product_id=" + encodeURIComponent(productId);

  request.onload = function () {
      if (request.status >= 200 && request.status < 400) {
          console.log("Product added to cart successfully:", request.responseText);
          
          const productElement = document.getElementById('product-' + productId);

          if (productElement) {
              productElement.parentNode.appendChild(productElement);
          }
          window.location.reload();
      } else {
          console.error("Error adding product to cart:", request.statusText);
      }
  };

  request.onerror = function () {
      console.error("Error during AJAX request.");
  };

  request.send(data); 
}

function checkout() {
  
  const productElements = document.querySelectorAll('.listCart .item');
  const productIds = Array.from(productElements).map(item => item.id); //here

  console.log('Product IDs for checkout:', productIds); 
  const form = document.createElement('form');
  form.method = 'post';
  form.action = '../pages/checkout.php';

  productIds.forEach(productId => {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'product_ids[]';
      input.value = productId.replace('product-',''); //here
      form.appendChild(input);
  });

  document.body.appendChild(form);
  form.submit();
}


function editProduct(productId) {
  const productElement = document.getElementById(`product-${productId}`);
  const name = productElement.querySelector('h2').textContent.trim();
  const price = productElement.querySelector('.price').textContent.trim();
  const description = productElement.querySelector('p').textContent.trim();
  const condition = productElement.querySelector('.condition') ? productElement.querySelector('.condition').textContent.trim() : '';
  const category = productElement.querySelector('.category') ? productElement.querySelector('.category').textContent.trim() : '';
  const model = productElement.querySelector('.model') ? productElement.querySelector('.model').textContent.trim() : '';
  const brand = productElement.querySelector('.brand') ? productElement.querySelector('.brand').textContent.trim() : '';
  const size = productElement.querySelector('.size') ? productElement.querySelector('.size').textContent.trim() : '';
  


  document.getElementById('edit-product-id').value = productId;
  document.getElementById('edit-name').value = name;
  document.getElementById('edit-price').value = price;
  document.getElementById('edit-description').value = description;
  document.getElementById('edit-condition').value = condition;
  document.getElementById('edit-model').value = model;
  document.getElementById('edit-brand').value = brand;
  document.getElementById('edit-size').value = size;
  document.getElementById('edit-category').value = category;

  document.getElementById('edit-product-modal').style.display = 'block';
}

function closeEditModal() {
  document.getElementById('edit-product-modal').style.display = 'none';
}

window.onclick = function(event) {
  const modal = document.getElementById('edit-product-modal');
  if (event.target == modal) {
      modal.style.display = 'none';
  }
}



