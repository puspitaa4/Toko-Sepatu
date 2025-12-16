// Function to copy referral code to clipboard
function copyReferralCode() {
    const referralCodeInput = document.querySelector('.referral-code');
    
    // Select the text
    referralCodeInput.select();
    referralCodeInput.setSelectionRange(0, 99999); // For mobile devices
    
    // Copy the text to clipboard
    navigator.clipboard.writeText(referralCodeInput.value)
        .then(() => {
            // Show a temporary tooltip or notification
            showCopyNotification();
        })
        .catch(err => {
            console.error('Failed to copy: ', err);
            // Fallback for older browsers
            document.execCommand('copy');
            showCopyNotification();
        });
}

// Function to show a notification when code is copied
function showCopyNotification() {
    // Check if notification already exists
    let notification = document.querySelector('.copy-notification');
    
    if (!notification) {
        // Create notification element
        notification = document.createElement('div');
        notification.className = 'copy-notification';
        notification.textContent = 'Kode referral disalin!';
        
        // Style the notification
        notification.style.position = 'fixed';
        notification.style.bottom = '20px';
        notification.style.right = '20px';
        notification.style.backgroundColor = '#9e1a1a';
        notification.style.color = 'white';
        notification.style.padding = '10px 20px';
        notification.style.borderRadius = '4px';
        notification.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.2)';
        notification.style.zIndex = '1000';
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(20px)';
        notification.style.transition = 'opacity 0.3s, transform 0.3s';
        
        // Add to document
        document.body.appendChild(notification);
        
        // Trigger animation
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(20px)';
            
            // Remove from DOM after animation completes
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
}

// Mobile sidebar toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    // Add responsive behavior for sidebar on mobile
    const sidebarTitle = document.querySelector('.sidebar-title');
    const sidebarNav = document.querySelector('.sidebar-nav');
    
    if (window.innerWidth < 768) {
        sidebarNav.style.display = 'none';
        
        sidebarTitle.addEventListener('click', function() {
            if (sidebarNav.style.display === 'none') {
                sidebarNav.style.display = 'block';
            } else {
                sidebarNav.style.display = 'none';
            }
        });
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) {
            sidebarNav.style.display = 'block';
        } else {
            sidebarNav.style.display = 'none';
        }
    });
    
    // Add active class to sidebar menu items on click
    const menuItems = document.querySelectorAll('.sidebar-nav li:not(.logout)');
    
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove active class from all items
            menuItems.forEach(i => i.classList.remove('active'));
            
            // Add active class to clicked item
            this.classList.add('active');
            
            // Close sidebar on mobile after selection
            if (window.innerWidth < 768) {
                sidebarNav.style.display = 'none';
            }
        });
    });
});

// Simulate table sorting functionality
document.addEventListener('DOMContentLoaded', function() {
    const tableHeaders = document.querySelectorAll('.order-table th');
    
    tableHeaders.forEach(header => {
        header.addEventListener('click', function() {
            // Reset all sort icons
            document.querySelectorAll('.sort-icon').forEach(icon => {
                icon.textContent = '↓';
            });
            
            // Update clicked header's sort icon
            const sortIcon = this.querySelector('.sort-icon');
            sortIcon.textContent = sortIcon.textContent === '↓' ? '↑' : '↓';
            
            // In a real application, this would trigger a re-sort of the table data
            console.log(`Sorting by ${this.textContent.trim().replace('↓', '').replace('↑', '')}`);
        });
    });

});
function openAddAddressModal() {
    const modal = document.getElementById('addAddressModal');
    if (modal) {
        modal.classList.remove('opacity-0', 'invisible');
        modal.classList.add('opacity-100', 'visible');
        
        // Animate modal content
        const modalContent = modal.querySelector('div');
        modalContent.classList.remove('-translate-y-4');
        modalContent.classList.add('translate-y-0');
    }
}

function closeAddAddressModal() {
    document.getElementById('addAddressModal').classList.add('hidden');
}

