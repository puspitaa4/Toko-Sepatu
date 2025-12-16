// Image Gallery Functionality
function changeImage(element) {
    // Update main image
    document.getElementById('main-image').src = element.src;
    
    // Update active thumbnail
    const thumbnails = document.querySelectorAll('.thumbnail');
    thumbnails.forEach(thumb => {
        thumb.classList.remove('active');
    });
    element.parentElement.classList.add('active');
}

// Gallery Navigation
document.querySelector('.prev').addEventListener('click', function() {
    const thumbnails = document.querySelectorAll('.thumbnail');
    const activeIndex = Array.from(thumbnails).findIndex(thumb => thumb.classList.contains('active'));
    
    if (activeIndex > 0) {
        const prevThumb = thumbnails[activeIndex - 1].querySelector('img');
        changeImage(prevThumb);
    } else {
        const lastThumb = thumbnails[thumbnails.length - 1].querySelector('img');
        changeImage(lastThumb);
    }
});

document.querySelector('.next').addEventListener('click', function() {
    const thumbnails = document.querySelectorAll('.thumbnail');
    const activeIndex = Array.from(thumbnails).findIndex(thumb => thumb.classList.contains('active'));
    
    if (activeIndex < thumbnails.length - 1) {
        const nextThumb = thumbnails[activeIndex + 1].querySelector('img');
        changeImage(nextThumb);
    } else {
        const firstThumb = thumbnails[0].querySelector('img');
        changeImage(firstThumb);
    }
});

// Size Selection
const sizeButtons = document.querySelectorAll('.size-btn');
sizeButtons.forEach(button => {
    button.addEventListener('click', function() {
        sizeButtons.forEach(btn => btn.classList.remove('selected'));
        this.classList.add('selected');
    });
});

// Quantity Selector
const minusBtn = document.querySelector('.minus');
const plusBtn = document.querySelector('.plus');
const quantityInput = document.querySelector('.quantity-input');

minusBtn.addEventListener('click', function() {
    let value = parseInt(quantityInput.value);
    if (value > 1) {
        quantityInput.value = value - 1;
    }
});

plusBtn.addEventListener('click', function() {
    let value = parseInt(quantityInput.value);
    quantityInput.value = value + 1;
});

// Prevent non-numeric input
quantityInput.addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
    if (this.value === '' || parseInt(this.value) < 1) {
        this.value = 1;
    }
});

// Add to Cart Functionality
document.querySelector('.add-to-cart-btn').addEventListener('click', function() {
    const selectedSize = document.querySelector('.size-btn.selected');
    
    if (!selectedSize) {
        alert('Please select a size');
        return;
    }
    
    const productData = {
        name: 'Jordan Delata 2',
        price: 'RP 2.699.000',
        size: selectedSize.textContent,
        quantity: parseInt(quantityInput.value)
    };
    
    // In a real application, you would send this data to a cart service
    console.log('Added to cart:', productData);
    
    // Update cart badge
    const cartBadge = document.querySelector('.cart-badge');
    cartBadge.textContent = parseInt(cartBadge.textContent) + 1;
    
    // Show confirmation
    alert('Product added to cart!');
});

function toLogin(){
    window.location = "../login/login_form.php";
}