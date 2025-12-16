document.addEventListener('DOMContentLoaded', function() {
    // Mobile sidebar toggle functionality
    const sidebarTitle = document.querySelector('.sidebar-title');
    const sidebarNav = document.querySelector('.sidebar-nav');
    
    if (window.innerWidth < 768) {
        sidebarNav.style.display = 'none';
        
        sidebarTitle.addEventListener('click', function() {
            if (sidebarNav.style.display === 'none') {
                sidebarNav.style.display = 'block';
                sidebarTitle.classList.add('active');
            } else {
                sidebarNav.style.display = 'none';
                sidebarTitle.classList.remove('active');
            }
        });
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) {
            sidebarNav.style.display = 'block';
        } else {
            sidebarNav.style.display = 'none';
            sidebarTitle.classList.remove('active');
        }
    });
    
    // Form validation
    const saveBtn = document.querySelector('.save-btn');
    
    saveBtn.addEventListener('click', function() {
        // Get form values
        const username = document.getElementById('username').value;
        const fullname = document.getElementById('fullname').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const currentPassword = document.getElementById('current-password').value;
        const newPassword = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
        
        // Basic validation
        let isValid = true;
        let errorMessage = '';
        
        if (!username.trim()) {
            isValid = false;
            errorMessage += 'Username is required.\n';
        }
        
        if (!fullname.trim()) {
            isValid = false;
            errorMessage += 'Full name is required.\n';
        }
        
        if (!email.trim()) {
            isValid = false;
            errorMessage += 'Email is required.\n';
        } else if (!isValidEmail(email)) {
            isValid = false;
            errorMessage += 'Please enter a valid email address.\n';
        }
        
        if (!phone.trim()) {
            isValid = false;
            errorMessage += 'Phone number is required.\n';
        }
        
        // Password validation - only if user is trying to change password
        if (newPassword || confirmPassword || currentPassword) {
            if (!currentPassword) {
                isValid = false;
                errorMessage += 'Current password is required to change password.\n';
            }
            
            if (newPassword !== confirmPassword) {
                isValid = false;
                errorMessage += 'New password and confirmation do not match.\n';
            }
            
            if (newPassword && newPassword.length < 8) {
                isValid = false;
                errorMessage += 'Password must be at least 8 characters long.\n';
            }
        }
        
        if (isValid) {
            // Show success message
            showNotification('Profile updated successfully!', 'success');
            
            // In a real application, you would send this data to a server
            console.log('Form submitted with:', {
                username,
                fullname,
                gender: document.getElementById('gender').value,
                birthdate: document.getElementById('birthdate').value,
                phone,
                email,
                passwordChanged: !!newPassword
            });
            
            // Clear password fields
            document.getElementById('current-password').value = '';
            document.getElementById('new-password').value = '';
            document.getElementById('confirm-password').value = '';
        } else {
            // Show error message
            showNotification(errorMessage, 'error');
        }
    });
    
    // Date picker functionality for birthdate
    const birthdateInput = document.getElementById('birthdate');
    const calendarBtn = document.querySelector('.calendar-btn');
    
    calendarBtn.addEventListener('click', function() {
        // In a real application, you would show a date picker here
        // For this example, we'll just toggle a class to show it's clicked
        this.classList.add('active');
        
        // Remove active class after a short delay
        setTimeout(() => {
            this.classList.remove('active');
        }, 300);
        
        // Alert for demonstration purposes
        alert('Date picker would open here in a real application.');
    });
    
    // Format birthdate input to enforce DD/MM/YYYY format
    birthdateInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length > 8) {
            value = value.substring(0, 8);
        }
        
        // Format as DD/MM/YYYY
        if (value.length > 4) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4) + '/' + value.substring(4);
        } else if (value.length > 2) {
            value = value.substring(0, 2) + '/' + value.substring(2);
        }
        
        e.target.value = value;
    });
});

// Helper function to validate email format
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Function to show notification
function showNotification(message, type) {
    // Check if notification already exists
    let notification = document.querySelector('.notification');
    
    if (notification) {
        document.body.removeChild(notification);
    }
    
    // Create notification element
    notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    
    // Style the notification
    notification.style.position = 'fixed';
    notification.style.bottom = '20px';
    notification.style.right = '20px';
    notification.style.padding = '15px 20px';
    notification.style.borderRadius = '4px';
    notification.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.2)';
    notification.style.zIndex = '1000';
    notification.style.maxWidth = '300px';
    notification.style.opacity = '0';
    notification.style.transform = 'translateY(20px)';
    notification.style.transition = 'opacity 0.3s, transform 0.3s';
    
    if (type === 'success') {
        notification.style.backgroundColor = '#4caf50';
        notification.style.color = 'white';
    } else {
        notification.style.backgroundColor = '#f44336';
        notification.style.color = 'white';
        notification.style.whiteSpace = 'pre-line';
    }
    
    // Add to document
    document.body.appendChild(notification);
    
    // Trigger animation
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateY(0)';
    }, 10);
    
    // Remove after 5 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(20px)';
        
        // Remove from DOM after animation completes
        setTimeout(() => {
            if (notification.parentNode) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 5000);
}