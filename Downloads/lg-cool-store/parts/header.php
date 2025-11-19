<?php
$current_page = basename($_SERVER['PHP_SELF']);
$categories = getCategories();
?>
<header class="site-header">
    <div class="container">
        <nav class="main-nav">
            <!-- Logo -->
            <div class="logo">
                <a href="index.php">LG COOL STORE</a>
            </div>
            
            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" aria-label="Toggle Menu" id="mobileMenuToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <!-- Navigation Links -->
            <ul class="nav-links" id="navLinks">
                <li><a href="index.php" class="<?= isActive('index.php') ?>">Home</a></li>
                <li><a href="products.php" class="<?= isActive('products.php') ?>">Shop</a></li>
                <li><a href="sale.php" class="<?= isActive('sale.php') ?>">Sale</a></li>
                <li><a href="about.php" class="<?= isActive('about.php') ?>">About</a></li>
                <li><a href="contact.php" class="<?= isActive('contact.php') ?>">Contact</a></li>
            </ul>
            
            <!-- User Actions -->
            <div class="nav-actions">
                <!-- Search Icon -->
                <button class="icon-btn search-toggle" aria-label="Search" id="searchToggle">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </button>
                
                <!-- Favorites -->
                <a href="favorites.php" class="icon-btn favorites-link" aria-label="Favorites">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    <span class="badge" id="favorites-count">0</span>
                </a>
                
                <!-- Cart -->
                <a href="cart.php" class="icon-btn cart-link" aria-label="Shopping Cart">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span class="badge" id="cart-count">0</span>
                </a>
            </div>
        </nav>
        
        <!-- Search Bar (Hidden by default) -->
        <div class="search-bar" id="searchBar" style="display: none;">
            <div class="search-container">
                <form action="products.php" method="GET">
                    <input type="text" name="search" placeholder="Search products..." id="searchInput" value="<?= e($_GET['search'] ?? '') ?>">
                    <button type="submit" class="search-btn">Search</button>
                </form>
            </div>
        </div>
    </div>
</header>
