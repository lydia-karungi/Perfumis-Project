<!DOCTYPE html>
<html lang="en">

<head>
    <title>Collections - Perfumis</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Nunito', sans-serif;
        }

        .breadcrumb {
            background: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
        }

        .breadcrumb-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .breadcrumb a {
            color: #bf2e1a;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: #a52a1a;
        }

        .breadcrumb-separator {
            color: #666;
        }

        .page-header {
            background: white;
            padding: 30px 0;
            border-bottom: 1px solid #eee;
        }

        .page-header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            text-align: center;
        }

        .page-header h1 {
            font-family: 'Dancing Script', cursive;
            font-size: 3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .page-header p {
            color: #666;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .collections-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 40px;
            align-items: start;
        }

        .filters-sidebar {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        .filters-title {
            font-family: 'Dancing Script', cursive;
            font-size: 2.2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .filter-section {
            margin-bottom: 35px;
        }

        .filter-section h4 {
            color: #bf2e1a;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-section input,
        .filter-section select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Nunito', sans-serif;
            transition: all 0.3s ease;
            background: #fff;
            color: #333;
            margin-bottom: 15px;
        }

        .filter-section input:focus,
        .filter-section select:focus {
            outline: none;
            border-color: #bf2e1a;
            box-shadow: 0 0 0 4px rgba(191, 46, 26, 0.1);
            transform: translateY(-1px);
        }

        .price-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .price-inputs input {
            margin-bottom: 0;
        }

        .apply-filters-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #bf2e1a, #d73527);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 20px;
            position: relative;
            overflow: hidden;
        }

        .apply-filters-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .apply-filters-btn:hover::before {
            left: 100%;
        }

        .apply-filters-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(191, 46, 26, 0.4);
        }

        .clear-filters-btn {
            width: 100%;
            padding: 12px;
            background: transparent;
            color: #666;
            border: 2px solid #e1e5e9;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .clear-filters-btn:hover {
            border-color: #bf2e1a;
            color: #bf2e1a;
            transform: translateY(-1px);
        }

        .products-section {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            min-height: 600px;
        }

        .products-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .products-count {
            color: #666;
            font-size: 16px;
        }

        .sort-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sort-dropdown select {
            padding: 10px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sort-dropdown select:focus {
            outline: none;
            border-color: #bf2e1a;
            box-shadow: 0 0 0 3px rgba(191, 46, 26, 0.1);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            width: 100%;
            height: 200px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-category {
            color: #bf2e1a;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .product-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .product-description {
            color: #666;
            font-size: 14px;
            line-height: 1.4;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: #bf2e1a;
            margin-bottom: 15px;
        }

        .product-stock {
            font-size: 12px;
            margin-bottom: 15px;
        }

        .product-stock.in-stock {
            color: #28a745;
        }

        .product-stock.out-of-stock {
            color: #dc3545;
        }

        .product-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #bf2e1a, #d73527);
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(191, 46, 26, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: #bf2e1a;
            border: 2px solid #bf2e1a;
        }

        .btn-secondary:hover {
            background: #bf2e1a;
            color: white;
        }

        .loading-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 80px 40px;
            color: #666;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #bf2e1a;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .no-products-state {
            text-align: center;
            padding: 80px 40px;
            color: #666;
        }

        .no-products-state i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .no-products-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #333;
        }

        .no-products-state p {
            margin-bottom: 30px;
            font-size: 16px;
            line-height: 1.6;
        }

        .browse-all-btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #bf2e1a, #d73527);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .browse-all-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(191, 46, 26, 0.4);
        }

        .filter-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .filter-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(191, 46, 26, 0.1);
            color: #bf2e1a;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .filter-tag .remove {
            cursor: pointer;
            font-weight: bold;
            transition: transform 0.2s ease;
        }

        .filter-tag .remove:hover {
            transform: scale(1.2);
        }

        /* Mobile Toggle for Filters */
        .mobile-filter-toggle {
            display: none;
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #bf2e1a, #d73527);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .mobile-filter-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(191, 46, 26, 0.4);
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .collections-container {
                grid-template-columns: 300px 1fr;
                gap: 30px;
            }
            
            .filters-sidebar {
                padding: 30px;
            }
        }

        @media (max-width: 968px) {
            .page-header h1 {
                font-size: 2.5rem;
            }
            
            .collections-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .mobile-filter-toggle {
                display: block;
            }
            
            .filters-sidebar {
                position: static;
                display: none;
                order: 2;
            }
            
            .filters-sidebar.show {
                display: block;
            }
            
            .products-section {
                padding: 30px 20px;
            }
            
            .products-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 20px 0;
            }
            
            .page-header h1 {
                font-size: 2rem;
            }
            
            .page-header p {
                font-size: 1rem;
            }
            
            .collections-container {
                padding: 20px 15px;
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
            }
            
            .price-inputs {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <header>
        <!-- Include your header here -->
    </header>

    <div class="breadcrumb">
        <div class="breadcrumb-container">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <span class="breadcrumb-separator">></span>
            <span>Collections</span>
        </div>
    </div>

    <div class="page-header">
        <div class="page-header-container">
            <h1>Our Collections</h1>
            <p>Discover our curated selection of premium fragrances</p>
        </div>
    </div>

    <main data-category="collections">
        <div class="collections-container">
            <!-- Mobile Filter Toggle -->
            <button class="mobile-filter-toggle" id="mobileFilterToggle">
                <i class="fas fa-filter"></i> Show Filters
            </button>

            <!-- Filters Sidebar -->
            <aside class="filters-sidebar" id="filtersSidebar">
                <h3 class="filters-title">
                    <i class="fas fa-sliders-h"></i> Refine Your Search
                </h3>
                
                <form id="filterForm">
                    <div class="filter-section">
                        <h4><i class="fas fa-dollar-sign"></i> Price Range</h4>
                        <div class="price-inputs">
                            <input type="number" id="minPrice" name="minPrice" placeholder="Min Price" min="0">
                            <input type="number" id="maxPrice" name="maxPrice" placeholder="Max Price" min="0">
                        </div>
                    </div>

                    <div class="filter-section">
                        <h4><i class="fas fa-tags"></i> Collection</h4>
                        <select id="category" name="category">
                            <option value="">All Collections</option>
                            <option value="men">Men's Fragrances</option>
                            <option value="women">Women's Fragrances</option>
                            <option value="unisex">Unisex Fragrances</option>
                            <option value="luxury">Luxury Collection</option>
                            <option value="bestsellers">Best Sellers</option>
                            <option value="new-arrivals">New Arrivals</option>
                            <option value="gifts">Gift Sets</option>
                            <option value="samples">Samples</option>
                        </select>
                    </div>

                    <div class="filter-section">
                        <h4><i class="fas fa-check-circle"></i> Availability</h4>
                        <select id="availability" name="availability">
                            <option value="">All Products</option>
                            <option value="available">In Stock</option>
                            <option value="outOfStock">Out of Stock</option>
                        </select>
                    </div>

                    <button type="submit" class="apply-filters-btn">
                        <i class="fas fa-search"></i> Apply Filters
                    </button>
                    
                    <button type="button" class="clear-filters-btn" id="clearFilters">
                        <i class="fas fa-times"></i> Clear All Filters
                    </button>
                </form>
            </aside>

            <!-- Products Section -->
            <div class="products-section">
                <div class="products-header">
                    <div class="products-count" id="productsCount">
                        Loading products...
                    </div>
                    <div class="sort-dropdown">
                        <label for="sortBy">Sort by:</label>
                        <select id="sortBy" name="sortBy">
                            <option value="name">Name (A-Z)</option>
                            <option value="price-low">Price (Low to High)</option>
                            <option value="price-high">Price (High to Low)</option>
                            <option value="newest">Newest First</option>
                        </select>
                    </div>
                </div>

                <!-- Active Filters Tags -->
                <div class="filter-tags" id="filterTags"></div>

                <!-- Loading State -->
                <div class="loading-state" id="loadingState">
                    <div class="loading-spinner"></div>
                    <p>Loading our exquisite fragrances...</p>
                </div>

                <!-- Products Grid -->
                <div class="products-grid" id="product-list" style="display: none;">
                    <!-- Products will be dynamically inserted here -->
                </div>

                <!-- No Products State -->
                <div class="no-products-state" id="noProductsState" style="display: none;">
                    <i class="fas fa-search"></i>
                    <h3>No fragrances found</h3>
                    <p>We couldn't find any products matching your criteria. Try adjusting your filters or browse our complete collection.</p>
                    <a href="collections.php" class="browse-all-btn">Browse All Products</a>
                </div>
            </div>
        </div>
    </main>

    <script>
 // Enhanced Collections Page Functionality with URL Parameter Handling
document.addEventListener('DOMContentLoaded', function() {
    const mobileFilterToggle = document.getElementById('mobileFilterToggle');
    const filtersSidebar = document.getElementById('filtersSidebar');
    const loadingState = document.getElementById('loadingState');
    const productsList = document.getElementById('product-list');
    const noProductsState = document.getElementById('noProductsState');
    const productsCount = document.getElementById('productsCount');
    const filterTags = document.getElementById('filterTags');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const filterForm = document.getElementById('filterForm');
    const sortSelect = document.getElementById('sortBy');

    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    
    // Set initial filters based on URL parameters
    function setInitialFilters() {
        // Handle category parameter
        const category = urlParams.get('category');
        if (category) {
            const categorySelect = document.getElementById('category');
            // Map URL categories to select options
            const categoryMap = {
                'men': 'men',
                'women': 'women',
                'unisex': 'unisex',
                'luxury': 'luxury',
                'gifts': 'gifts',
                'new-arrivals': 'new-arrivals',
                'bestsellers': 'bestsellers',
                'accessories': 'accessories',
                'samples': 'samples'
            };
            
            if (categoryMap[category]) {
                categorySelect.value = categoryMap[category];
            }
        }

        // Handle brand parameter
        const brand = urlParams.get('brand');
        if (brand) {
            // You could add a brand filter to your form if needed
            console.log('Brand filter:', brand);
        }

        // Handle type parameter (for subcategories)
        const type = urlParams.get('type');
        if (type) {
            console.log('Type filter:', type);
        }

        // Handle view parameter
        const view = urlParams.get('view');
        if (view === 'brands') {
            // Could show a special brands view
            console.log('Brands view requested');
        }

        // Handle price parameters
        const minPrice = urlParams.get('minPrice');
        const maxPrice = urlParams.get('maxPrice');
        if (minPrice) document.getElementById('minPrice').value = minPrice;
        if (maxPrice) document.getElementById('maxPrice').value = maxPrice;

        // Handle availability
        const availability = urlParams.get('availability');
        if (availability) {
            document.getElementById('availability').value = availability;
        }

        // Update page title based on category
        updatePageTitle(category);
    }

    // Update page title and header based on the filter
    function updatePageTitle(category) {
        const pageTitle = document.querySelector('.page-header h1');
        const pageSubtitle = document.querySelector('.page-header p');
        
        if (!pageTitle || !pageSubtitle) return;

        const titleMap = {
            'men': {
                title: "Men's Fragrances",
                subtitle: "Discover bold and sophisticated scents for the modern gentleman"
            },
            'women': {
                title: "Women's Fragrances",
                subtitle: "Elegant and captivating fragrances for every woman"
            },
            'unisex': {
                title: "Unisex Fragrances",
                subtitle: "Versatile scents that transcend traditional boundaries"
            },
            'luxury': {
                title: "Luxury Collection",
                subtitle: "Premium fragrances crafted with the finest ingredients"
            },
            'gifts': {
                title: "Gift Collection",
                subtitle: "Perfect fragrance gifts for your loved ones"
            },
            'new-arrivals': {
                title: "New Arrivals",
                subtitle: "The latest additions to our fragrance collection"
            },
            'samples': {
                title: "Samples & Travel Sizes",
                subtitle: "Try before you buy or perfect for travel"
            },
            'accessories': {
                title: "Fragrance Accessories",
                subtitle: "Complete your fragrance experience"
            }
        };

        if (titleMap[category]) {
            pageTitle.textContent = titleMap[category].title;
            pageSubtitle.textContent = titleMap[category].subtitle;
            document.title = `${titleMap[category].title} - Perfumis`;
        }
    }

    // Mobile filter toggle
    if (mobileFilterToggle && filtersSidebar) {
        mobileFilterToggle.addEventListener('click', function() {
            filtersSidebar.classList.toggle('show');
            const isShowing = filtersSidebar.classList.contains('show');
            this.innerHTML = isShowing ? 
                '<i class="fas fa-times"></i> Hide Filters' : 
                '<i class="fas fa-filter"></i> Show Filters';
        });
    }

    // Clear filters functionality
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function() {
            filterForm.reset();
            // Clear URL parameters
            window.history.replaceState({}, document.title, window.location.pathname);
            updateFilterTags();
            loadProducts();
        });
    }

    // Update filter tags display
    function updateFilterTags() {
        if (!filterTags) return;
        
        const formData = new FormData(filterForm);
        const tags = [];

        if (formData.get('minPrice')) {
            tags.push({ label: `Min: $${formData.get('minPrice')}`, field: 'minPrice' });
        }
        if (formData.get('maxPrice')) {
            tags.push({ label: `Max: $${formData.get('maxPrice')}`, field: 'maxPrice' });
        }
        if (formData.get('category')) {
            const categorySelect = document.getElementById('category');
            const categoryText = categorySelect.options[categorySelect.selectedIndex].text;
            tags.push({ label: categoryText, field: 'category' });
        }
        if (formData.get('availability')) {
            const availabilitySelect = document.getElementById('availability');
            const availabilityText = availabilitySelect.options[availabilitySelect.selectedIndex].text;
            tags.push({ label: availabilityText, field: 'availability' });
        }

        filterTags.innerHTML = tags.map(tag => `
            <div class="filter-tag">
                ${tag.label}
                <span class="remove" onclick="removeFilter('${tag.field}')">&times;</span>
            </div>
        `).join('');
    }

    // Remove individual filter
    window.removeFilter = function(field) {
        document.getElementById(field).value = '';
        updateFilterTags();
        loadProducts();
    };

    // Load products function
    function loadProducts() {
        if (!loadingState || !productsList || !noProductsState) return;
        
        // Show loading state
        loadingState.style.display = 'flex';
        productsList.style.display = 'none';
        noProductsState.style.display = 'none';

        // Get form data
        const formData = new FormData(filterForm);
        const params = new URLSearchParams();
        
        // Add category parameter (collections to show all if no specific category)
        const selectedCategory = formData.get('category') || 'collections';
        params.append('category', selectedCategory);
        
        // Add filter parameters
        if (formData.get('minPrice')) params.append('minPrice', formData.get('minPrice'));
        if (formData.get('maxPrice')) params.append('maxPrice', formData.get('maxPrice'));
        if (formData.get('availability')) params.append('availability', formData.get('availability'));

        // Fetch products
        fetch(`fetch_products.php?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                loadingState.style.display = 'none';
                
                if (data.error) {
                    console.error('Error:', data.error);
                    noProductsState.style.display = 'block';
                    return;
                }

                if (data.length === 0) {
                    noProductsState.style.display = 'block';
                    updateProductsCount(0);
                    return;
                }

                // Sort products
                const sortedData = sortProducts(data, sortSelect ? sortSelect.value : 'name');
                
                // Display products
                displayProducts(sortedData);
                productsList.style.display = 'grid';
                updateProductsCount(sortedData.length);
            })
            .catch(error => {
                console.error('Fetch error:', error);
                loadingState.style.display = 'none';
                noProductsState.style.display = 'block';
            });
    }

    // Sort products function
    function sortProducts(products, sortBy) {
        const sorted = [...products];
        
        switch(sortBy) {
            case 'name':
                return sorted.sort((a, b) => a.name.localeCompare(b.name));
            case 'price-low':
                return sorted.sort((a, b) => parseFloat(a.price) - parseFloat(b.price));
            case 'price-high':
                return sorted.sort((a, b) => parseFloat(b.price) - parseFloat(a.price));
            case 'newest':
                return sorted.sort((a, b) => b.id - a.id);
            default:
                return sorted;
        }
    }

    // Display products function
    function displayProducts(products) {
        if (!productsList) return;
        
        productsList.innerHTML = products.map(product => `
            <div class="product-card">
                <div class="product-image">
                    <img src="${product.image_url || 'images/placeholder.jpg'}" alt="${product.name}" onerror="this.src='images/placeholder.jpg'">
                </div>
                <div class="product-category">${product.category_name || 'Fragrance'}</div>
                <div class="product-name">${product.name}</div>
                <div class="product-description">${product.description || 'Premium fragrance crafted with care'}</div>
                <div class="product-price">$${parseFloat(product.price).toFixed(2)}</div>
                <div class="product-stock ${product.stock > 0 ? 'in-stock' : 'out-of-stock'}">
                    ${product.stock > 0 ? `${product.stock} in stock` : 'Out of stock'}
                </div>
                <div class="product-actions">
                    <a href="product_detail.php?id=${product.id}" class="btn btn-secondary">View Details</a>
                    ${product.stock > 0 ? 
                        `<button class="btn btn-primary" onclick="addToCart(${product.id})">Add to Cart</button>` :
                        `<button class="btn btn-primary" disabled>Out of Stock</button>`
                    }
                </div>
            </div>
        `).join('');
    }

    // Update products count
    function updateProductsCount(count) {
        if (!productsCount) return;
        
        productsCount.textContent = count === 1 ? 
            `${count} fragrance found` : 
            `${count} fragrances found`;
    }

    // Add to cart function
    window.addToCart = function(productId) {
        console.log('Adding product to cart:', productId);
        // Implement your add to cart functionality here
        alert('Product added to cart!');
    };

    // Listen for filter form changes
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            updateFilterTags();
            loadProducts();
        });
    }

    // Sort functionality
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            loadProducts();
        });
    }

    // Initialize the page
    setInitialFilters();
    updateFilterTags();
    loadProducts();
});
    </script>

    <footer>
        <!-- Include your footer here -->
    </footer>
</body>

</html>