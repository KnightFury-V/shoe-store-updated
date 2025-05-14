/**
 * Shopping cart functionality
 * 
 * Handles adding/removing items, updating quantities, and cart interactions
 * 
 * @package ShoeStore
 */

document.addEventListener('DOMContentLoaded', function() {
    // Add to cart buttons
    const addToCartButtons = document.querySelectorAll('.add-to-cart, .add-to-cart-btn');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            let quantity = 1;
            
            // Check if quantity input exists (on product page)
            const quantityInput = this.closest('.add-to-cart')?.querySelector('input[name="quantity"]');
            if (quantityInput) {
                quantity = parseInt(quantityInput.value);
            }
            
            addToCart(productId, quantity);
        });
    });
    
    // Remove item buttons
    const removeItemButtons = document.querySelectorAll('.remove-item');
    removeItemButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            removeFromCart(productId);
        });
    });
    
    // Update quantity inputs
    const quantityInputs = document.querySelectorAll('.quantity input');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.getAttribute('data-id');
            const quantity = parseInt(this.value);
            
            if (quantity > 0) {
                updateCartItem(productId, quantity);
            } else {
                removeFromCart(productId);
            }
        });
    });
    
    /**
     * Add item to cart
     * @param {string} productId 
     * @param {number} quantity 
     */
    function addToCart(productId, quantity = 1) {
        fetch('includes/cart-actions.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=add&product_id=${productId}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartCount(data.cartCount);
                showAlert('Item added to cart');
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('An error occurred', 'error');
        });
    }
    
    /**
     * Remove item from cart
     * @param {string} productId 
     */
    function removeFromCart(productId) {
        fetch('includes/cart-actions.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=remove&product_id=${productId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartCount(data.cartCount);
                // Remove item row from table
                const itemRow = document.querySelector(`.remove-item[data-id="${productId}"]`).closest('tr');
                if (itemRow) {
                    itemRow.remove();
                }
                // Update totals
                updateCartTotals(data.cartTotal);
                showAlert('Item removed from cart');
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('An error occurred', 'error');
        });
    }
    
    /**
     * Update item quantity in cart
     * @param {string} productId 
     * @param {number} quantity 
     */
    function updateCartItem(productId, quantity) {
        fetch('includes/cart-actions.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=update&product_id=${productId}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartCount(data.cartCount);
                // Update item total in table
                const itemTotal = document.querySelector(`input[data-id="${productId}"]`).closest('tr').querySelector('.total');
                if (itemTotal) {
                    itemTotal.textContent = '$' + (data.itemPrice * quantity).toFixed(2);
                }
                // Update cart totals
                updateCartTotals(data.cartTotal);
                showAlert('Cart updated');
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('An error occurred', 'error');
        });
    }
    
    /**
     * Update cart count in header
     * @param {number} count 
     */
    function updateCartCount(count) {
        const cartCountElement = document.querySelector('.cart-count');
        const cartIcon = document.querySelector('.cart-icon');
        
        if (count > 0) {
            if (cartCountElement) {
                cartCountElement.textContent = count;
            } else if (cartIcon) {
                const countElement = document.createElement('span');
                countElement.className = 'cart-count';
                countElement.textContent = count;
                cartIcon.appendChild(countElement);
            }
        } else if (cartCountElement) {
            cartCountElement.remove();
        }
    }
    
    /**
     * Update cart totals on cart page
     * @param {number} total 
     */
    function updateCartTotals(total) {
        const subtotalElement = document.querySelector('.cart-summary .subtotal span:last-child');
        const totalElement = document.querySelector('.cart-summary .total span:last-child');
        
        if (subtotalElement) subtotalElement.textContent = '$' + total.toFixed(2);
        if (totalElement) totalElement.textContent = '$' + total.toFixed(2);
    }
    
    /**
     * Show alert message
     * @param {string} message 
     * @param {string} type 
     */
    function showAlert(message, type = 'success') {
        const alertElement = document.createElement('div');
        alertElement.className = `alert ${type}`;
        alertElement.textContent = message;
        
        document.body.appendChild(alertElement);
        
        setTimeout(() => {
            alertElement.classList.add('fade-out');
            setTimeout(() => {
                alertElement.remove();
            }, 300);
        }, 3000);
    }
});