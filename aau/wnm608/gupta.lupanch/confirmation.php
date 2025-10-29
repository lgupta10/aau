<?php
$page_title = 'Order Confirmation - LG Cool Store';
$page_description = 'Thank you for your order!';

include 'parts/functions.php';
include 'parts/meta.php';
include 'parts/header.php';

// Generate random order number
$order_number = 'LG' . date('Ymd') . rand(1000, 9999);
?>

<section class="confirmation-section">
    <div class="container">
        <div class="confirmation-content">
            <div class="success-icon">✓</div>
            <h1>Order Confirmed!</h1>
            <p class="order-number">Order #<?= $order_number ?></p>
            <p class="confirmation-message">
                Thank you for your purchase! We've sent a confirmation email to your inbox.
            </p>
            
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
                        <p>Your order will arrive based on your selected shipping method.</p>
                    </div>
                </div>
            </div>
            
            <div class="confirmation-actions">
                <a href="products.php" class="btn btn-primary">Continue Shopping</a>
                <a href="index.php" class="btn btn-secondary">Back to Home</a>
            </div>
        </div>
    </div>
</section>

<?php include 'parts/footer.php'; ?>