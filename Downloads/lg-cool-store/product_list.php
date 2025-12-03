<?php

include_once "lib/php/functions.php";
$title = "Shop - Search & Filter";

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="lib/css/styleguide.css">
    <link rel="stylesheet" href="lib/css/grids.css">
    <link rel="stylesheet" href="css/storetheme.css">
    <link rel="stylesheet" href="css/product-list.css">
</head>
<body>
    
    <?php include "parts/navbar.php"; ?>
    
    <div class="container">
        <div class="view-window">
            
            <!-- Page Header -->
            <header class="page-header">
                <h1>Shop Our Products</h1>
                <p>Search, filter, and sort to find exactly what you need</p>
            </header>
            
            <!-- Controls Section -->
            <div class="product-controls">
                
                <!-- Search Bar -->
                <div class="control-section search-section">
                    <form id="search-form" class="search-form">
                        <input 
                            type="text" 
                            id="search-input" 
                            name="search" 
                            placeholder="Search products..."
                            class="search-input"
                        >
                        <button type="submit" class="search-btn">Search</button>
                    </form>
                </div>
                
                <!-- Filter Section -->
                <div class="control-section filter-section">
                    <h3>Filter Products</h3>
                    
                    <div class="filter-group">
                        <label for="filter-category">Category:</label>
                        <select id="filter-category" class="filter-select">
                            <option value="">All Categories</option>
                            <?php
                            // Get unique categories from database
                            $categories = getUniqueCategories();
                            foreach($categories as $cat) {
                                echo "<option value=\"{$cat['category']}\">{$cat['category']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label>Price Range:</label>
                        <form id="price-filter-form" class="price-filter-form">
                            <div class="price-inputs">
                                <input 
                                    type="number" 
                                    id="price-min" 
                                    name="price_min" 
                                    placeholder="Min"
                                    min="0"
                                    step="0.01"
                                    class="price-input"
                                >
                                <span class="price-separator">-</span>
                                <input 
                                    type="number" 
                                    id="price-max" 
                                    name="price_max" 
                                    placeholder="Max"
                                    min="0"
                                    step="0.01"
                                    class="price-input"
                                >
                                <button type="submit" class="price-filter-btn">Apply</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Sort Section -->
                <div class="control-section sort-section">
                    <label for="sort-select">Sort By:</label>
                    <select id="sort-select" class="sort-select">
                        <option value="name-ASC">Name (A-Z)</option>
                        <option value="name-DESC">Name (Z-A)</option>
                        <option value="price-ASC">Price (Low to High)</option>
                        <option value="price-DESC">Price (High to Low)</option>
                        <option value="date_create-DESC">Newest First</option>
                        <option value="date_create-ASC">Oldest First</option>
                    </select>
                </div>
                
                <!-- Reset Button -->
                <div class="control-section reset-section">
                    <button id="reset-filters" class="reset-btn">Reset All</button>
                </div>
                
            </div>
            
            <!-- Products Display Area -->
            <div id="product-container" class="product-display">
                <div class="loading">Loading products...</div>
            </div>
            
        </div>
    </div>
    
    <?php include "parts/footer.php"; ?>
    
    <!-- Include the JavaScript -->
    <script src="js/product-api.js"></script>
    
</body>
</html>
