<?php
// parts/cart_functions.php
// Session-based shopping cart functions

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/**
 * Add item to cart
 * @param int $product_id
 * @param string $size
 * @param string $color
 * @param int $quantity
 * @return bool
 */
function addToCart($product_id, $size = 'One Size', $color = 'default', $quantity = 1) {
    // Create unique cart item key based on product_id, size, and color
    $cart_key = $product_id . '_' . $size . '_' . $color;
    
    // Get product details
    $product = getProductById($product_id);
    if (!$product) {
        return false;
    }
    
    // Check if item already exists in cart
    if (isset($_SESSION['cart'][$cart_key])) {
        $_SESSION['cart'][$cart_key]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$cart_key] = [
            'product_id' => $product_id,
            'name' => $product['name'],
            'price' => getFinalPrice($product),
            'original_price' => $product['price'],
            'sale_price' => $product['sale_price'],
            'image' => $product['image'],
            'size' => $size,
            'color' => $color,
            'quantity' => $quantity,
            'category' => $product['category']
        ];
    }
    
    return true;
}

/**
 * Update cart item quantity
 * @param string $cart_key
 * @param int $quantity
 * @return bool
 */
function updateCartQuantity($cart_key, $quantity) {
    if (isset($_SESSION['cart'][$cart_key])) {
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$cart_key]);
        } else {
            $_SESSION['cart'][$cart_key]['quantity'] = $quantity;
        }
        return true;
    }
    return false;
}

/**
 * Remove item from cart
 * @param string $cart_key
 * @return bool
 */
function removeFromCart($cart_key) {
    if (isset($_SESSION['cart'][$cart_key])) {
        unset($_SESSION['cart'][$cart_key]);
        return true;
    }
    return false;
}

/**
 * Clear entire cart
 */
function clearCart() {
    $_SESSION['cart'] = [];
}

/**
 * Get cart items
 * @return array
 */
function getCartItems() {
    return $_SESSION['cart'] ?? [];
}

/**
 * Get cart item count
 * @return int
 */
function getCartCount() {
    $count = 0;
    foreach ($_SESSION['cart'] as $item) {
        $count += $item['quantity'];
    }
    return $count;
}

/**
 * Calculate cart subtotal
 * @return float
 */
function getCartSubtotal() {
    $subtotal = 0;
    foreach ($_SESSION['cart'] as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    return $subtotal;
}

/**
 * Calculate tax (8%)
 * @param float $subtotal
 * @return float
 */
function calculateTax($subtotal) {
    return $subtotal * 0.08;
}

/**
 * Calculate shipping
 * @param float $subtotal
 * @param string $method
 * @return float
 */
function calculateShipping($subtotal, $method = 'standard') {
    // Free shipping over $75
    if ($subtotal >= 75) {
        return 0;
    }
    
    switch ($method) {
        case 'express':
            return 15.00;
        case 'overnight':
            return 30.00;
        default: // standard
            return 0;
    }
}

/**
 * Apply promo code discount
 * @param string $code
 * @param float $subtotal
 * @return array ['valid' => bool, 'discount' => float, 'message' => string]
 */
function applyPromoCode($code, $subtotal) {
    $promo_codes = [
        'SAVE10' => ['type' => 'percent', 'value' => 10, 'min' => 0],
        'SAVE20' => ['type' => 'percent', 'value' => 20, 'min' => 50],
        'FREESHIP' => ['type' => 'shipping', 'value' => 0, 'min' => 0],
        'WELCOME15' => ['type' => 'percent', 'value' => 15, 'min' => 30]
    ];
    
    $code = strtoupper(trim($code));
    
    if (!isset($promo_codes[$code])) {
        return ['valid' => false, 'discount' => 0, 'message' => 'Invalid promo code'];
    }
    
    $promo = $promo_codes[$code];
    
    if ($subtotal < $promo['min']) {
        return [
            'valid' => false, 
            'discount' => 0, 
            'message' => "Minimum order of $" . number_format($promo['min'], 2) . " required"
        ];
    }
    
    $discount = 0;
    if ($promo['type'] === 'percent') {
        $discount = $subtotal * ($promo['value'] / 100);
    }
    
    return [
        'valid' => true, 
        'discount' => $discount, 
        'message' => 'Promo code applied!',
        'code' => $code
    ];
}

/**
 * Calculate cart totals
 * @param string $shipping_method
 * @param string $promo_code
 * @return array
 */
function getCartTotals($shipping_method = 'standard', $promo_code = '') {
    $subtotal = getCartSubtotal();
    $tax = calculateTax($subtotal);
    $shipping = calculateShipping($subtotal, $shipping_method);
    
    $discount = 0;
    $promo_result = ['valid' => false, 'discount' => 0];
    
    if (!empty($promo_code)) {
        $promo_result = applyPromoCode($promo_code, $subtotal);
        if ($promo_result['valid']) {
            $discount = $promo_result['discount'];
        }
    }
    
    $total = $subtotal + $tax + $shipping - $discount;
    
    return [
        'subtotal' => $subtotal,
        'tax' => $tax,
        'shipping' => $shipping,
        'discount' => $discount,
        'total' => max(0, $total),
        'promo_applied' => $promo_result['valid'],
        'promo_message' => $promo_result['message'] ?? ''
    ];
}

/**
 * Save order to session (for demo purposes)
 * In a real app, this would save to a database
 */
function saveOrder($order_data) {
    $_SESSION['last_order'] = [
        'order_number' => 'LG' . date('Ymd') . rand(1000, 9999),
        'date' => date('Y-m-d H:i:s'),
        'items' => $_SESSION['cart'],
        'customer' => $order_data,
        'totals' => getCartTotals($order_data['shipping_method'] ?? 'standard', $order_data['promo_code'] ?? '')
    ];
    
    // Clear cart after order
    clearCart();
    
    return $_SESSION['last_order']['order_number'];
}

/**
 * Get last order
 */
function getLastOrder() {
    return $_SESSION['last_order'] ?? null;
}
?>
