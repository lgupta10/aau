<?php
$page_title = 'Checkout - LG Cool Store';
$page_description = 'Complete your purchase securely.';

include 'parts/functions.php';
include 'parts/cart_functions.php';
include 'parts/meta.php';
include 'parts/header.php';

$cart_items = getCartItems();
$cart_count = getCartCount();

// Redirect if cart is empty
if (empty($cart_items)) {
    header('Location: cart.php');
    exit;
}

$promo_code = $_SESSION['promo_code'] ?? '';
$shipping_method = $_SESSION['shipping_method'] ?? 'standard';
$totals = getCartTotals($shipping_method, $promo_code);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $order_data = [
        'email' => $_POST['email'] ?? '',
        'first_name' => $_POST['firstName'] ?? '',
        'last_name' => $_POST['lastName'] ?? '',
        'address' => $_POST['address'] ?? '',
        'city' => $_POST['city'] ?? '',
        'state' => $_POST['state'] ?? '',
        'zip' => $_POST['zip'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'shipping_method' => $_POST['shipping'] ?? 'standard',
        'promo_code' => $promo_code
    ];
    
    $order_number = saveOrder($order_data);
    header('Location: confirmation.php?order=' . $order_number);
    exit;
}
?>

<section class="page-header">
    <div class="container">
        <h1>Checkout</h1>
        <nav class="breadcrumb">
            <a href="index.php">Home</a> / <a href="cart.php">Cart</a> / <span>Checkout</span>
        </nav>
    </div>
</section>

