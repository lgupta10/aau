<?php
include 'parts/functions.php';
include 'parts/cart_functions.php';

// Get product ID from $_GET
$product_id = $_GET['id'] ?? null;

if (!$product_id) {
    header('Location: products.php');
    exit;
}

$product = getProductById($product_id);

if (!$product) {
    header('Location: products.php');
    exit;
}

$page_title = e($product['name']) . ' - LG Cool Store';
$page_description = e($product['description']);

include 'parts/meta.php';
include 'parts/header.php';

// Get related products (same category, different ID)
$related_products = array_filter(getProductsByCategory($product['category']), function($p) use ($product_id) {
    return $p['id'] != $product_id;
});
$related_products = array_slice($related_products, 0, 4);
?>

<section class="page-header">
    <div class="container">
        <nav class="breadcrumb">
            <a href="index.php">Home</a> / 
            <a href="products.php">Shop</a> / 
            <a href="products.php?category=<?= $product['category'] ?>"><?= ucfirst($product['category']) ?></a> / 
            <span><?= e($product['name']) ?></span>
        </nav>
    </div>
</section>

<section class="product-detail">
    <div class="container">
        <div class="product-layout">
            <!-- Product Images -->
            <div class="product-images">
                <div class="main-image">
                    <img src="<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>" id="mainImage">
                    <?php if ($product['on_sale']): ?>
                        <span class="sale-badge-large">-<?= getDiscountPercent($product['price'], $product['sale_price']) ?>% OFF</span>
                    <?php endif; ?>
                </div>
                <!-- Image Grid - Shows 4 images in a 2x2 grid -->
                <div class="thumbnail-grid">
                    <img src="<?= e($product['image']) ?>" alt="Thumbnail 1" class="thumbnail active" onclick="changeImage(this.src)">
                    <img src="<?= e($product['image']) ?>" alt="Thumbnail 2" class="thumbnail" onclick="changeImage(this.src)">
                    <img src="<?= e($product['image']) ?>" alt="Thumbnail 3" class="thumbnail" onclick="changeImage(this.src)">
                    <img src="<?= e($product['image']) ?>" alt="Thumbnail 4" class="thumbnail" onclick="changeImage(this.src)">
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="product-details">
                <h1><?= e($product['name']) ?></h1>
                
                <div class="product-rating">
                    <span class="stars">★★★★★</span>
                    <span class="rating-text">4.8/5.0 (124 reviews)</span>
                </div>
                
                <div class="price-container-large">
                    <?php if ($product['sale_price']): ?>
                        <span class="price-original-large"><?= formatPrice($product['price']) ?></span>
                        <span class="price-sale-large"><?= formatPrice($product['sale_price']) ?></span>
                        <span class="savings">You save <?= formatPrice($product['price'] - $product['sale_price']) ?>!</span>
                    <?php else: ?>
                        <span class="price-large"><?= formatPrice($product['price']) ?></span>
                    <?php endif; ?>
                </div>
                
                <p class="product-description"><?= e($product['description']) ?></p>
                
                <!-- Product Options Form -->
                <form id="addToCartForm">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    
                    <!-- Color Selection -->
                    <?php if (count($product['colors']) > 1): ?>
                        <div class="option-group">
                            <label>Color: <span id="selectedColor"><?= ucfirst($product['colors'][0]) ?></span></label>
                            <div class="color-options">
                                <?php foreach ($product['colors'] as $index => $color): ?>
                                    <button type="button" 
                                            class="color-swatch <?= $index === 0 ? 'active' : '' ?>" 
                                            data-color="<?= $color ?>"
                                            style="background-color: <?= $color === 'beige' ? '#F5F5DC' : ($color === 'grey' ? '#808080' : $color) ?>;"
                                            aria-label="<?= ucfirst($color) ?>"
                                            onclick="selectColor('<?= $color ?>')">
                                    </button>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" name="color" id="colorInput" value="<?= $product['colors'][0] ?>">
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="color" value="<?= $product['colors'][0] ?>">
                    <?php endif; ?>
                    
                    <!-- Size Selection -->
                    <?php if ($product['sizes'][0] !== 'One Size'): ?>
                        <div class="option-group">
                            <label for="sizeSelect">Size: *</label>
                            <div class="size-options">
                                <?php foreach ($product['sizes'] as $index => $size): ?>
                                    <button type="button" 
                                            class="size-btn <?= $index === 0 ? 'active' : '' ?>"
                                            data-size="<?= e($size) ?>"
                                            onclick="selectSize('<?= e($size) ?>')">
                                        <?= e($size) ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" name="size" id="sizeInput" value="<?= $product['sizes'][0] ?>">
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="size" value="One Size">
                    <?php endif; ?>
                    
                    <!-- Quantity -->
                    <div class="option-group">
                        <label for="quantity">Quantity:</label>
                        <div class="quantity-selector">
                            <button type="button" class="qty-btn" id="decreaseQty">-</button>
                            <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" id="quantity">
                            <button type="button" class="qty-btn" id="increaseQty">+</button>
                        </div>
                    </div>
                    
                    <p class="stock-status <?= $product['stock'] < 10 ? 'low-stock' : 'in-stock' ?>">
                        <?php if ($product['stock'] > 0): ?>
                            ✓ In Stock (<?= $product['stock'] ?> available)
                        <?php else: ?>
                            ✗ Out of Stock
                        <?php endif; ?>
                    </p>
                    
                    <!-- Action Buttons -->
                    <div class="product-actions">
                        <?php if ($product['stock'] > 0): ?>
                            <button type="submit" class="btn btn-primary btn-large">
                                Add to Cart
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-primary btn-large" disabled>
                                Out of Stock
                            </button>
                        <?php endif; ?>
                        <button type="button" class="btn btn-secondary btn-large favorite-btn" data-id="<?= $product['id'] ?>">
                            ♥ Add to Favorites
                        </button>
                    </div>
                </form>
                
                <!-- Product Features -->
                <div class="product-features">
                    <ul>
                        <li>✓ Free shipping on orders over $75</li>
                        <li>✓ 30-day easy returns</li>
                        <li>✓ Secure payment processing</li>
                        <li>✓ Quality guaranteed</li>
                    </ul>
                </div>
                
                <!-- Product Tabs -->
                <div class="product-tabs">
                    <div class="tab-buttons">
                        <button class="tab-btn active" data-tab="description">Description</button>
                        <button class="tab-btn" data-tab="specifications">Specifications</button>
                        <button class="tab-btn" data-tab="shipping">Shipping & Returns</button>
                        <button class="tab-btn" data-tab="reviews">Reviews (124)</button>
                    </div>
                    
                    <div class="tab-content active" id="description">
                        <h3>Product Details</h3>
                        <p><?= e($product['description']) ?></p>
                        <ul>
                            <li>Premium quality materials</li>
                            <li>Durable construction for long-lasting wear</li>
                            <li>Comfortable fit for all-day use</li>
                            <li>Easy care and maintenance</li>
                        </ul>
                    </div>
                    
                    <div class="tab-content" id="specifications">
                        <h3>Specifications</h3>
                        <table class="specs-table">
                            <tr>
                                <th>Category:</th>
                                <td><?= ucfirst($product['category']) ?></td>
                            </tr>
                            <tr>
                                <th>Available Colors:</th>
                                <td><?= implode(', ', array_map('ucfirst', $product['colors'])) ?></td>
                            </tr>
                            <tr>
                                <th>Available Sizes:</th>
                                <td><?= implode(', ', $product['sizes']) ?></td>
                            </tr>
                            <tr>
                                <th>Stock Status:</th>
                                <td><?= $product['stock'] > 0 ? 'In Stock' : 'Out of Stock' ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="tab-content" id="shipping">
                        <h3>Shipping Information</h3>
                        <p><strong>Free Shipping:</strong> On orders over $75</p>
                        <p><strong>Standard Delivery:</strong> 5-7 business days - FREE</p>
                        <p><strong>Express Delivery:</strong> 2-3 business days - $15.00</p>
                        <p><strong>Overnight:</strong> Next business day - $30.00</p>
                        
                        <h3>Returns & Exchanges</h3>
                        <p>We offer a 30-day return policy. Items must be unused and in original packaging with all tags attached.</p>
                        <p><strong>Free Returns:</strong> Print a prepaid return label from your account.</p>
                    </div>
                    
                    <div class="tab-content" id="reviews">
                        <h3>Customer Reviews</h3>
                        <div class="review-summary">
                            <div class="rating-large">
                                <span class="stars-large">★★★★★</span>
                                <p><strong>4.8</strong> out of 5</p>
                                <p>Based on 124 reviews</p>
                            </div>
                        </div>
                        
                        <div class="sample-review">
                            <div class="review-header">
                                <span class="stars">★★★★★</span>
                                <span class="review-date">2 weeks ago</span>
                            </div>
                            <p><strong>Great quality!</strong></p>
                            <p>Love this product. Exactly as described and fits perfectly. Highly recommend!</p>
                            <p class="reviewer">- Sarah M.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<?php if (!empty($related_products)): ?>
