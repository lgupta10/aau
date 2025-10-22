<?php
function getProducts() {
    return [
        [
            'id' => 1,
            'name' => 'Classic Snapback Cap',
            'category' => 'caps',
            'price' => 24.99,
            'image' => 'images/cap-black.jpg',
            'description' => 'Premium cotton snapback with embroidered logo. Adjustable back strap ensures perfect fit.',
            'stock' => 28,
            'featured' => true
        ],
        [
            'id' => 2,
            'name' => 'High-Top Sneakers',
            'category' => 'shoes',
            'price' => 84.99,
            'image' => 'images/shoe-white.jpg',
            'description' => 'Comfortable urban runners with cushioned sole and breathable mesh.',
            'stock' => 15,
            'featured' => true
        ],
        [
            'id' => 3,
            'name' => 'Canvas Tote Bag',
            'category' => 'accessories',
            'price' => 19.99,
            'image' => 'images/bag-beige.jpg',
            'description' => 'Durable canvas tote perfect for everyday use. Large capacity.',
            'stock' => 42,
            'featured' => false
        ],
        [
            'id' => 4,
            'name' => 'Wool Beanie',
            'category' => 'caps',
            'price' => 22.99,
            'image' => 'images/beanie-grey.jpg',
            'description' => 'Cozy wool beanie for cold weather. One size fits all.',
            'stock' => 35,
            'featured' => true
        ],
        [
            'id' => 5,
            'name' => 'Low-Top Sneakers',
            'category' => 'shoes',
            'price' => 69.99,
            'image' => 'images/shoe-black.jpg',
            'description' => 'Classic design meets modern comfort. Perfect for daily wear.',
            'stock' => 22,
            'featured' => false
        ],
        [
            'id' => 6,
            'name' => 'Leather Backpack',
            'category' => 'accessories',
            'price' => 89.99,
            'image' => 'images/backpack-brown.jpg',
            'description' => 'Premium leather backpack with laptop compartment. Water-resistant.',
            'stock' => 12,
            'featured' => true
        ]
    ];
}

// Get single product by ID
function getProductById($id) {
    $products = getProducts();
    foreach ($products as $product) {
        if ($product['id'] == $id) {
            return $product;
        }
    }
    return null;
}

// Get featured products only
function getFeaturedProducts() {
    return array_filter(getProducts(), function($product) {
        return $product['featured'] === true;
    });
}

// Get products by category
function getProductsByCategory($category) {
    return array_filter(getProducts(), function($product) use ($category) {
        return $product['category'] === $category;
    });
}

// Format price with dollar sign
function formatPrice($price) {
    return '$' . number_format($price, 2);
}

// Safely output HTML
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Check if current page is active
function isActive($page) {
    return basename($_SERVER['PHP_SELF']) === $page ? 'active' : '';
}
?>