document.addEventListener('DOMContentLoaded', function() {
    // Get all checkboxes
    const selectAllCheckbox = document.getElementById('selectAll');
    const storeCheckboxes = document.querySelectorAll('.store-check');
    const productCheckboxes = document.querySelectorAll('.product-check');
    const checkoutButton = document.querySelector('.checkout-button');
    const totalAmount = document.querySelector('.total-amount');
    
    // Product prices (in Rupiah)
    const prices = {
        'product1': 2699000,
        'product2': 5999999,
        'product3': 3299000
    };
    
    // Function to update total
    function updateTotal() {
        let total = 0;
        
        productCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const productId = checkbox.id;
                total += prices[productId] || 0;
            }
        });
        
        // Format the total with thousand separators
        totalAmount.textContent = 'Rp' + total.toLocaleString('id-ID');
    }
    
    // Select All functionality
    selectAllCheckbox.addEventListener('change', function() {
        const isChecked = this.checked;
        
        storeCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        
        productCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        
        updateTotal();
    });
    
    // Store checkbox functionality
    storeCheckboxes.forEach(storeCheckbox => {
        storeCheckbox.addEventListener('change', function() {
            const storeId = this.id;
            const storeIndex = storeId.replace('store', '');
            
            // Find related product checkboxes and update them
            const relatedProductCheckbox = document.getElementById('product' + storeIndex);
            if (relatedProductCheckbox) {
                relatedProductCheckbox.checked = this.checked;
            }
            
            updateTotal();
            updateSelectAllStatus();
        });
    });
    
    // Product checkbox functionality
    productCheckboxes.forEach(productCheckbox => {
        productCheckbox.addEventListener('change', function() {
            updateTotal();
            updateSelectAllStatus();
            
            // Update related store checkbox
            const productId = this.id;
            const productIndex = productId.replace('product', '');
            const relatedStoreCheckbox = document.getElementById('store' + productIndex);
            
            if (relatedStoreCheckbox) {
                relatedStoreCheckbox.checked = this.checked;
            }
        });
    });
    
    // Function to update Select All checkbox status
    function updateSelectAllStatus() {
        const allChecked = Array.from(productCheckboxes).every(checkbox => checkbox.checked);
        const someChecked = Array.from(productCheckboxes).some(checkbox => checkbox.checked);
        
        selectAllCheckbox.checked = allChecked;
        selectAllCheckbox.indeterminate = someChecked && !allChecked;
    }
    
    // Checkout button click event
    checkoutButton.addEventListener('click', function() {
        const selectedProducts = [];
        
        productCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const productId = checkbox.id;
                const productName = checkbox.closest('.item-details').querySelector('h3').textContent;
                selectedProducts.push(productName);
            }
        });
        
        if (selectedProducts.length > 0) {
            alert('Proceeding to checkout with: ' + selectedProducts.join(', '));
        } else {
            alert('Please select at least one product to checkout');
        }
    });
    
    // Initialize total
    updateTotal();
});