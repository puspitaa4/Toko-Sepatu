// Tab functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const updateButtons = document.querySelectorAll('.update-button');
    
    // Tab switching functionality
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all tabs
            tabButtons.forEach(tab => tab.classList.remove('active'));
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Here you could add logic to show/hide different content
            console.log('Switched to tab:', this.textContent);
        });
    });
    
    // Update button functionality
    updateButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Find the parent review item
            const reviewItem = this.closest('.review-item');
            const username = reviewItem.querySelector('.username').textContent;
            
            // Show confirmation or redirect to update page
            alert(`Update review for ${username}`);
            
            // Here you could add logic to open an update modal or redirect
            console.log('Update review for:', username);
        });
    });
    
    // Back arrow functionality
    const backArrow = document.querySelector('.back-arrow');
    if (backArrow) {
        backArrow.addEventListener('click', function() {
            // Navigate back or to previous page
            console.log('Navigate back');
            // window.history.back(); // Uncomment to enable actual back navigation
        });
    }
    
    // Search functionality
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            console.log('Searching for:', searchTerm);
            
            // Here you could add search filtering logic
            // For example, filter reviews based on username or product name
        });
    }
    
    // Header icon interactions
    const cartIcon = document.querySelector('.cart-icon');
    const heartIcon = document.querySelector('.heart-icon');
    const userIcon = document.querySelector('.user-icon');
    
    if (cartIcon) {
        cartIcon.addEventListener('click', function() {
            console.log('Cart clicked');
            // Add cart functionality here
        });
    }
    
    if (heartIcon) {
        heartIcon.addEventListener('click', function() {
            console.log('Wishlist clicked');
            // Add wishlist functionality here
        });
    }
    
    if (userIcon) {
        userIcon.addEventListener('click', function() {
            console.log('User profile clicked');
            // Add user profile functionality here
        });
    }
});

// Star rating interaction (if you want to make them interactive)
function initializeStarRatings() {
    const starRatings = document.querySelectorAll('.star-rating');
    
    starRatings.forEach(rating => {
        const stars = rating.querySelectorAll('.star');
        
        stars.forEach((star, index) => {
            star.addEventListener('click', function() {
                // Update rating
                stars.forEach((s, i) => {
                    if (i <= index) {
                        s.style.color = '#fbbf24';
                    } else {
                        s.style.color = '#d1d5db';
                    }
                });
                
                console.log('Rating updated to:', index + 1);
            });
        });
    });
}

// Call the function if you want interactive star ratings
// initializeStarRatings();