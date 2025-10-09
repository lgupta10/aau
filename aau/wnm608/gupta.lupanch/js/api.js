// ================================
// API Module - Backend Connection
// ================================

// API Configuration
const API_CONFIG = {
  baseURL: 'http://localhost:3000/api', // Change this to your backend URL
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json'
  }
};

// ================================
// API Helper Functions
// ================================

/**
 * Make an API request
 * @param {string} endpoint - API endpoint
 * @param {object} options - Fetch options
 * @returns {Promise} Response data
 */
async function apiRequest(endpoint, options = {}) {
  const url = `${API_CONFIG.baseURL}${endpoint}`;
  
  const config = {
    ...options,
    headers: {
      ...API_CONFIG.headers,
      ...options.headers
    }
  };
  
  // Add auth token if available
  const token = getAuthToken();
  if (token) {
    config.headers['Authorization'] = `Bearer ${token}`;
  }
  
  try {
    const response = await fetch(url, config);
    
    // Handle non-200 responses
    if (!response.ok) {
      const error = await response.json();
      throw new Error(error.message || 'API request failed');
    }
    
    return await response.json();
  } catch (error) {
    console.error('Failed to create order:', error);
    throw error;
  }
}

/**
 * Get user's orders
 * @returns {Promise<Array>} Array of orders
 */
async function getUserOrders() {
  try {
    const data = await apiRequest('/orders', {
      method: 'GET'
    });
    return data;
  } catch (error) {
    console.error('Failed to fetch orders:', error);
    return [];
  }
}

/**
 * Get single order by ID
 * @param {number} orderId - Order ID
 * @returns {Promise<Object>} Order details
 */
async function getOrder(orderId) {
  try {
    const data = await apiRequest(`/orders/${orderId}`, {
      method: 'GET'
    });
    return data;
  } catch (error) {
    console.error(`Failed to fetch order ${orderId}:`, error);
    return null;
  }
}

// ================================
// Authentication Helpers
// ================================

/**
 * Save auth token to localStorage
 * @param {string} token - JWT token
 */
function setAuthToken(token) {
  localStorage.setItem('lgstore_auth_token', token);
}

/**
 * Get auth token from localStorage
 * @returns {string|null} JWT token
 */
function getAuthToken() {
  return localStorage.getItem('lgstore_auth_token');
}

/**
 * Remove auth token from localStorage
 */
function removeAuthToken() {
  localStorage.removeItem('lgstore_auth_token');
}

/**
 * Check if user is logged in
 * @returns {boolean} True if logged in
 */
function isLoggedIn() {
  return !!getAuthToken();
}

// ================================
// Display Products from API
// ================================

/**
 * Load and display products on the page
 */
async function loadAndDisplayProducts() {
  const productsContainer = document.querySelector('#products, .grid');
  
  if (!productsContainer) return;
  
  // Show loading state
  productsContainer.innerHTML = '<div class="loading">Loading products...</div>';
  
  try {
    const products = await getProducts();
    
    if (products.length === 0) {
      productsContainer.innerHTML = '<p class="muted">No products available.</p>';
      return;
    }
    
    // Clear container
    productsContainer.innerHTML = '';
    
    // Display each product
    products.forEach(product => {
      const productHTML = createProductCard(product);
      productsContainer.insertAdjacentHTML('beforeend', productHTML);
    });
    
    console.log(`✅ Loaded ${products.length} products from API`);
    
  } catch (error) {
    productsContainer.innerHTML = `
      <div class="card soft">
        <p style="color: var(--color-main-medium);">
          ⚠️ Unable to load products. Using offline mode.
        </p>
      </div>
    `;
    console.error('Failed to load products:', error);
  }
}

/**
 * Create product card HTML
 * @param {Object} product - Product data
 * @returns {string} HTML string
 */
function createProductCard(product) {
  return `
    <div class="col-xs-12 col-md-4" data-category="${product.category || 'all'}">
      <figure class="figure product-overlay">
        <img src="${product.image || 'https://via.placeholder.com/400'}" 
             alt="${product.name}"
             loading="lazy">
        <figcaption>
          <div class="caption-body">
            <div class="product-name">${product.name}</div>
            <div class="product-price">${product.price.toFixed(2)}</div>
            ${product.stock > 0 ? `
              <div class="favorite" style="margin-top: 0.5em;">
                <input type="checkbox" id="fav-${product.id}" class="hidden">
                <label for="fav-${product.id}">♥</label>
              </div>
            ` : '<p class="stock-indicator out">Out of Stock</p>'}
          </div>
        </figcaption>
      </figure>
      <div style="text-align: center; margin-top: 1em;">
        ${product.stock > 0 ? `
          <button class="form-button add-to-cart" data-product-id="${product.id}">
            Add to Cart
          </button>
        ` : `
          <button class="form-button" disabled style="opacity: 0.5; cursor: not-allowed;">
            Out of Stock
          </button>
        `}
      </div>
    </div>
  `;
}

// ================================
// Initialize API on Page Load
// ================================

// Auto-load products when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initAPI);
} else {
  initAPI();
}

function initAPI() {
  // Check if we're on a page with products
  const hasProductsContainer = document.querySelector('#products, .grid');
  
  if (hasProductsContainer) {
    // Uncomment this when backend is ready:
    // loadAndDisplayProducts();
    
    console.log('📡 API module loaded. Backend connection ready.');
    console.log('💡 Uncomment loadAndDisplayProducts() in api.js when backend is ready');
  }
  
  // Log authentication status
  if (isLoggedIn()) {
    console.log('✅ User is logged in');
  } else {
    console.log('👤 User not logged in');
  }
}

