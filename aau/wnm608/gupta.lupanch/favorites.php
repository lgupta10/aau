<?php
$page_title = 'My Favorites - LG Cool Store';
$page_description = 'View your saved favorite products.';

include 'parts/functions.php';
include 'parts/meta.php';
include 'parts/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>My Favorites</h1>
        <p>Your saved items</p>
    </div>
</section>

<section class="favorites-section">
    <div class="container">
        <div id="favorites-container">
            <div class="empty-favorites">
                <p>You haven't added any favorites yet.</p>
                <a href="products.php" class="btn btn-primary">Browse Products</a>
            </div>
        </div>
    </div>
</section>

<script>
// This will be populated by JavaScript from localStorage
document.addEventListener('DOMContentLoaded', function() {
    const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
    const container = document.getElementById('favorites-container');
    
    if (favorites.length > 0) {
        container.innerHTML = '<div class="product-grid" id="favoritesGrid"></div>';
        const grid = document.getElementById('favoritesGrid');
        
        // In a real app, you'd fetch product details for each favorite ID
        // For now, we'll just show a message
        grid.innerHTML = '<p>Favorite products will be displayed here.</p>';
    }
});
</script>

<?php include 'parts/footer.php'; ?>