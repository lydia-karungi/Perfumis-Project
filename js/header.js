// Header.js - Header functionality only
document.addEventListener('DOMContentLoaded', function() {
    // Header scroll effect
    const header = document.querySelector('.header-container');
    const scrollToTopBtn = document.getElementById('scrollToTop');
    
    // Create scroll to top button if it doesn't exist
    if (!scrollToTopBtn) {
        const scrollToTop = document.createElement('button');
        scrollToTop.id = 'scrollToTop';
        scrollToTop.className = 'scroll-to-top';
        scrollToTop.innerHTML = '<i class="fas fa-chevron-up"></i>';
        scrollToTop.setAttribute('aria-label', 'Scroll to top');
        document.body.appendChild(scrollToTop);
    }
    
    const scrollToTop = document.getElementById('scrollToTop');
    
    // Scroll event listener
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            if (header) header.classList.add('scrolled');
            if (scrollToTop) {
                scrollToTop.classList.add('visible');
            }
        } else {
            if (header) header.classList.remove('scrolled');
            if (scrollToTop) {
                scrollToTop.classList.remove('visible');
            }
        }
    });

    // Mobile menu toggle
    const hamburger = document.getElementById('hamburger');
    const mainMenuList = document.querySelector('.main-menu ul');
    
    if (hamburger && mainMenuList) {
        // Add hamburger spans if they don't exist
        if (hamburger.children.length === 0) {
            hamburger.innerHTML = '<span></span><span></span><span></span>';
        }
        
        hamburger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            hamburger.classList.toggle('active');
            mainMenuList.classList.toggle('active');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!hamburger.contains(e.target) && !mainMenuList.contains(e.target)) {
                hamburger.classList.remove('active');
                mainMenuList.classList.remove('active');
            }
        });

        // Close mobile menu when clicking on a link
        const menuLinks = mainMenuList.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                hamburger.classList.remove('active');
                mainMenuList.classList.remove('active');
            });
        });
    }

    // Scroll to top functionality
    if (scrollToTop) {
        scrollToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Update cart counter function
    window.updateCartCounter = function(count) {
        const cartCounter = document.getElementById('cartCounter');
        if (cartCounter) {
            cartCounter.textContent = count;
            cartCounter.style.display = count > 0 ? 'flex' : 'none';
        }
    };

    // Initialize cart counter from localStorage
    function initializeCartCounter() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        let totalItems = 0;
        cart.forEach(item => {
            totalItems += parseInt(item.quantity || 1);
        });
        
        if (window.updateCartCounter) {
            window.updateCartCounter(totalItems);
        }
    }

    // Initialize cart counter on page load
    initializeCartCounter();

    // Smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const offsetTop = target.offsetTop - 140; // Account for fixed header
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
});

// Global function to update cart counter when items are added/removed
window.refreshCartCounter = function() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    let totalItems = 0;
    cart.forEach(item => {
        totalItems += parseInt(item.quantity || 1);
    });
    
    if (window.updateCartCounter) {
        window.updateCartCounter(totalItems);
    }
};