// Products.js - Product functionality only
document.addEventListener('DOMContentLoaded', function () {
    const mainElement = document.querySelector('main');
    const category = mainElement ? mainElement.getAttribute('data-category') : null;

    function fetchProducts(params) {
        fetch('fetch_products.php?' + params.toString())
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    console.error('Server error:', data.error);
                    displayErrorMessage('Error loading products: ' + data.error);
                    return;
                }

                const products = Array.isArray(data) ? data : [];
                const bestSellersContainer = document.getElementById('best-sellers');
                const shopByCategoryContainer = document.getElementById('shop-by-category');
                const productList = document.getElementById('product-list');

                if (bestSellersContainer) bestSellersContainer.innerHTML = '';
                if (shopByCategoryContainer) shopByCategoryContainer.innerHTML = '';
                if (productList) productList.innerHTML = '';

                if (products.length === 0) {
                    const noProductsMessage = `
                        <div class="no-products-message">
                            <p>No products matching your criteria were found. Please try adjusting your filters or check back later.</p>
                        </div>
                    `;
                    if (bestSellersContainer) bestSellersContainer.innerHTML = noProductsMessage;
                    if (shopByCategoryContainer) shopByCategoryContainer.innerHTML = noProductsMessage;
                    if (productList) productList.innerHTML = noProductsMessage;
                    return;
                }

                const bestSellersToShow = products.slice(0, 4);
                const shopByCategoryToShow = products.slice(0, 4);

                function truncateDescription(description, maxWords = 30) {
                    if (!description) return '';
                    const textOnly = description.replace(/<\/?[^>]+(>|$)/g, "");
                    const cleanedText = textOnly.replace("About this item", "").trim();
                    const words = cleanedText.split(/\s+/);
                    if (words.length <= maxWords) return cleanedText;
                    return words.slice(0, maxWords).join(' ') + '...';
                }

                // UPDATED: Amazon-style product card - whole card clickable, no add to cart button
                function createProductCard(product) {
                    const truncatedDescription = truncateDescription(product.description, 30);
                    let imageUrl = product.image_url || product.image;

                    if (!imageUrl || imageUrl === 'images/rose_bloom.jpg' || imageUrl === 'images/oud_intense.jpg' || imageUrl === 'images/mystic_amber.jpg') {
                        imageUrl = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2Y0ZjRmNCIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiIGZpbGw9IiM5OTkiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5ObyBJbWFnZTwvdGV4dD48L3N2Zz4=';
                    }

                    const price = parseFloat(product.price || 0).toFixed(2);

                    // Check if we're on a product list page (collections.php) vs homepage
                    const isProductListPage = productList !== null;

                    if (isProductListPage) {
                        // For collections page - keep the old style with add to cart button
                        return `
                            <div class="content-card">
                                <img src="${imageUrl}" alt="${product.name}" class="redirect-image" data-id="${product.id}" 
                                     style="cursor: pointer; transition: transform 0.3s ease;" 
                                     onclick="window.location.href='product_detail.php?id=${product.id}'"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="image-placeholder" style="display:none; width:100%; height:200px; background:#f4f4f4; align-items:center; justify-content:center; color:#999; font-size:14px;">No Image Available</div>
                                <div class="card-info">
                                    <h4 style="cursor: pointer;" onclick="window.location.href='product_detail.php?id=${product.id}'">${product.name}</h4>
                                    <p style="text-align: left;">
                                        ${truncatedDescription} <a href="product_detail.php?id=${product.id}" style="color: #bf2e1a; text-decoration: none;">for more info</a>
                                    </p>
                                    <p style="text-align: left; color: #bf2e1a;">$${price}</p>
                                    <div class="product-stock ${product.stock > 0 ? 'in-stock' : 'out-of-stock'}">
                                        ${product.stock > 0 ? `In Stock (${product.stock})` : 'Out of Stock'}
                                    </div>
                                    <button class="add-to-cart-btn" onclick="handleAddToCart('${product.id}', '${product.name.replace(/'/g, "\\'")}', '${product.price}', '${imageUrl}', ${product.stock})" ${product.stock <= 0 ? 'disabled' : ''}>
                                        ${product.stock > 0 ? 'Add to Cart' : 'Out of Stock'}
                                    </button>
                                </div>
                            </div>
                        `;
                    } else {
                        // For homepage - new Amazon-style clickable cards
                        return `
                            <div class="content-card" 
                                 style="cursor: pointer; transition: all 0.3s ease; height: 380px;" 
                                 onclick="window.location.href='product_detail.php?id=${product.id}'"
                                 onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 30px rgba(0, 0, 0, 0.2)'"
                                 onmouseout="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.15)'">
                                 
                                <img src="${imageUrl}" 
                                     alt="${product.name}" 
                                     style="transition: transform 0.3s ease; height: 200px; width: 100%; object-fit: cover; border-radius: 12px 12px 0 0;" 
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                     
                                <div class="image-placeholder" style="display:none; width:100%; height:200px; background:#f4f4f4; align-items:center; justify-content:center; color:#999; font-size:14px; border-radius: 12px 12px 0 0;">No Image Available</div>
                                
                                <div class="card-info" style="padding: 20px; height: calc(100% - 200px); display: flex; flex-direction: column; justify-content: space-between;">
                                    <div>
                                        <h4 style="margin: 0 0 10px 0; color: #333; font-size: 16px; font-weight: 600; line-height: 1.3;">${product.name}</h4>
                                           
                                        <p style="color: #666; font-size: 13px; line-height: 1.4; margin: 0 0 10px 0; text-align: left;">
                                            ${truncatedDescription}
                                        </p>
                                        
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                            <p style="margin: 0; color: #bf2e1a; font-size: 18px; font-weight: 700;">$${price}</p>
                                            <div class="product-stock ${product.stock > 0 ? 'in-stock' : 'out-of-stock'}" style="font-size: 11px;">
                                                ${product.stock > 0 ? `In Stock` : 'Out of Stock'}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Call-to-action text instead of button -->
                                    <div class="cta-hint" style="text-align: center; padding: 12px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 8px; border: 1px solid #dee2e6; transition: all 0.3s ease;">
                                        <span style="color: #bf2e1a; font-weight: 600; font-size: 14px;">
                                            👆 Click to view details & add to cart
                                        </span>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                }

                if (bestSellersContainer) {
                    bestSellersToShow.forEach(product => {
                        bestSellersContainer.innerHTML += createProductCard(product);
                    });
                }

                if (shopByCategoryContainer && !productList) {
                    fetchCategories();
                }

                if (productList) {
                    products.forEach(product => {
                        productList.innerHTML += createProductCard(product);
                    });
                }

                // Only add event listeners for collections page where we still have add to cart buttons
                if (productList) {
                    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                        button.addEventListener('click', function (e) {
                            e.stopPropagation(); // Prevent card click when clicking button
                            if (this.disabled) return;

                            try {
                                const product = JSON.parse(this.getAttribute('data-product'));
                                addToCart(product);
                            } catch (error) {
                                console.error('Error adding to cart:', error);
                                displayMessage('Error adding product to cart', 'error');
                            }
                        });
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching products:', error);
                displayErrorMessage('Failed to load products. Please try again later.');
            });
    }

    function fetchCategories() {
        const categories = [
            { id: 1, name: 'Brands', image: 'perfume_images/ali-bakhtiari-7ic3yF64FS8-unsplash.jpg', link: 'collections.php?category=brands' },
            { id: 2, name: 'New Arrivals', image: 'perfume_images/gift-habeshaw-C1qrJ9i4EPc-unsplash.jpg', link: 'collections.php?category=new-arrivals' },
            { id: 3, name: 'Samples', image: 'perfume_images/laura-chouette-gbT2KAq1V5c-unsplash_resized.jpeg', link: 'collections.php?category=samples' },
            { id: 4, name: 'Accessories', image: 'perfume_images/laura-chouette-nF_VBoF3IAY-unsplash.jpg', link: 'collections.php?category=accessories' },
        ];

        const shopByCategoryContainer = document.getElementById('shop-by-category');
        if (!shopByCategoryContainer) return;

        shopByCategoryContainer.innerHTML = '';

        categories.forEach(category => {
            const categoryCard = `
                <div class="content-card" style="height: 280px; cursor: pointer;" onclick="window.location.href='${category.link}'">
                    <img src="${category.image}" alt="${category.name}" style="height: 180px; width: 100%; object-fit: cover; border-radius: 12px 12px 0 0;" onerror="this.src='perfume_images/default.jpg'">
                    <div style="padding: 20px; display: flex; align-items: center; justify-content: center; height: 100px;">
                        <h4 style="margin: 0; font-size: 18px; font-weight: 600; color: #333; text-align: center;">${category.name}</h4>
                    </div>
                </div>
            `;
            shopByCategoryContainer.innerHTML += categoryCard;
        });
    }

    // Helper function for add to cart (used on collections page)
    function handleAddToCart(productId, productName, productPrice, productImage, productStock) {
        if (productStock <= 0) {
            displayMessage('This product is out of stock', 'error');
            return;
        }

        const product = {
            id: productId,
            name: productName,
            price: productPrice,
            image: productImage,
            image_url: productImage,
            stock: productStock
        };

        addToCart(product);
    }

    // Make handleAddToCart globally accessible for inline onclick handlers
    window.handleAddToCart = handleAddToCart;

    function displayMessage(message, type = 'success') {
        const messageBox = document.createElement('div');
        messageBox.textContent = message;
        messageBox.className = 'message-box';
        messageBox.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            z-index: 1000;
            animation: slideIn 0.3s ease-in-out;
            background-color: ${type === 'error' ? '#ff4444' : '#4CAF50'};
        `;
        document.body.appendChild(messageBox);

        setTimeout(() => {
            if (messageBox.parentNode) {
                messageBox.remove();
            }
        }, 3000);
    }

    function displayErrorMessage(message) {
        displayMessage(message, 'error');
    }

    function addToCart(product) {
        if (!product || !product.id) {
            displayMessage('Invalid product', 'error');
            return;
        }

        if (product.stock <= 0) {
            displayMessage('Product is out of stock', 'error');
            return;
        }

        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const cartItem = cart.find(item => item.id === product.id);

        if (cartItem) {
            cartItem.quantity = parseInt(cartItem.quantity || 1) + 1;
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image_url || product.image,
                image_url: product.image_url || product.image,
                quantity: 1
            });
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        displayMessage(`${product.name} has been added to your cart.`);

        if (window.refreshCartCounter) {
            window.refreshCartCounter();
        }
    }

    // Populate review form dropdown
    function populateReviewProductDropdown() {
        const dropdown = document.getElementById('reviewProduct');
        if (!dropdown) return;

        fetch('fetch_reviews.php?fetch=products')
            .then(response => response.json())
            .then(products => {
                if (!Array.isArray(products)) {
                    console.error('Product fetch failed for review form');
                    return;
                }

                products.forEach(product => {
                    const option = document.createElement('option');
                    option.value = product.product_id;
                    option.textContent = product.name;
                    dropdown.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading review products:', error);
            });
    }

    // Load reviews into carousel
    function loadReviews() {
        const container = document.getElementById('carousel-group');
        if (!container) return;

        fetch('fetch_reviews.php?fetch=reviews')
            .then(response => response.json())
            .then(reviews => {
                if (!Array.isArray(reviews)) {
                    container.innerHTML = '<p>No reviews found.</p>';
                    return;
                }

                container.innerHTML = '';
                reviews.forEach(review => {
                    const reviewItem = document.createElement('div');
                    reviewItem.className = 'carousel-item';
                    reviewItem.innerHTML = `
                        <h4>${review.reviewer_name}</h4>
                        <p><strong>${review.product_name}</strong></p>
                        <p>${review.review_text}</p>
                        <p>Rating: ${'⭐'.repeat(review.rating)}</p>
                        <small>${new Date(review.created_at).toLocaleDateString()}</small>
                    `;
                    container.appendChild(reviewItem);
                });

                // Re-initialize carousel scrolling after reviews are loaded
                setupReviewCarousel();
            })
            .catch(error => {
                console.error('Error loading reviews:', error);
            });
    }

    // Setup left/right scroll on review carousel
    function setupReviewCarousel() {
        const group = document.getElementById('carousel-group');
        const prevBtn = document.getElementById('prev');
        const nextBtn = document.getElementById('next');

        if (!group || !prevBtn || !nextBtn) return;

        const scrollStep = group.offsetWidth;

        prevBtn.addEventListener('click', () => {
            group.scrollBy({
                left: -scrollStep,
                behavior: 'smooth'
            });
        });

        nextBtn.addEventListener('click', () => {
            group.scrollBy({
                left: scrollStep,
                behavior: 'smooth'
            });
        });
    }

    // Initial calls
    const initialParams = new URLSearchParams();
    if (category) {
        initialParams.append('category', category);
        const categoryElement = document.getElementById('category');
        if (categoryElement) categoryElement.value = category;
    }

    fetchProducts(initialParams);
    fetchCategories();
    populateReviewProductDropdown();
    loadReviews();
});