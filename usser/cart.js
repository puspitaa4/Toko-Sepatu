document.addEventListener('DOMContentLoaded', function() {
    // Quantity controls
    const decreaseBtn = document.querySelector('.decrease');
    const increaseBtn = document.querySelector('.increase');
    const quantityInput = document.querySelector('.quantity-input');
    const itemTotal = document.querySelector('.item-total p');
    const subTotal = document.querySelector('.summary-row:first-of-type span:last-child');
    const total = document.querySelector('.total span:last-child');
    
    // Price per item
    const pricePerItem = 2699000;
    
    // Format price with dots as thousand separators
    function formatPrice(price) {
        return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    // Update totals based on quantity
    function updateTotals() {
        const quantity = parseInt(quantityInput.value);
        const totalPrice = pricePerItem * quantity;
        
        itemTotal.textContent = formatPrice(totalPrice);
        subTotal.textContent = formatPrice(totalPrice);
        total.textContent = formatPrice(totalPrice);
    }
    
    // Decrease quantity
    decreaseBtn.addEventListener('click', function() {
        let quantity = parseInt(quantityInput.value);
        if (quantity > 1) {
            quantityInput.value = quantity - 1;
            updateTotals();
        }
    });
    
    // Increase quantity
    increaseBtn.addEventListener('click', function() {
        let quantity = parseInt(quantityInput.value);
        quantityInput.value = quantity + 1;
        updateTotals();
    });
    
    // Handle manual input
    quantityInput.addEventListener('change', function() {
        let quantity = parseInt(quantityInput.value);
        if (isNaN(quantity) || quantity < 1) {
            quantityInput.value = 1;
        }
        updateTotals();
    });
    
    // Add placeholder shoe image
    const shoeImg = document.querySelector('.item-image img');
    shoeImg.onerror = function() {
        this.src = 'https://via.placeholder.com/80x80?text=Jordan+Delta+2';
    };
    
    // Checkout button
    const checkoutBtn = document.querySelector('.checkout-btn');
    checkoutBtn.addEventListener('click', function() {
        alert('Proceeding to checkout!');
    });
    
    // Add order button
    const addOrderBtn = document.querySelector('.add-order-btn');
    addOrderBtn.addEventListener('click', function() {
        alert('Adding more items to your order!');
    });
});

