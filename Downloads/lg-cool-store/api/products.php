<?php

include_once "../lib/php/functions.php";

// Set JSON header
header('Content-Type: application/json');

// Get request parameters
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_category = isset($_GET['category']) ? $_GET['category'] : '';
$filter_price_min = isset($_GET['price_min']) ? $_GET['price_min'] : '';
$filter_price_max = isset($_GET['price_max']) ? $_GET['price_max'] : '';
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'name';
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

// Build the SQL query
$query = "SELECT * FROM products WHERE 1=1";
$params = [];

// SEARCH functionality - searches in name, description, and category
if (!empty($search)) {
    $query .= " AND (
        name LIKE ? OR 
        description LIKE ? OR 
        category LIKE ?
    )";
    $search_term = "%{$search}%";
    $params[] = $search_term;
    $params[] = $search_term;
    $params[] = $search_term;
}

// FILTER by category
if (!empty($filter_category)) {
    $query .= " AND category = ?";
    $params[] = $filter_category;
}

// FILTER by price range
if (!empty($filter_price_min)) {
    $query .= " AND price >= ?";
    $params[] = $filter_price_min;
}

if (!empty($filter_price_max)) {
    $query .= " AND price <= ?";
    $params[] = $filter_price_max;
}

// SORT functionality
$allowed_sorts = ['name', 'price', 'date_create'];
$sort_column = in_array($sort_by, $allowed_sorts) ? $sort_by : 'name';
$sort_direction = strtoupper($sort_order) === 'DESC' ? 'DESC' : 'ASC';
$query .= " ORDER BY {$sort_column} {$sort_direction}";

try {
    // Execute query
    $conn = makePDOConn();
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return JSON response
    echo json_encode([
        'success' => true,
        'count' => count($results),
        'products' => $results,
        'query_params' => [
            'search' => $search,
            'category' => $filter_category,
            'price_min' => $filter_price_min,
            'price_max' => $filter_price_max,
            'sort_by' => $sort_column,
            'sort_order' => $sort_direction
        ]
    ]);
    
} catch (Exception $e) {
    // Return error as JSON
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
