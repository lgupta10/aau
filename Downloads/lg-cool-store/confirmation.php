<?php
$page_title = 'Order Confirmation - LG Cool Store';
$page_description = 'Thank you for your order!';

include 'parts/functions.php';
include 'parts/cart_functions.php';
include 'parts/meta.php';
include 'parts/header.php';

// Get order from session
$order = getLastOrder();

if (!$order) {
    header('Location: index.php');
    exit;
}

$order_number = $order['order_number'];
$customer = $order['customer'];
$items = $order['items'];
$totals = $order['totals'];
?>

<section class="confirmation-section">
    <div class="container">
        <div class="confirmation-content">
            <div class="success-icon">✓</div>
            <h1>Order Confirmed!</h1>
            <p class="order-number">Order #<?= $order_number ?></p>
            <p class="confirmation-message">
                Thank you, <strong><?= e($customer['first_name']) ?></strong>! We've sent a confirmation email to <strong><?= e($customer['email']) ?></strong>.
            </p>
            
            <div class="order-summary-box">
                <h2>Order Summary</h2>
                
                <div class="order-items">
                    <?php foreach ($items as $item): ?>
                        <div class="order-item">
                            <img src="<?= e($item['image']) ?>" alt="<?= e($item['name']) ?>">
                            <div class="item-info">
                                <strong><?= e($item['name']) ?></strong>
                                <?php if ($item['size'] !== 'One Size' || $item['color'] !== 'default'): ?>
                                    <p class="item-options">
                                        <?= $item['size'] !== 'One Size' ? 'Size: ' . e($item['size']) : '' ?>
                                        <?= $item['size'] !== 'One Size' && $item['color'] !== 'default' ? ' | ' : '' ?>
                                        <?= $item['color'] !== 'default' ? 'Color: ' . ucfirst(e($item['color'])) : '' ?>
                                    </p>
                                <?php endif; ?>
                                <p>Qty: <?= $item['quantity'] ?></p>
                            </div>
                            <strong><?= formatPrice($item['price'] * $item['quantity']) ?></strong>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="order-totals">
                    <div class="total-row">
                        <span>Subtotal:</span>
                        <span><?= formatPrice($totals['subtotal']) ?></span>
                    </div>
                    <div class="total-row">
                        <span>Shipping:</span>
                        <span><?= $totals['shipping'] == 0 ? 'FREE' : formatPrice($totals['shipping']) ?></span>
                    </div>
                    <div class="total-row">
                        <span>Tax:</span>
                        <span><?= formatPrice($totals['tax']) ?></span>
                    </div>
                    <?php if ($totals['discount'] > 0): ?>
                        <div class="total-row discount-row">
                            <span>Discount:</span>
                            <span class="discount-amount">-<?= formatPrice($totals['discount']) ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="total-row grand-total">
                        <span><strong>Total:</strong></span>
                        <span><strong><?= formatPrice($totals['total']) ?></strong></span>
                    </div>
                </div>
            </div>
            
            <div class="shipping-info-box">
                <h2>Shipping Address</h2>
                <p>
                    <?= e($customer['first_name']) ?> <?= e($customer['last_name']) ?><br>
                    <?= e($customer['address']) ?><br>
                    <?= e($customer['city']) ?>, <?= e($customer['state']) ?> <?= e($customer['zip']) ?><br>
                    <?= e($customer['email']) ?><br>
                    <?= e($customer['phone']) ?>
                </p>
            </div>
            
            <div class="order-details">
                <h2>What's Next?</h2>
                <div class="next-steps">
                    <div class="step-item">
                        <span class="step-icon">📧</span>
                        <h3>Confirmation Email</h3>
                        <p>Check your email for order details and tracking information.</p>
                    </div>
                    <div class="step-item">
                        <span class="step-icon">📦</span>
                        <h3>Processing</h3>
                        <p>We'll prepare your order for shipment within 1-2 business days.</p>
                    </div>
                    <div class="step-item">
                        <span class="step-icon">🚚</span>
                        <h3>Delivery</h3>
                        <p>Your order will arrive based on your selected shipping method 
                           (<?= ucfirst($customer['shipping_method']) ?> Shipping).</p>
                    </div>
                </div>
            </div>
            
            <div class="confirmation-actions">
                <a href="products.php" class="btn btn-primary">Continue Shopping</a>
                <a href="index.php" class="btn btn-secondary">Back to Home</a>
            </div>
            
            <div class="help-section">
                <p>Need help? <a href="contact.php">Contact us</a> or call (555) 123-4567</p>
            </div>
        </div>
    </div>
</section>

<?php include 'parts/footer.php'; ?>