<section class="checkout-section">
    <div class="container">
        <!-- Progress Indicator -->
        <div class="checkout-progress">
            <div class="progress-step active" data-step="1">
                <span class="step-number">1</span>
                <span class="step-label">Shipping</span>
            </div>
            <div class="progress-step" data-step="2">
                <span class="step-number">2</span>
                <span class="step-label">Payment</span>
            </div>
            <div class="progress-step" data-step="3">
                <span class="step-number">3</span>
                <span class="step-label">Review</span>
            </div>
        </div>
        
        <div class="checkout-layout">
            <!-- Checkout Form -->
            <div class="checkout-form">
                <form id="checkoutForm" method="POST" action="checkout.php">
                    <input type="hidden" name="place_order" value="1">
                    
                    <!-- Step 1: Shipping Information -->
                    <div class="checkout-step active" id="step1">
                        <h2>1. Shipping Information</h2>
                        
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required>
                            <small>We'll send your order confirmation here</small>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name *</label>
                                <input type="text" id="firstName" name="firstName" required>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name *</label>
                                <input type="text" id="lastName" name="lastName" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Street Address *</label>
                            <input type="text" id="address" name="address" required placeholder="123 Main St">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">City *</label>
                                <input type="text" id="city" name="city" required>
                            </div>
                            <div class="form-group">
                                <label for="state">State *</label>
                                <select id="state" name="state" required>
                                    <option value="">Select State</option>
                                    <option value="CA">California</option>
                                    <option value="NY">New York</option>
                                    <option value="TX">Texas</option>
                                    <option value="FL">Florida</option>
                                    <option value="IL">Illinois</option>
                                    <option value="PA">Pennsylvania</option>
                                    <option value="OH">Ohio</option>
                                    <!-- Add more states as needed -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="zip">ZIP Code *</label>
                                <input type="text" id="zip" name="zip" required pattern="[0-9]{5}" placeholder="12345">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required placeholder="(555) 123-4567">
                        </div>
                        
                        <h3>Shipping Method</h3>
                        <div class="shipping-options">
                            <label class="radio-option">
                                <input type="radio" name="shipping" value="standard" checked onchange="updateShipping(this.value)">
                                <div class="option-content">
                                    <strong>Standard Shipping (5-7 days)</strong>
                                    <span class="option-price"><?= $totals['subtotal'] >= 75 ? 'FREE' : 'FREE' ?></span>
                                </div>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="shipping" value="express" onchange="updateShipping(this.value)">
                                <div class="option-content">
                                    <strong>Express Shipping (2-3 days)</strong>
                                    <span class="option-price">$15.00</span>
                                </div>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="shipping" value="overnight" onchange="updateShipping(this.value)">
                                <div class="option-content">
                                    <strong>Overnight Shipping (1 day)</strong>
                                    <span class="option-price">$30.00</span>
                                </div>
                            </label>
                        </div>
                        
                        <button type="button" class="btn btn-primary btn-large" onclick="nextStep(2)">
                            Continue to Payment
                        </button>
                    </div>
                    
                    <!-- Step 2: Payment Information -->
                    <div class="checkout-step" id="step2">
                        <h2>2. Payment Information</h2>
                        
                        <div class="payment-methods">
                            <p><strong>We accept:</strong> Visa, Mastercard, American Express, Discover</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="cardNumber">Card Number *</label>
                            <input type="text" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="expiry">Expiry Date *</label>
                                <input type="text" id="expiry" name="expiry" placeholder="MM/YY" maxlength="5" required>
                            </div>
                            <div class="form-group">
                                <label for="cvv">CVV *</label>
                                <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="4" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="cardName">Cardholder Name *</label>
                            <input type="text" id="cardName" name="cardName" placeholder="John Doe" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="checkbox-option">
                                <input type="checkbox" name="billing_same" checked>
                                <span>Billing address same as shipping</span>
                            </label>
                        </div>
                        
                        <div class="secure-notice">
                            <p>🔒 Your payment information is encrypted and secure</p>
                        </div>
                        
                        <div class="button-group">
                            <button type="button" class="btn btn-secondary" onclick="prevStep(1)">
                                Back to Shipping
                            </button>
                            <button type="button" class="btn btn-primary" onclick="nextStep(3)">
                                Continue to Review
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 3: Review Order -->
                    <div class="checkout-step" id="step3">
                        <h2>3. Review Your Order</h2>
                        
                        <div class="review-section">
                            <h3>Shipping Address</h3>
                            <div id="reviewAddress"></div>
                        </div>
                        
                        <div class="review-section">
                            <h3>Payment Method</h3>
                            <div id="reviewPayment"></div>
                        </div>
                        
                        <div class="review-section">
                            <h3>Order Items (<?= $cart_count ?>)</h3>
                            <div class="review-items">
                                <?php foreach ($cart_items as $item): ?>
                                    <div class="review-item">
                                        <img src="<?= e($item['image']) ?>" alt="<?= e($item['name']) ?>">
                                        <div>
                                            <strong><?= e($item['name']) ?></strong>
                                            <?php if ($item['size'] !== 'One Size' || $item['color'] !== 'default'): ?>
                                                <p>
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
                        </div>
                        
                        <div class="form-group">
                            <label class="checkbox-option">
                                <input type="checkbox" name="terms" id="terms" required>
                                <span>I agree to the <a href="#" target="_blank">Terms & Conditions</a> and <a href="#" target="_blank">Privacy Policy</a> *</span>
                            </label>
                        </div>
                        
                        <div class="button-group">
                            <button type="button" class="btn btn-secondary" onclick="prevStep(2)">
                                Back to Payment
                            </button>
                            <button type="submit" class="btn btn-primary btn-large" id="placeOrderBtn">
                                Place Order - <?= formatPrice($totals['total']) ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Order Summary Sidebar -->
            <div class="order-summary-sidebar">
                <h3>Order Summary</h3>
                
                <div class="sidebar-items">
                    <?php foreach ($cart_items as $item): ?>
                        <div class="sidebar-item">
                            <img src="<?= e($item['image']) ?>" alt="<?= e($item['name']) ?>">
                            <div class="sidebar-item-info">
                                <strong><?= e($item['name']) ?></strong>
                                <p>Qty: <?= $item['quantity'] ?></p>
                            </div>
                            <span><?= formatPrice($item['price'] * $item['quantity']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="summary-totals">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span id="checkoutSubtotal"><?= formatPrice($totals['subtotal']) ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span id="checkoutShipping"><?= $totals['shipping'] == 0 ? 'FREE' : formatPrice($totals['shipping']) ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Tax (8%):</span>
                        <span id="checkoutTax"><?= formatPrice($totals['tax']) ?></span>
                    </div>
                    <?php if ($totals['discount'] > 0): ?>
                        <div class="summary-row discount-row">
                            <span>Discount:</span>
                            <span class="discount-amount">-<?= formatPrice($totals['discount']) ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="summary-divider"></div>
                    <div class="summary-row total-row">
                        <span>Total:</span>
                        <span id="checkoutTotal"><?= formatPrice($totals['total']) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function nextStep(step) {
    // Validate current step
    if (step === 2) {
        if (!validateStep1()) return;
    } else if (step === 3) {
        if (!validateStep2()) return;
    }
    
    // Hide all steps and progress markers
    document.querySelectorAll('.checkout-step').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.progress-step').forEach(s => s.classList.remove('active'));
    
    // Show current step
    document.getElementById('step' + step).classList.add('active');
    document.querySelector(`.progress-step[data-step="${step}"]`).classList.add('active');
    
    // Populate review if on step 3
    if (step === 3) {
        populateReview();
    }
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function prevStep(step) {
    nextStep(step);
}

function validateStep1() {
    const required = ['email', 'firstName', 'lastName', 'address', 'city', 'state', 'zip', 'phone'];
    for (let field of required) {
        const input = document.getElementById(field);
        if (!input.value.trim()) {
            alert('Please fill in all required fields');
            input.focus();
            return false;
        }
    }
    return true;
}

function validateStep2() {
    const required = ['cardNumber', 'expiry', 'cvv', 'cardName'];
    for (let field of required) {
        const input = document.getElementById(field);
        if (!input.value.trim()) {
            alert('Please fill in all payment information');
            input.focus();
            return false;
        }
    }
    return true;
}

function populateReview() {
    // Shipping address
    const address = `
        ${document.getElementById('firstName').value} ${document.getElementById('lastName').value}<br>
        ${document.getElementById('address').value}<br>
        ${document.getElementById('city').value}, ${document.getElementById('state').value} ${document.getElementById('zip').value}<br>
        ${document.getElementById('email').value}<br>
        ${document.getElementById('phone').value}
    `;
    document.getElementById('reviewAddress').innerHTML = address;
    
    // Payment method
    const cardNum = document.getElementById('cardNumber').value;
    const lastFour = cardNum.slice(-4);
    document.getElementById('reviewPayment').innerHTML = `
        <p>Card ending in ${lastFour}</p>
        <p>${document.getElementById('cardName').value}</p>
    `;
}

function updateShipping(method) {
    fetch('cart_handler.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=update_shipping&shipping_method=${method}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update displayed totals
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}

// Auto-format card number
document.getElementById('cardNumber')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\s/g, '');
    let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
    e.target.value = formattedValue;
});

// Auto-format expiry
document.getElementById('expiry')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.slice(0, 2) + '/' + value.slice(2, 4);
    }
    e.target.value = value;
});

// Form submission
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    if (!document.getElementById('terms').checked) {
        e.preventDefault();
        alert('Please agree to the Terms & Conditions');
        return false;
    }
    
    document.getElementById('placeOrderBtn').disabled = true;
    document.getElementById('placeOrderBtn').textContent = 'Processing...';
});
</script>

<?php include 'parts/footer.php'; ?>
