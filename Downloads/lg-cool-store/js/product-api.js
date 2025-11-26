// Product API Consumer and Template Renderer
// Fetches data from PHP API and displays using JavaScript templates

const ProductAPI = {
    baseURL: './api/products.php',
    
    // Fetch products with optional parameters
    async fetchProducts(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        const url = `${this.baseURL}?${queryString}`;
        
        try {
            const response = await fetch(url);
            const data = await response.json();
            
            if (data.success) {
                return data;
            } else {
                throw new Error(data.error || 'Failed to fetch products');
            }
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    },
    
    // Search products
    async search(searchTerm) {
        return this.fetchProducts({ search: searchTerm });
    },
    
    // Filter products
    async filter(category, priceMin = '', priceMax = '') {
        return this.fetchProducts({
            category: category,
            price_min: priceMin,
            price_max: priceMax
        });
    },
    
    // Sort products
    async sort(sortBy, sortOrder = 'ASC') {
        return this.fetchProducts({
            sort: sortBy,
            order: sortOrder
        });
    },
    
    // Combined query (for future enhancement)
    async query(params) {
        return this.fetchProducts(params);
    }
};

// Template Functions
const ProductTemplates = {
    // Product card template (similar to PHP templates)
    productCard(product) {
        return `
            <div class="product-card" data-id="${product.id}">
                <div class="product-image">
                    <a href="product_item.php?id=${product.id}">
                        <img src="${product.thumbnail || product.image_main}" 
                             alt="${this.escapeHtml(product.name)}">
                    </a>
                </div>
                <div class="product-info">
                    <h3 class="product-name">
                        <a href="product_item.php?id=${product.id}">
                            ${this.escapeHtml(product.name)}
                        </a>
                    </h3>
                    <p class="product-category">${this.escapeHtml(product.category)}</p>
                    <p class="product-price">$${parseFloat(product.price).toFixed(2)}</p>
                    <button class="add-to-cart-btn" 
                            onclick="addToCart(${product.id})">
                        Add to Cart
                    </button>
                </div>
            </div>
        `;
    },
    
    // Product list template
    productList(products) {
        if (!products || products.length === 0) {
            return '<div class="no-results">No products found</div>';
        }
        
        return products.map(product => this.productCard(product)).join('');
    },
    
    // Results summary template
    resultsSummary(count, params) {
        let summary = `Showing ${count} product${count !== 1 ? 's' : ''}`;
        
        if (params.search) {
            summary += ` matching "${this.escapeHtml(params.search)}"`;
        }
        if (params.category) {
            summary += ` in ${this.escapeHtml(params.category)}`;
        }
        if (params.price_min || params.price_max) {
            summary += ` (Price: `;
            if (params.price_min) summary += `$${params.price_min}+`;
            if (params.price_max) summary += ` - $${params.price_max}`;
            summary += `)`;
        }
        
        return `<div class="results-summary">${summary}</div>`;
    },
    
    // Escape HTML to prevent XSS
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
};

// UI Controller
class ProductUIController {
    constructor(containerSelector) {
        this.container = document.querySelector(containerSelector);
        this.currentParams = {};
        this.init();
    }
    
    init() {
        // Load all products initially
        this.loadProducts();
        
        // Set up event listeners
        this.setupSearchListener();
        this.setupFilterListeners();
        this.setupSortListener();
        this.setupResetButton();
    }
    
    async loadProducts(params = {}) {
        try {
            // Show loading state
            this.showLoading();
            
            // Store current parameters
            this.currentParams = params;
            
            // Fetch products
            const data = await ProductAPI.fetchProducts(params);
            
            // Render products
            this.renderProducts(data);
            
        } catch (error) {
            this.showError('Failed to load products. Please try again.');
            console.error(error);
        }
    }
    
    renderProducts(data) {
        if (!this.container) return;
        
        const summaryHTML = ProductTemplates.resultsSummary(data.count, data.query_params);
        const productsHTML = ProductTemplates.productList(data.products);
        
        this.container.innerHTML = summaryHTML + '<div class="product-grid">' + productsHTML + '</div>';
    }
    
    showLoading() {
        if (this.container) {
            this.container.innerHTML = '<div class="loading">Loading products...</div>';
        }
    }
    
    showError(message) {
        if (this.container) {
            this.container.innerHTML = `<div class="error">${message}</div>`;
        }
    }
    
    setupSearchListener() {
        const searchForm = document.querySelector('#search-form');
        const searchInput = document.querySelector('#search-input');
        
        if (searchForm && searchInput) {
            searchForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const searchTerm = searchInput.value.trim();
                this.loadProducts({ search: searchTerm });
            });
        }
    }
    
    setupFilterListeners() {
        // Category filter
        const categoryFilter = document.querySelector('#filter-category');
        if (categoryFilter) {
            categoryFilter.addEventListener('change', (e) => {
                this.currentParams.category = e.target.value;
                this.loadProducts(this.currentParams);
            });
        }
        
        // Price range filter
        const priceForm = document.querySelector('#price-filter-form');
        if (priceForm) {
            priceForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const minPrice = document.querySelector('#price-min').value;
                const maxPrice = document.querySelector('#price-max').value;
                
                this.currentParams.price_min = minPrice;
                this.currentParams.price_max = maxPrice;
                this.loadProducts(this.currentParams);
            });
        }
    }
    
    setupSortListener() {
        const sortSelect = document.querySelector('#sort-select');
        if (sortSelect) {
            sortSelect.addEventListener('change', (e) => {
                const [sortBy, sortOrder] = e.target.value.split('-');
                this.currentParams.sort = sortBy;
                this.currentParams.order = sortOrder;
                this.loadProducts(this.currentParams);
            });
        }
    }
    
    setupResetButton() {
        const resetBtn = document.querySelector('#reset-filters');
        if (resetBtn) {
            resetBtn.addEventListener('click', () => {
                // Clear all inputs
                const searchInput = document.querySelector('#search-input');
                if (searchInput) searchInput.value = '';
                
                const categoryFilter = document.querySelector('#filter-category');
                if (categoryFilter) categoryFilter.value = '';
                
                const priceMin = document.querySelector('#price-min');
                if (priceMin) priceMin.value = '';
                
                const priceMax = document.querySelector('#price-max');
                if (priceMax) priceMax.value = '';
                
                const sortSelect = document.querySelector('#sort-select');
                if (sortSelect) sortSelect.value = 'name-ASC';
                
                // Reset and reload
                this.currentParams = {};
                this.loadProducts();
            });
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize the product UI controller
    const productUI = new ProductUIController('#product-container');
});
