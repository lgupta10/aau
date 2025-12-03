<?php
/**
 * Core Functions Library
 * Database connection and utility functions
 */

/**
 * Create PDO database connection
 * 
 * IMPORTANT: Update these credentials for your Hostinger database
 * 
 * @return PDO Database connection object
 */
function makePDOConn() {
    // Database configuration
    // TODO: Update these with your actual Hostinger database credentials
    $host = 'localhost';           // Usually 'localhost' on Hostinger
    $dbname = 'your_database_name'; // Your database name
    $username = 'your_username';    // Your database username
    $password = 'your_password';    // Your database password
    
    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $pdo = new PDO($dsn, $username, $password, $options);
        return $pdo;
        
    } catch (PDOException $e) {
        // In production, log this error instead of displaying it
        die("Database connection failed: " . $e->getMessage());
    }
}

/**
 * Get unique categories from database
 * 
 * @return array Array of unique categories
 */
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

/**
 * Get price range from database
 * 
 * @return array Min and max prices
 */
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

/**
 * Get product by ID from database
 * 
 * @param int $id Product ID
 * @return array|null Product data or null if not found
 */
function getProductById($id) {
    $conn = makePDOConn();
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Get products by category
 * 
 * @param string $category Category name
 * @return array Array of products
 */
function getProductsByCategory($category) {
    $conn = makePDOConn();
    
    if ($category === 'all' || empty($category)) {
        $stmt = $conn->prepare("SELECT * FROM products ORDER BY name");
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("SELECT * FROM products WHERE category = ? ORDER BY name");
        $stmt->execute([$category]);
    }
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all products from database
 * 
 * @return array Array of all products
 */
function getAllProducts() {
    $conn = makePDOConn();
    $stmt = $conn->prepare("SELECT * FROM products ORDER BY id DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Format price with currency symbol
 * 
 * @param float $price Price value
 * @return string Formatted price string
 */
function formatPrice($price) {
    return '$' . number_format($price, 2);
}

/**
 * Calculate discount percentage
 * 
 * @param float $original Original price
 * @param float $sale Sale price
 * @return int Discount percentage
 */
function getDiscountPercent($original, $sale) {
    if (!$sale || $sale >= $original) return 0;
    return round((($original - $sale) / $original) * 100);
}

/**
 * Get final price (sale price or regular price)
 * 
 * @param array $product Product data array
 * @return float Final price
 */
function getFinalPrice($product) {
    return !empty($product['sale_price']) ? $product['sale_price'] : $product['price'];
}

/**
 * Escape HTML entities for safe output
 * 
 * @param string $string Input string
 * @return string Escaped string
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Check if current page is active
 * 
 * @param string $page Page filename
 * @return string 'active' class name or empty string
 */
function isActive($page) {
    $current = basename($_SERVER['PHP_SELF']);
    return $current === $page ? 'active' : '';
}

/**
 * Get featured products from database
 * 
 * @param int $limit Number of products to return
 * @return array Array of featured products
 */
function getFeaturedProducts($limit = 4) {
    $conn = makePDOConn();
    $stmt = $conn->prepare("SELECT * FROM products WHERE featured = 1 LIMIT ?");
    $stmt->execute([$limit]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get products on sale from database
 * 
 * @return array Array of sale products
 */
function getSaleProducts() {
    $conn = makePDOConn();
    $stmt = $conn->prepare("SELECT * FROM products WHERE sale_price IS NOT NULL AND sale_price > 0");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Sanitize user input
 * 
 * @param string $data Input data
 * @return string Sanitized data
 */
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Check if a string is a valid email
 * 
 * @param string $email Email address
 * @return bool True if valid, false otherwise
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Generate a random token
 * 
 * @param int $length Token length
 * @return string Random token
 */
function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

