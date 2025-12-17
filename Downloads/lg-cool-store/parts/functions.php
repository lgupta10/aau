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
            'image' => 'images/cap-black.jpg',
            'images' => [
                'images/cap-black.jpg',
                'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=800&q=80', // Front view
                'https://images.unsplash.com/photo-1575428652377-a2d80e2277fc?w=800&q=80', // Side view
                'https://images.unsplash.com/photo-1521369909029-2afed882baee?w=800&q=80'  // Detail view
            ],
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
            'image' => 'images/shoe-black.jpg',
            'images' => [
                'images/shoe-black.jpg',
                'https://images.unsplash.com/photo-1587563871167-1ee9c731aefb?w=800&q=80', // Black high-top side view
                'https://images.unsplash.com/photo-1605348532760-6753d2c43329?w=800&q=80', // High-top sneaker detail
                'https://images.unsplash.com/photo-1603808033192-082d6919d3e1?w=800&q=80'  // Black sneaker back view
            ],
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
            'images' => [
                'images/bag-beige.jpg',
                'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=800&q=80', // Front view
                'https://images.unsplash.com/photo-1598532163257-ae3c6b2524b6?w=800&q=80', // Inside view
                'https://images.unsplash.com/photo-1591561954557-26941169b49e?w=800&q=80'  // Detail
            ],
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
            'images' => [
                'images/beanie-grey.jpg',
                'https://images.unsplash.com/photo-1608235715278-e9d4e8f13f50?w=800&q=80', // Grey beanie detail
                'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?w=800&q=80', // Beanie on model
                'https://images.unsplash.com/photo-1620799139834-6b8f844fbe61?w=800&q=80'  // Beanie texture close-up
            ],
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
            'image' => 'images/shoe-white.jpg',
            'images' => [
                'images/shoe-white.jpg',
                'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=800&q=80', // Side view
                'https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?w=800&q=80', // Back view
                'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=800&q=80'  // Detail
            ],
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
            'images' => [
                'images/backpack-brown.jpg',
                'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&q=80', // Front view
                'https://images.unsplash.com/photo-1622560480605-d83c853bc5c3?w=800&q=80', // Side view
                'https://images.unsplash.com/photo-1577733966973-d680bffd2e80?w=800&q=80'  // Detail
            ],
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
