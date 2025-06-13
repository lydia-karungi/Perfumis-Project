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
                  
                function createProductCard(product) {
                    const truncatedDescription = truncateDescription(product.description, 30);
                    let imageUrl = product.image_url || product.image;
                    
                    if (!imageUrl || imageUrl === 'images/rose_bloom.jpg' || imageUrl === 'images/oud_intense.jpg' || imageUrl === 'images/mystic_amber.jpg') {
                        imageUrl = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2Y0ZjRmNCIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiIGZpbGw9IiM5OTkiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5ObyBJbWFnZTwvdGV4dD48L3N2Zz4=';
                    }
                    
                    const price = parseFloat(product.price || 0).toFixed(2);
                    
                    return `
                        <div class="content-card">
                            <img src="${imageUrl}" alt="${product.name}" class="redirect-image" data-id="${product.id}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="image-placeholder" style="display:none; width:100%; height:200px; background:#f4f4f4; align-items:center; justify-content:center; color:#999; font-size:14px;">No Image Available</div>
                            <div class="card-info">
                                <h4>${product.name}</h4>
                                <p style="text-align: left;">
                                    ${truncatedDescription} <a href="product_detail.php?id=${product.id}" style="color: #bf2e1a; text-decoration: none;">for more info</a>
                                </p>
                                <p style="text-align: left; color: #bf2e1a;">$${price}</p>
                                <div class="product-stock ${product.stock > 0 ? 'in-stock' : 'out-of-stock'}">
                                    ${product.stock > 0 ? `In Stock (${product.stock})` : 'Out of Stock'}
                                </div>
                                <button class="add-to-cart-btn" data-product='${JSON.stringify(product)}' ${product.stock <= 0 ? 'disabled' : ''}>
                                    ${product.stock > 0 ? 'Add to Cart' : 'Out of Stock'}
                                </button>
                            </div>
                        </div>
                    `;
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

                // Add event listeners for dynamically added cart buttons
                document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                    button.addEventListener('click', function () {
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

                document.querySelectorAll('.redirect-image').forEach(image => {
                    image.style.cursor = 'pointer';
                    image.addEventListener('click', function () {
                        const productId = this.getAttribute('data-id');
                        window.location.href = `product_detail.php?id=${productId}`;
                    });
                });
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

    function displayMessage(message, type = 'success') {
        const messageBox = document.createElement('div');
        messageBox.textContent = message;
        messageBox.className = 'message-box';
        messageBox.style.backgroundColor = type === 'error' ? '#ff4444' : '#4CAF50';
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
        
        // Update cart counter in header
        if (window.refreshCartCounter) {
            window.refreshCartCounter();
        }
    }

    // Initialize
    if (category) {
        const categoryElement = document.getElementById('category');
        if (categoryElement) {
            categoryElement.value = category;
        }
    }

    const initialParams = new URLSearchParams();
    if (category) {
        initialParams.append('category', category);
    }
    fetchProducts(initialParams);

    fetchCategories();
});