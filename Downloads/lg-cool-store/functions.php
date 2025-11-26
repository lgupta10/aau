<?php
// parts/functions.php
// Updated with placeholder images that work immediately!

function getProducts() {
    return [
        [
            'id' => 1,
            'name' => 'Classic Snapback Cap',
            'category' => 'caps',
            'price' => 24.99,
            'sale_price' => null,
            'image' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=800&h=800&fit=crop', // Black cap
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
            'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&h=800&fit=crop', // White sneakers
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
            'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=800&h=800&fit=crop', // Tote bag
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
            'image' => 'https://images.unsplash.com/photo-1576871337632-b9aef4c17ab9?w=800&h=800&fit=crop', // Grey beanie
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
            'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=800&h=800&fit=crop', // Black sneakers
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
            'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&h=800&fit=crop', // Brown backpack
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
function getUniqueCategories() {
    $conn = makePDOConn();
    $stmt = $conn->prepare("
        SELECT DISTINCT category 
        FROM products 
        WHERE category IS NOT NULL AND category != ''
        ORDER BY category ASC
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPriceRange() {
    $conn = makePDOConn();
    $stmt = $conn->prepare("
        SELECT 
            MIN(price) as min_price, 
            MAX(price) as max_price 
        FROM products
    ");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
