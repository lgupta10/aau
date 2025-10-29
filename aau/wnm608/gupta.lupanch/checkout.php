<?php
$page_title = 'Checkout - LG Cool Store';
$page_description = 'Complete your purchase securely.';

include 'parts/functions.php';
include 'parts/meta.php';
include 'parts/header.php';
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
                <span class="step-label">Confirm</span>
            </div>
        </div>
        
        <div class="checkout-layout">
            <!-- Checkout Form -->
            <div class="checkout-form">
                <form id="checkoutForm" method="POST" action="confirmation.php">
                    
                    <!-- Step 1: Shipping Information -->
                    <div class="checkout-step active" id="step1">
                        <h2>1. Shipping Information</h2>
                        
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required>
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
                            <input type="text" id="address" name="address" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">City *</label>
                                <input type="text" id="city" name="city" required>
                            </div>
                            <div class="form-group">
                                <label for="state">State *</label>
                                <input type="text" id="state" name="state" required>
                            </div>
                            <div class="form-group">
                                <label for="zip">ZIP Code *</label>
                                <input type="text" id="zip" name="zip" required pattern="[0-9]{5}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        
                        <h3>Shipping Method</h3>
                        <div class="shipping-options">
                            <label class="radio-option">
                                <input type="radio" name="shipping" value="standard" checked>
                                <span>Standard Shipping (5-7 days) - FREE</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="shipping" value="express">
                                <span>Express Shipping (2-3 days) - $15.00</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="shipping" value="overnight">
                                <span>Overnight Shipping (1 day) - $30.00</span>
                            </label>
                        </div>
                        
                        <button type="button" class="btn btn-primary" onclick="nextStep(2)">
                            Continue to Payment
                        </button>
                    </div>
                    
                    <!-- Step 2: Payment Information -->
                    <div class="checkout-step" id="step2">
                        <h2>2. Payment Information</h2>
                        
                        <div class="form-group">
                            <label for="cardNumber">Card Number *</label>
                            <input type="text" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="expiry">Expiry Date *</label>
                                <input type="text" id="expiry" name="expiry" placeholder="MM/YY" maxlength="5">
                            </div>
                            <div class="form-group">
                                <label for="cvv">CVV *</label>
                                <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="4">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="cardName">Cardholder Name *</label>
                            <input type="text" id="cardName" name="cardName">
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
                            <p id="reviewAddress"></p>
                        </div>
                        
                        <div class="review-section">
                            <h3>Payment Method</h3>
                            <p id="reviewPayment"></p>
                        </div>
                        
                        <div class="form-group">
                            <label class="checkbox-option">
                                <input type="checkbox" name="terms" required>
                                <span>I agree to the <a href="#">Terms & Conditions</a></span>
                            </label>
                        </div>
                        
                        <div class="button-group">
                            <button type="button" class="btn btn-secondary" onclick="prevStep(2)">
                                Back to Payment
                            </button>
                            <button type="submit" class="btn btn-primary btn-large">
                                Place Order
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Order Summary Sidebar -->
            <div class="order-summary-sidebar">
                <h3>Order Summary</h3>
                <div id="checkoutCartItems"></div>
                <div class="summary-totals">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span id="checkoutSubtotal">$0.00</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span id="checkoutShipping">FREE</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax:</span>
                        <span id="checkoutTax">$0.00</span>
                    </div>
                    <div class="summary-divider"></div>
                    <div class="summary-row total-row">
                        <span>Total:</span>
                        <span id="checkoutTotal">$0.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function nextStep(step) {
    document.querySelectorAll('.checkout-step').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.progress-step').forEach(s => s.classList.remove('active'));
    
    document.getElementById('step' + step).classList.add('active');
    document.querySelector(`.progress-step[data-step="${step}"]`).classList.add('active');
    
    if (step === 3) {
        // Populate review section
        const address = `${document.getElementById('firstName').value} ${document.getElementById('lastName').value}<br>
                        ${document.getElementById('address').value}<br>
                        ${document.getElementById('city').value}, ${document.getElementById('state').value} ${document.getElementById('zip').value}`;
        document.getElementById('reviewAddress').innerHTML = address;
        
        const cardNum = document.getElementById('cardNumber').value;
        const lastFour = cardNum.slice(-4);
        document.getElementById('reviewPayment').innerHTML = `Card ending in ${lastFour}`;
    }
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function prevStep(step) {
    nextStep(step);
}
</script>

<?php include 'parts/footer.php'; ?>