// ================================
// Export API functions
// ================================
window.API = {
  // Products
  getProducts,
  getProduct,
  getProductsByCategory,
  searchProducts,
  
  // Cart
  getCartFromAPI,
  addToCartAPI,
  updateCartItemAPI,
  removeFromCartAPI,
  
  // Auth
  login,
  register,
  logout,
  getUserProfile,
  isLoggedIn,
  
  // Orders
  createOrder,
  getUserOrders,
  getOrder,
  
  // Display
  loadAndDisplayProducts,
  createProductCard
};
    console.error('API Error:', error);
    throw error;
  }
}

// ================================
// Product API Calls
// ================================

/**
 * Get all products
 * @returns {Promise<Array>} Array of products
 */
async function getProducts() {
  try {
    const data = await apiRequest('/products', {
      method: 'GET'
    });
    return data;
  } catch (error) {
    console.error('Failed to fetch products:', error);
    return [];
  }
}

/**
 * Get single product by ID
 * @param {number} id - Product ID
 * @returns {Promise<Object>} Product data
 */
async function getProduct(id) {
  try {
    const data = await apiRequest(`/products/${id}`, {
      method: 'GET'
    });
    return data;
  } catch (error) {
    console.error(`Failed to fetch product ${id}:`, error);
    return null;
  }
}

/**
 * Get products by category
 * @param {string} category - Category name
 * @returns {Promise<Array>} Filtered products
 */
async function getProductsByCategory(category) {
  try {
    const data = await apiRequest(`/products?category=${category}`, {
      method: 'GET'
    });
    return data;
  } catch (error) {
    console.error(`Failed to fetch ${category} products:`, error);
    return [];
  }
}

/**
 * Search products
 * @param {string} query - Search query
 * @returns {Promise<Array>} Search results
 */
async function searchProducts(query) {
  try {
    const data = await apiRequest(`/products/search?q=${encodeURIComponent(query)}`, {
      method: 'GET'
    });
    return data;
  } catch (error) {
    console.error('Search failed:', error);
    return [];
  }
}

// ================================
// Cart API Calls
// ================================

/**
 * Get user's cart
 * @returns {Promise<Object>} Cart data
 */
async function getCartFromAPI() {
  try {
    const data = await apiRequest('/cart', {
      method: 'GET'
    });
    return data;
  } catch (error) {
    console.error('Failed to fetch cart:', error);
    return { items: [] };
  }
}

/**
 * Add item to cart
 * @param {Object} item - Cart item
 * @returns {Promise<Object>} Updated cart
 */
async function addToCartAPI(item) {
  try {
    const data = await apiRequest('/cart', {
      method: 'POST',
      body: JSON.stringify(item)
    });
    return data;
  } catch (error) {
    console.error('Failed to add to cart:', error);
    throw error;
  }
}

/**
 * Update cart item quantity
 * @param {number} itemId - Cart item ID
 * @param {number} quantity - New quantity
 * @returns {Promise<Object>} Updated cart
 */
async function updateCartItemAPI(itemId, quantity) {
  try {
    const data = await apiRequest(`/cart/${itemId}`, {
      method: 'PUT',
      body: JSON.stringify({ quantity })
    });
    return data;
  } catch (error) {
    console.error('Failed to update cart:', error);
    throw error;
  }
}

/**
 * Remove item from cart
 * @param {number} itemId - Cart item ID
 * @returns {Promise<Object>} Updated cart
 */
async function removeFromCartAPI(itemId) {
  try {
    const data = await apiRequest(`/cart/${itemId}`, {
      method: 'DELETE'
    });
    return data;
  } catch (error) {
    console.error('Failed to remove from cart:', error);
    throw error;
  }
}

// ================================
// User/Auth API Calls
// ================================

/**
 * User login
 * @param {string} email - User email
 * @param {string} password - User password
 * @returns {Promise<Object>} User data and token
 */
async function login(email, password) {
  try {
    const data = await apiRequest('/auth/login', {
      method: 'POST',
      body: JSON.stringify({ email, password })
    });
    
    // Save token
    if (data.token) {
      setAuthToken(data.token);
    }
    
    return data;
  } catch (error) {
    console.error('Login failed:', error);
    throw error;
  }
}

/**
 * User registration
 * @param {Object} userData - User registration data
 * @returns {Promise<Object>} User data and token
 */
async function register(userData) {
  try {
    const data = await apiRequest('/auth/register', {
      method: 'POST',
      body: JSON.stringify(userData)
    });
    
    // Save token
    if (data.token) {
      setAuthToken(data.token);
    }
    
    return data;
  } catch (error) {
    console.error('Registration failed:', error);
    throw error;
  }
}

/**
 * User logout
 */
function logout() {
  removeAuthToken();
  window.location.href = 'index.html';
}

/**
 * Get current user profile
 * @returns {Promise<Object>} User profile data
 */
async function getUserProfile() {
  try {
    const data = await apiRequest('/user/profile', {
      method: 'GET'
    });
    return data;
  } catch (error) {
    console.error('Failed to fetch user profile:', error);
    return null;
  }
}

// ================================
// Order API Calls
// ================================

/**
 * Create new order
 * @param {Object} orderData - Order information
 * @returns {Promise<Object>} Created order
 */
async function createOrder(orderData) {
  try {
    const data = await apiRequest('/orders', {
      method: 'POST',
      body: JSON.stringify(orderData)
    });
    return data;
  } catch (error) {