<section class="related-products">
    <div class="container">
        <h2>You May Also Like</h2>
        <div class="product-grid">
            <?php foreach ($related_products as $related): ?>
                <div class="product-card">
                    <a href="product_detail.php?id=<?= $related['id'] ?>" class="product-image">
                        <img src="<?= e($related['image']) ?>" alt="<?= e($related['name']) ?>">
                        <?php if ($related['on_sale']): ?>
                            <span class="sale-badge">Sale</span>
                        <?php endif; ?>
                    </a>
                    <div class="product-info">
                        <h3><a href="product_detail.php?id=<?= $related['id'] ?>"><?= e($related['name']) ?></a></h3>
                        <div class="price-container">
                            <?php if ($related['sale_price']): ?>
                                <span class="price-original"><?= formatPrice($related['price']) ?></span>
                                <span class="price-sale"><?= formatPrice($related['sale_price']) ?></span>
                            <?php else: ?>
                                <span class="price"><?= formatPrice($related['price']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
// Image gallery
function changeImage(src) {
    document.getElementById('mainImage').src = src;
    document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
    event.target.classList.add('active');
}

// Color selection
function selectColor(color) {
    document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
    event.target.classList.add('active');
    document.getElementById('colorInput').value = color;
    document.getElementById('selectedColor').textContent = color.charAt(0).toUpperCase() + color.slice(1);
}

// Size selection
function selectSize(size) {
    document.querySelectorAll('.size-btn').forEach(s => s.classList.remove('active'));
    event.target.classList.add('active');
    document.getElementById('sizeInput').value = size;
}

// Quantity controls
document.getElementById('decreaseQty').addEventListener('click', () => {
    const qty = document.getElementById('quantity');
    if (qty.value > 1) qty.value = parseInt(qty.value) - 1;
});

document.getElementById('increaseQty').addEventListener('click', () => {
    const qty = document.getElementById('quantity');
    const max = parseInt(qty.max);
    if (parseInt(qty.value) < max) qty.value = parseInt(qty.value) + 1;
});

// Tab switching
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const tabId = btn.dataset.tab;
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById(tabId).classList.add('active');
    });
});

// Add to cart form submission
document.getElementById('addToCartForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    formData.append('action', 'add');
    
    // Convert FormData to URLSearchParams
    const params = new URLSearchParams();
    for (let [key, value] of formData.entries()) {
        params.append(key, value);
    }
    
    fetch('cart_handler.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: params.toString()
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count in header
            const cartCount = document.getElementById('cart-count');
            if (cartCount) {
                cartCount.textContent = data.cart_count;
            }
            
            // Show success message
            alert('✓ ' + data.message);
            
            // Optional: Redirect to cart
            // window.location.href = 'cart.php';
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding item to cart. Please try again.');
    });
});

// Favorites functionality
document.querySelectorAll('.favorite-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const productId = this.dataset.id;
        let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        
        if (favorites.includes(productId)) {
            favorites = favorites.filter(id => id !== productId);
            alert('Removed from favorites');
        } else {
            favorites.push(productId);
            alert('Added to favorites!');
        }
        
        localStorage.setItem('favorites', JSON.stringify(favorites));
        
        // Update favorites count
        const favCount = document.getElementById('favorites-count');
        if (favCount) {
            favCount.textContent = favorites.length;
        }
    });
});
</script>

<?php include 'parts/footer.php'; ?>
