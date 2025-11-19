<?php
$page_title = 'Shopping Cart - LG Cool Store';
$page_description = 'Review your cart and proceed to checkout.';

include 'parts/functions.php';
include 'parts/cart_functions.php';
include 'parts/meta.php';
include 'parts/header.php';

$cart_items = getCartItems();
$cart_count = getCartCount();
$promo_code = $_SESSION['promo_code'] ?? '';
$shipping_method = $_SESSION['shipping_method'] ?? 'standard';
$totals = getCartTotals($shipping_method, $promo_code);
?>

<section class="page-header">
    <div class="container">
        <h1>Shopping Cart</h1>
        <nav class="breadcrumb">
            <a href="index.php">Home</a> / <span>Cart</span>
        </nav>
    </div>
</section>

<section class="cart-section">
    <div class="container">
        <?php if (empty($cart_items)): ?>
            <div class="empty-cart">
                <h2>Your cart is empty</h2>
                <p>Start adding some items to your cart!</p>
                <a href="products.php" class="btn btn-primary">Start Shopping</a>
            </div>
        <?php else: ?>
            <div class="cart-layout">
                <!-- Cart Items -->
                <div class="cart-items">
                    <div class="cart-header">
                        <h2>Your Cart (<?= $cart_count ?> item<?= $cart_count !== 1 ? 's' : '' ?>)</h2>
                    </div>
                    
                    <?php foreach ($cart_items as $cart_key => $item): ?>
                        <div class="cart-item" data-cart-key="<?= e($cart_key) ?>">
                            <div class="item-image">
                                <img src="<?= e($item['image']) ?>" alt="<?= e($item['name']) ?>">
                            </div>
                            
                            <div class="item-details">
                                <h3><?= e($item['name']) ?></h3>
                                <p class="item-options">
                                    <?php if ($item['size'] !== 'One Size'): ?>
                                        Size: <strong><?= e($item['size']) ?></strong>
                                    <?php endif; ?>
                                    <?php if ($item['color'] !== 'default'): ?>
                                        <?= $item['size'] !== 'One Size' ? ' | ' : '' ?>
                                        Color: <strong><?= ucfirst(e($item['color'])) ?></strong>
                                    <?php endif; ?>
                                </p>
                                <p class="item-category"><?= ucfirst(e($item['category'])) ?></p>
                            </div>
                            
                            <div class="item-price">
                                <?php if ($item['sale_price']): ?>
                                    <span class="price-original"><?= formatPrice($item['original_price']) ?></span>
                                    <span class="price-sale"><?= formatPrice($item['price']) ?></span>
                                <?php else: ?>
                                    <span class="price"><?= formatPrice($item['price']) ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="item-quantity">
                                <label>Quantity:</label>
                                <div class="quantity-selector">
                                    <button class="qty-btn qty-decrease" data-cart-key="<?= e($cart_key) ?>">-</button>
                                    <input type="number" 
                                           value="<?= $item['quantity'] ?>" 
                                           min="1" 
                                           max="99" 
                                           class="qty-input"
                                           data-cart-key="<?= e($cart_key) ?>">
                                    <button class="qty-btn qty-increase" data-cart-key="<?= e($cart_key) ?>">+</button>
                                </div>
                            </div>
                            
                            <div class="item-total">
                                <strong><?= formatPrice($item['price'] * $item['quantity']) ?></strong>
                            </div>
                            
                            <button class="item-remove" data-cart-key="<?= e($cart_key) ?>" title="Remove item">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Cart Summary -->
                <div class="cart-summary">
                    <h3>Order Summary</h3>
                    
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span id="cart-subtotal"><?= formatPrice($totals['subtotal']) ?></span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span id="cart-shipping" class="<?= $totals['shipping'] == 0 ? 'free-shipping' : '' ?>">
                            <?= $totals['shipping'] == 0 ? 'FREE' : formatPrice($totals['shipping']) ?>
                        </span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Tax (8%):</span>
                        <span id="cart-tax"><?= formatPrice($totals['tax']) ?></span>
                    </div>
                    
                    <div class="promo-code-section">
                        <input type="text" 
                               placeholder="Promo code" 
                               id="promoCode" 
                               value="<?= e($promo_code) ?>">
                        <button class="btn btn-secondary" id="applyPromo">Apply</button>
                    </div>
                    
                    <?php if ($totals['discount'] > 0): ?>
                        <div class="summary-row discount-row">
                            <span>Discount (<?= e($promo_code) ?>):</span>
                            <span id="cart-discount" class="discount-amount">-<?= formatPrice($totals['discount']) ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="summary-divider"></div>
                    
                    <div class="summary-row total-row">
                        <span>Total:</span>
                        <span id="cart-total"><?= formatPrice($totals['total']) ?></span>
                    </div>
                    
                    <a href="checkout.php" class="btn btn-primary btn-large">
                        Proceed to Checkout
                    </a>
                    
                    <a href="products.php" class="btn btn-secondary btn-large">
                        Continue Shopping
                    </a>
                    
                    <div class="shipping-notice">
                        <?php if ($totals['subtotal'] < 75): ?>
                            <p>🚚 Add <?= formatPrice(75 - $totals['subtotal']) ?> more for <strong>free shipping</strong>!</p>
                        <?php else: ?>
                            <p>🚚 You qualify for <strong>free shipping</strong>!</p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="promo-hints">
                        <p><small>Try promo codes: SAVE10, SAVE20, WELCOME15</small></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
