<?php
// Product Administration Page
// This page is for administrators only - not for regular shoppers
// Provides full CRUD operations for product management

include_once "lib/php/functions.php";

// Simple authentication check (in production, use proper authentication)
session_start();
$admin_password = "admin123"; // Change this in production!

// Handle login
if (isset($_POST['login'])) {
    if ($_POST['password'] === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $login_error = "Invalid password";
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    unset($_SESSION['admin_logged_in']);
    header('Location: admin.php');
    exit;
}

// Check if logged in
if (!isset($_SESSION['admin_logged_in'])) {
    // Show login form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        <link rel="stylesheet" href="css/styles.css">
        <style>
            .login-container {
                max-width: 400px;
                margin: 100px auto;
                padding: 2rem;
                background: white;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            .login-form input {
                width: 100%;
                padding: 0.75rem;
                margin: 0.5rem 0;
                border: 1px solid #e2e8f0;
                border-radius: 4px;
            }
            .login-form button {
                width: 100%;
                padding: 0.75rem;
                background: var(--primary-color);
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-weight: 600;
            }
            .login-form button:hover {
                background: #1d4ed8;
            }
            .error-message {
                color: var(--error-color);
                margin: 0.5rem 0;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <h2>Admin Login</h2>
            <?php if (isset($login_error)): ?>
                <p class="error-message"><?= $login_error ?></p>
            <?php endif; ?>
            <form method="POST" class="login-form">
                <input type="password" name="password" placeholder="Enter admin password" required>
                <button type="submit" name="login">Login</button>
            </form>
            <p style="margin-top: 1rem; font-size: 0.875rem; color: #64748b;">
                Default password: admin123
            </p>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Handle form submissions
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = makePDOConn();
        
        // Add new product
        if (isset($_POST['action']) && $_POST['action'] === 'add') {
            $stmt = $conn->prepare("
                INSERT INTO products (name, category, price, sale_price, description, stock, thumbnail, image_main)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $_POST['name'],
                $_POST['category'],
                $_POST['price'],
                $_POST['sale_price'] ?: null,
                $_POST['description'],
                $_POST['stock'],
                $_POST['thumbnail'],
                $_POST['image_main']
            ]);
            
            $message = "Product added successfully!";
            $message_type = "success";
        }
        
        // Update product
        if (isset($_POST['action']) && $_POST['action'] === 'update') {
            $stmt = $conn->prepare("
                UPDATE products 
                SET name = ?, category = ?, price = ?, sale_price = ?, 
                    description = ?, stock = ?, thumbnail = ?, image_main = ?
                WHERE id = ?
            ");
            
            $stmt->execute([
                $_POST['name'],
                $_POST['category'],
                $_POST['price'],
                $_POST['sale_price'] ?: null,
                $_POST['description'],
                $_POST['stock'],
                $_POST['thumbnail'],
                $_POST['image_main'],
                $_POST['id']
            ]);
            
            $message = "Product updated successfully!";
            $message_type = "success";
        }
        
        // Delete product
        if (isset($_POST['action']) && $_POST['action'] === 'delete') {
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            
            $message = "Product deleted successfully!";
            $message_type = "success";
        }
        
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
        $message_type = "error";
    }
}

// Get all products
try {
    $conn = makePDOConn();
    $stmt = $conn->prepare("SELECT * FROM products ORDER BY id DESC");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $products = [];
    $message = "Error loading products: " . $e->getMessage();
    $message_type = "error";
}

// Get unique categories
try {
    $categories = getUniqueCategories();
} catch (Exception $e) {
    $categories = [];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Administration</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Admin-specific styling */
        body {
            background: #f8fafc;
        }
        
        .admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        
        .admin-header h1 {
            margin: 0;
            color: white;
        }
        
        .admin-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .admin-actions {
            display: flex;
            gap: 1rem;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: #64748b;
            color: white;
        }
        
        .btn-danger {
            background: var(--error-color);
            color: white;
        }
        
        .btn-success {
            background: var(--success-color);
            color: white;
        }
        
        .btn-small {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
        
        .message {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }
        
        .message.success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }
        
        .message.error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        
        .admin-section {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-group label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        
        .products-table th {
            background: #f1f5f9;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .products-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .products-table tr:hover {
            background: #f8fafc;
        }
        
        .product-image-preview {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .stat-card h3 {
            font-size: 0.875rem;
            color: #64748b;
            margin: 0 0 0.5rem 0;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }
        
        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        @media (max-width: 768px) {
            .form-grid,
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .products-table {
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body>
    
    <!-- Admin Header -->
    <div class="admin-header">
        <div class="container">
            <div class="admin-nav">
                <h1>🛠️ Product Administration</h1>
                <div class="admin-actions">
                    <a href="index.php" class="btn btn-secondary">View Store</a>
                    <a href="?logout=1" class="btn btn-danger">Logout</a>
                </div>
            </div>
            <p style="margin: 0; opacity: 0.9;">Manage your product database</p>
        </div>
    </div>
    
    <div class="container">
        
        <!-- Message Display -->
        <?php if ($message): ?>
            <div class="message <?= $message_type ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        
        <!-- Statistics Dashboard -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Products</h3>
                <div class="stat-value"><?= count($products) ?></div>
            </div>
            <div class="stat-card">
                <h3>Categories</h3>
                <div class="stat-value"><?= count($categories) ?></div>
            </div>
            <div class="stat-card">
                <h3>In Stock</h3>
                <div class="stat-value">
                    <?= count(array_filter($products, function($p) { return $p['stock'] > 0; })) ?>
                </div>
            </div>
            <div class="stat-card">
                <h3>On Sale</h3>
                <div class="stat-value">
                    <?= count(array_filter($products, function($p) { return !empty($p['sale_price']); })) ?>
                </div>
            </div>
        </div>
        
        <!-- Add New Product Form -->
        <div class="admin-section">
            <h2>➕ Add New Product</h2>
            <form method="POST" id="addProductForm">
                <input type="hidden" name="action" value="add">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Product Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="category">Category *</label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="caps">Caps</option>
                            <option value="shoes">Shoes</option>
                            <option value="accessories">Accessories</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Price ($) *</label>
                        <input type="number" id="price" name="price" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="sale_price">Sale Price ($)</label>
                        <input type="number" id="sale_price" name="sale_price" step="0.01" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="stock">Stock Quantity *</label>
                        <input type="number" id="stock" name="stock" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="thumbnail">Thumbnail Image URL</label>
                        <input type="text" id="thumbnail" name="thumbnail" placeholder="images/product-thumb.jpg">
                    </div>
                </div>
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="image_main">Main Image URL</label>
                    <input type="text" id="image_main" name="image_main" placeholder="images/product-main.jpg">
                </div>
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-success">Add Product</button>
            </form>
        </div>
        
        <!-- Products List -->
        <div class="admin-section">
            <h2>📦 Manage Products</h2>
            
            <?php if (empty($products)): ?>
                <p>No products found in the database.</p>
            <?php else: ?>
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= $product['id'] ?></td>
                                <td>
                                    <?php if (!empty($product['thumbnail'])): ?>
                                        <img src="<?= htmlspecialchars($product['thumbnail']) ?>" 
                                             alt="<?= htmlspecialchars($product['name']) ?>" 
                                             class="product-image-preview">
                                    <?php else: ?>
                                        <div style="width: 60px; height: 60px; background: #e2e8f0; border-radius: 4px;"></div>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?= htmlspecialchars($product['name']) ?></strong></td>
                                <td><?= htmlspecialchars($product['category']) ?></td>
                                <td>
                                    <?php if (!empty($product['sale_price'])): ?>
                                        <span style="text-decoration: line-through; color: #64748b;">
                                            $<?= number_format($product['price'], 2) ?>
                                        </span><br>
                                        <span style="color: var(--error-color); font-weight: 600;">
                                            $<?= number_format($product['sale_price'], 2) ?>
                                        </span>
                                    <?php else: ?>
                                        $<?= number_format($product['price'], 2) ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span style="<?= $product['stock'] < 10 ? 'color: var(--error-color); font-weight: 600;' : '' ?>">
                                        <?= $product['stock'] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button onclick="editProduct(<?= htmlspecialchars(json_encode($product)) ?>)" 
                                                class="btn btn-primary btn-small">Edit</button>
                                        <form method="POST" style="display: inline;" 
                                              onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-small">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        
    </div>
    
    <!-- Edit Product Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h2>✏️ Edit Product</h2>
            <form method="POST" id="editProductForm">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" id="edit_id">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="edit_name">Product Name *</label>
                        <input type="text" id="edit_name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_category">Category *</label>
                        <select id="edit_category" name="category" required>
                            <option value="caps">Caps</option>
                            <option value="shoes">Shoes</option>
                            <option value="accessories">Accessories</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_price">Price ($) *</label>
                        <input type="number" id="edit_price" name="price" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_sale_price">Sale Price ($)</label>
                        <input type="number" id="edit_sale_price" name="sale_price" step="0.01" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_stock">Stock Quantity *</label>
                        <input type="number" id="edit_stock" name="stock" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_thumbnail">Thumbnail Image URL</label>
                        <input type="text" id="edit_thumbnail" name="thumbnail">
                    </div>
                </div>
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="edit_image_main">Main Image URL</label>
                    <input type="text" id="edit_image_main" name="image_main">
                </div>
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="edit_description">Description *</label>
                    <textarea id="edit_description" name="description" required></textarea>
                </div>
                
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-success">Update Product</button>
                    <button type="button" onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Edit product modal
        function editProduct(product) {
            document.getElementById('edit_id').value = product.id;
            document.getElementById('edit_name').value = product.name;
            document.getElementById('edit_category').value = product.category;
            document.getElementById('edit_price').value = product.price;
            document.getElementById('edit_sale_price').value = product.sale_price || '';
            document.getElementById('edit_stock').value = product.stock;
            document.getElementById('edit_thumbnail').value = product.thumbnail || '';
            document.getElementById('edit_image_main').value = product.image_main || '';
            document.getElementById('edit_description').value = product.description || '';
            
            document.getElementById('editModal').classList.add('active');
        }
        
        function closeModal() {
            document.getElementById('editModal').classList.remove('active');
        }
        
        // Close modal on background click
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        // Form validation
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const price = parseFloat(this.querySelector('[name="price"]').value);
                const salePrice = parseFloat(this.querySelector('[name="sale_price"]').value);
                
                if (salePrice && salePrice >= price) {
                    e.preventDefault();
                    alert('Sale price must be less than the regular price!');
                }
            });
        });
    </script>
    
</body>
</html>
