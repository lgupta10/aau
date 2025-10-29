<?php
// parts/functions.php

function getProducts() {
    return [
        [
            'id' => 1,
            'name' => 'Classic Snapback Cap',
            'category' => 'caps',
            'price' => 24.99,
            'sale_price' => null,
            'image' => 'images/cap-black.jpg',
            'description' => 'Premium cotton snapback with embroidered logo. Adjustable back strap ensures perfect fit for all head sizes.',
            'stock' => 28,
            'featured' => true,
            'on_sale' => false,
            'colors' => ['black', 'white', 'navy'],
            'sizes' => ['One Size']
        ],
        [
            'id' => 2,
            'name' => 'High-Top Sneakers',
            'category' => 'shoes',
            'price' => 84.99,
            'sale_price' => 69.99,
            'image' => 'images/shoe-white.jpg',
            'description' => 'Comfortable urban runners with cushioned sole and breathable mesh.',
            'stock' => 15,
            'featured' => true,
            'on_sale' => true,
            'colors' => ['white', 'black'],
            'sizes' => ['8', '9', '10', '11', '12']
        ],
        [
            'id' => 3,
            'name' => 'Canvas Tote Bag',
            'category' => 'accessories',
            'price' => 19.99,
            'sale_price' => null,
            'image' => 'images/bag-beige.jpg',
            'description' => 'Durable canvas tote perfect for everyday use.',
            'stock' => 42,
            'featured' => false,
            'on_sale' => false,
            'colors' => ['beige', 'black'],
            'sizes' => ['One Size']
        ],
        [
            'id' => 4,
            'name' => 'Wool Beanie',
            'category' => 'caps',
            'price' => 22.99,
            'sale_price' => 17.99,
            'image' => 'images/beanie-grey.jpg',
            'description' => 'Cozy wool beanie for cold weather.',
            'stock' => 35,
            'featured' => true,
            'on_sale' => true,
            'colors' => ['grey', 'black', 'navy'],
            'sizes' => ['One Size']
        ],
        [
            'id' => 5,
            'name' => 'Low-Top Sneakers',
            'category' => 'shoes',
            'price' => 69.99,
            'sale_price' => null,
            'image' => 'images/shoe-black.jpg',
            'description' => 'Classic design meets modern comfort.',
            'stock' => 22,
            'featured' => false,
            'on_sale' => false,
            'colors' => ['black', 'white', 'grey'],
            'sizes' => ['8', '9', '10', '11', '12']
        ],
        [
            'id' => 6,
            'name' => 'Leather Backpack',
            'category' => 'accessories',
            'price' => 89.99,
            'sale_price' => 74.99,
            'image' => 'images/backpack-brown.jpg',
            'description' => 'Premium leather backpack with laptop compartment.',
            'stock' => 12,
            'featured' => true,
            'on_sale' => true,
            'colors' => ['brown', 'black'],
            'sizes' => ['One Size']
        ]
    ];
}

function getProductById($id) {
    $products = getProducts();
    foreach ($products as $product) {
        if ($product['id'] == $id) {
            return $product;
        }
    }
    return null;
}

function getProductsByCategory($category) {
    if ($category === 'all' || empty($category)) {
        return getProducts();
    }
    $products = getProducts();
    return array_filter($products, function($product) use ($category) {
        return $product['category'] === $category;
    });
}

function getFeaturedProducts($limit = 4) {
    $products = getProducts();
    $featured = array_filter($products, function($product) {
        return $product['featured'] === true;
    });
    return array_slice($featured, 0, $limit);
}

function getSaleProducts() {
    $products = getProducts();
    return array_filter($products, function($product) {
        return $product['on_sale'] === true;
    });
}

function formatPrice($price) {
    return '$' . number_format($price, 2);
}

function getDiscountPercent($original, $sale) {
    if (!$sale) return 0;
    return round((($original - $sale) / $original) * 100);
}

function getFinalPrice($product) {
    return $product['sale_price'] ?? $product['price'];
}

function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function isActive($page) {
    $current = basename($_SERVER['PHP_SELF']);
    return $current === $page ? 'active' : '';
}

function getCategories() {
    return [
        'all' => 'All Products',
        'caps' => 'Caps',
        'shoes' => 'Shoes',
        'accessories' => 'Accessories'
    ];
}

function sortProducts($products, $sort_by = 'featured') {
    switch ($sort_by) {
        case 'price-low':
            usort($products, function($a, $b) {
                return getFinalPrice($a) <=> getFinalPrice($b);
            });
            break;
        case 'price-high':
            usort($products, function($a, $b) {
                return getFinalPrice($b) <=> getFinalPrice($a);
            });
            break;
        case 'name':
            usort($products, function($a, $b) {
                return strcmp($a['name'], $b['name']);
            });
            break;
    }
    return $products;
}
?>