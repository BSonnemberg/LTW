
<?php
require_once('../database/connection.db.php');
require_once('../database/product.class.php');
require_once('../utils/session.php');

function checkout($userId, $productIds, $session) { ?>
    <head>
        <link rel="icon" href="../images/logo.png">
        <title>Checkout</title>
        <link rel="stylesheet" href="../css/checkout.css">
    </head>
    <body>
        <div class="checkout-container">
            <h1>Checkout</h1>
            <form action="../actions/action_finalizePurchase.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($userId) ?>">
                <?php foreach ($productIds as $productId): ?>
                    <input type="hidden" name="product_ids[]" value="<?= htmlspecialchars($productId) ?>">
                <?php endforeach; ?>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="address">Morada:</label>
                <input type="text" id="address" name="address" required>
                <label for="payment-method">Método de Pagamento:</label>
                <select id="payment-method" name="payment_method" required>
                    <option value="mbway">MB Way</option>
                    <option value="multibanco">Multibanco</option>
                </select>
                <button type="submit">Finalizar Compra</button>
            </form>
        </div>
    </body>
    </html>
    <?php
}
?>
