/**
 * Product page functionality
 * 
 * Handles product image gallery, quantity controls, and related product interactions
 * 
 * @package ShoeStore
 */

document.addEventListener('DOMContentLoaded', function() {
    // Quantity controls
    const minusButton = document.querySelector('.quantity .minus');
    const plusButton = document.querySelector('.quantity .plus');
    const quantityInput = document.querySelector('.quantity input');
    
    if (minusButton && plusButton && quantityInput) {
        minusButton.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            if (value > 1) {
                quantityInput.value = value - 1;
            }
        });
        
        plusButton.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            const max = parseInt(quantityInput.getAttribute('max'));
            if (value < max) {
                quantityInput.value = value + 1;
            }
        });
    }
    
    // Image gallery functionality
    const mainImage = document.querySelector('.main-image img');
    const thumbnailImages = document.querySelectorAll('.thumbnail');
    
    if (thumbnailImages.length > 0) {
        thumbnailImages.forEach(thumb => {
            thumb.addEventListener('click', function() {
                // Update main image
                mainImage.src = this.src;
                
                // Update active thumbnail
                thumbnailImages.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });
    }
    
    // Related product interactions
    const relatedProducts = document.querySelectorAll('.related-products .product-card');
    relatedProducts.forEach(product => {
        product.addEventListener('click', function(e) {
            // Only navigate if click wasn't on a button or link
            if (!e.target.closest('button') && !e.target.closest('a')) {
                const link = this.querySelector('a');
                if (link) {
                    window.location.href = link.href;
                }
            }
        });
    });
});