<?php
$page_title = 'Shopping Cart - LG Cool Store';
$page_description = 'Review your cart and proceed to checkout.';

include 'parts/functions.php';
include 'parts/meta.php';
include 'parts/header.php';
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
        <div class="cart-layout">
            <!-- Cart Items -->
            <div class="cart-items">
                <div class="cart-header">
                    <h2>Your Cart (<span id="cart-item-count">0</span> items)</h2>
                </div>
                <div id="cart-items-container">
                    <div class="empty-cart">
                        <p>Your cart is empty.</p>
                        <a href="products.php" class="btn btn-primary">Start Shopping</a>
                    </div>
                </div>
            </div>
            
            <!-- Cart Summary -->
            <div class="cart-summary">
                <h3>Order Summary</h3>
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span id="cart-subtotal">$0.00</span>
                </div>
                <div class="summary-row">
                    <span>Shipping:</span>
                    <span id="cart-shipping" class="free-shipping">FREE</span>
                </div>
                <div class="summary-row">
                    <span>Tax (8%):</span>
                    <span id="cart-tax">$0.00</span>
                </div>
                <div class="promo-code-section">
                    <input type="text" placeholder="Promo code" id="promoCode">
                    <button class="btn btn-secondary" id="applyPromo">Apply</button>
                </div>
                <div class="summary-row discount-row" id="discountRow" style="display: none;">
                    <span>Discount:</span>
                    <span id="cart-discount">-$0.00</span>
                </div>
                <div class="summary-divider"></div>
                <div class="summary-row total-row">
                    <span>Total:</span>
                    <span id="cart-total">$0.00</span>
                </div>
                <a href="checkout.php" class="btn btn-primary btn-large" id="checkoutBtn">
                    Proceed to Checkout
                </a>
                <a href="products.php" class="btn btn-secondary btn-large">
                    Continue Shopping
                </a>
                <div class="shipping-notice">
                    <p>🚚 <strong>Free shipping</strong> on orders over $75!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'parts/footer.php'; ?>