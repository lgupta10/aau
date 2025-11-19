<?php
// cart_handler.php
// Handles AJAX requests for cart operations

include 'parts/functions.php';
include 'parts/cart_functions.php';

// Set JSON header
header('Content-Type: application/json');

// Get action from request
$action = $_POST['action'] ?? $_GET['action'] ?? '';

$response = ['success' => false, 'message' => ''];

switch ($action) {
    case 'add':
        $product_id = intval($_POST['product_id'] ?? 0);
        $size = $_POST['size'] ?? 'One Size';
        $color = $_POST['color'] ?? 'default';
        $quantity = intval($_POST['quantity'] ?? 1);
        
        if ($product_id > 0) {
            $success = addToCart($product_id, $size, $color, $quantity);
            if ($success) {
                $response = [
                    'success' => true,
                    'message' => 'Item added to cart!',
                    'cart_count' => getCartCount(),
                    'cart_items' => getCartItems()
                ];
            } else {
                $response['message'] = 'Product not found';
            }
        } else {
            $response['message'] = 'Invalid product ID';
        }
        break;
        
    case 'update':
        $cart_key = $_POST['cart_key'] ?? '';
        $quantity = intval($_POST['quantity'] ?? 0);
        
        if ($cart_key && $quantity >= 0) {
            $success = updateCartQuantity($cart_key, $quantity);
            $totals = getCartTotals();
            
            $response = [
                'success' => $success,
                'message' => $success ? 'Cart updated' : 'Failed to update cart',
                'cart_count' => getCartCount(),
                'cart_items' => getCartItems(),
                'totals' => $totals
            ];
        } else {
            $response['message'] = 'Invalid cart key or quantity';
        }
        break;
        
    case 'remove':
        $cart_key = $_POST['cart_key'] ?? '';
        
        if ($cart_key) {
            $success = removeFromCart($cart_key);
            $totals = getCartTotals();
            
            $response = [
                'success' => $success,
                'message' => $success ? 'Item removed from cart' : 'Failed to remove item',
                'cart_count' => getCartCount(),
                'cart_items' => getCartItems(),
                'totals' => $totals
            ];
        } else {
            $response['message'] = 'Invalid cart key';
        }
        break;
        
    case 'get':
        $totals = getCartTotals();
        $response = [
            'success' => true,
            'cart_count' => getCartCount(),
            'cart_items' => getCartItems(),
            'totals' => $totals
        ];
        break;
        
    case 'apply_promo':
        $promo_code = $_POST['promo_code'] ?? '';
        $subtotal = getCartSubtotal();
        
        $promo_result = applyPromoCode($promo_code, $subtotal);
        
        if ($promo_result['valid']) {
            $_SESSION['promo_code'] = $promo_code;
            $totals = getCartTotals('standard', $promo_code);
            
            $response = [
                'success' => true,
                'message' => $promo_result['message'],
                'totals' => $totals
            ];
        } else {
            $response = [
                'success' => false,
                'message' => $promo_result['message']
            ];
        }
        break;
        
    case 'update_shipping':
        $shipping_method = $_POST['shipping_method'] ?? 'standard';
        $_SESSION['shipping_method'] = $shipping_method;
        
        $promo_code = $_SESSION['promo_code'] ?? '';
        $totals = getCartTotals($shipping_method, $promo_code);
        
        $response = [
            'success' => true,
            'message' => 'Shipping method updated',
            'totals' => $totals
        ];
        break;
        
    case 'clear':
        clearCart();
        $response = [
            'success' => true,
            'message' => 'Cart cleared',
            'cart_count' => 0,
            'cart_items' => []
        ];
        break;
        
    default:
        $response['message'] = 'Invalid action';
}

echo json_encode($response);
?>