// Cart update functionality
document.addEventListener('DOMContentLoaded', function() {
    // Quantity buttons
    document.querySelectorAll('.qty-decrease').forEach(btn => {
        btn.addEventListener('click', function() {
            const cartKey = this.dataset.cartKey;
            const input = document.querySelector(`.qty-input[data-cart-key="${cartKey}"]`);
            const newQty = Math.max(1, parseInt(input.value) - 1);
            updateCartQuantity(cartKey, newQty);
        });
    });
    
    document.querySelectorAll('.qty-increase').forEach(btn => {
        btn.addEventListener('click', function() {
            const cartKey = this.dataset.cartKey;
            const input = document.querySelector(`.qty-input[data-cart-key="${cartKey}"]`);
            const newQty = Math.min(99, parseInt(input.value) + 1);
            updateCartQuantity(cartKey, newQty);
        });
    });
    
    // Direct quantity input
    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', function() {
            const cartKey = this.dataset.cartKey;
            const newQty = Math.max(1, Math.min(99, parseInt(this.value) || 1));
            this.value = newQty;
            updateCartQuantity(cartKey, newQty);
        });
    });
    
    // Remove buttons
    document.querySelectorAll('.item-remove').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Remove this item from your cart?')) {
                const cartKey = this.dataset.cartKey;
                removeFromCart(cartKey);
            }
        });
    });
    
    // Promo code
    document.getElementById('applyPromo')?.addEventListener('click', applyPromoCode);
    document.getElementById('promoCode')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            applyPromoCode();
        }
    });
});

function updateCartQuantity(cartKey, quantity) {
    fetch('cart_handler.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=update&cart_key=${encodeURIComponent(cartKey)}&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload to show updated cart
        } else {
            alert('Error updating cart: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating cart. Please try again.');
    });
}

function removeFromCart(cartKey) {
    fetch('cart_handler.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=remove&cart_key=${encodeURIComponent(cartKey)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload to show updated cart
        } else {
            alert('Error removing item: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error removing item. Please try again.');
    });
}

function applyPromoCode() {
    const promoCode = document.getElementById('promoCode').value.trim();
    
    if (!promoCode) {
        alert('Please enter a promo code');
        return;
    }
    
    fetch('cart_handler.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=apply_promo&promo_code=${encodeURIComponent(promoCode)}`
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            location.reload(); // Reload to show discount
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error applying promo code. Please try again.');
    });
}
</script>

<?php include 'parts/footer.php'; ?>
