<?php
session_Start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login/login_form.php");
    exit;
}
require "../database/query.php";
$userId = $_SESSION['user_id'];
if(isset($_SESSION['id'])){
    $productId = $_SESSION['id'];
    $image = getAllProductImages($productId);
    $product = getProductDetail($productId);
    $products = $product->fetch_Assoc();
    $size = getShoeSize($productId);
    function blobToBase64($blob, $imageType = 'image/jpeg') {
        if ($blob) {
            return 'data:' . $imageType . ';base64,' . base64_encode($blob);
        }
    }
    $wishlist = getWishlist($productId, $userId);
    if($wishlist->num_rows > 0){
        $wishlists = $wishlist->fetch_assoc();
        $is_wishlist = $wishlists['count'] > 0;
    }else{
        $is_wishlist = false;
    }
}
 
if(isset($_POST['add'])){
    $productsize = $_POST['size'];
    $user = $_SESSION['user_id'];

    $cart = getCart($user);
    $carts = $cart->fetch_assoc();
    $cartId = 0;
    if(empty($productsize)){
        echo "<script>alert('Size Tidak Boleh Kosong!')</script>";
    }else{
        if($carts){
            $cartId = $carts['id'];
        }else{
            $addcart = addCart($user);
            $cartId = $addcart->lastInsertId();
        }
        addCartItems($cartId, $productsize);
        

        header("Location: info.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADIOS - Detail Product</title>
    <link rel="stylesheet" href="info.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'adios-red': '#a01c1c',
                        'adios-dark-red': '#8a3333',
                        'adios-bg': '#f5f5fa',
                        'adios-pink': '#e91e63'
                    }
                }
            }
        }
    </script>
</head>
<body>
    <!-- Header -->
    <header class="bg-adios-red text-white py-4">
        <div class="max-w-6xl mx-auto px-5">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
                <div class="text-2xl font-bold tracking-wide">ADIOS</div>
                
                <div class="flex-1 max-w-lg w-full">
                    <div class="flex">
                        <input type="text" placeholder="Search for anything..." 
                               class="flex-1 px-4 py-2 text-gray-800 rounded-l border-none outline-none focus:ring-2 focus:ring-red-300">
                        <button class="bg-white text-gray-600 px-4 py-2 rounded-r hover:bg-gray-100 transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                
                <div class="flex items-center gap-5">
                    <a href="keranjang.php">
                    <div class="relative cursor-pointer hover:text-gray-300 transition-colors">
                        <i class="fas fa-shopping-cart text-lg"></i>
                    </div>
                    </a>
                    <a href="fav.php">
                    <div class="cursor-pointer hover:text-gray-300 transition-colors">
                        <i class="far fa-heart text-lg"></i>
                    </div>
                    </a>
                    <div class="cursor-pointer hover:text-gray-300 transition-colors">
                        <a href='#' class='text-white hover:text-gray-300'><i class='far fa-user text-lg'></i></a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Category Navigation -->
    <nav class="bg-adios-bg py-4 border-b border-gray-300">
        <div class="max-w-6xl mx-auto px-5">
            <ul class="flex flex-wrap justify-center gap-6 lg:gap-12">
                <li><a href="../index.php" class="text-black font-bold text-lg uppercase hover:text-adios-red transition-colors">HOME</a></li>
                <li><a href="men.php" class="text-black font-bold text-lg uppercase hover:text-adios-red transition-colors">MEN</a></li>
                <li><a href="women.php" class="text-black font-bold text-lg uppercase hover:text-adios-red transition-colors">WOMEN</a></li>
                <li><a href="unisex.php" class="text-black font-bold text-lg uppercase hover:text-adios-red transition-colors">UNISEX</a></li>
                <li><a href="newarrival.php" class="text-black font-bold text-lg uppercase hover:text-adios-red transition-colors">THE NEW ARRIVALS</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="product-container">
            <!-- Product Gallery -->
            <div class="product-gallery">
                <div class="main-image-container">
                    <button class="gallery-nav prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </button>
                    <img class="main-image" id="main-image" src="<?php echo blobToBase64($image[0]['image'], $image[0]['image_type']); ?>" alt="<?php echo $products['nama_produk']; ?>">
                    <button class="gallery-nav next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                </div>
                
                <div class="thumbnails">
                    <?php foreach ($image as $index => $images): ?>
                    <div class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>">
                        <img src="<?php echo blobToBase64($images['image'], $images['image_type']); ?>" 
                             alt="<?php echo htmlspecialchars($products['nama_produk']); ?>" 
                             onclick="changeImage(this, <?php echo $index; ?>)">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Product Details -->
            <div class="product-details">
                <div class="product-header">
                    <h1><?php echo $products['nama_produk'];?></h1>
                    <div class="product-favorite">
                        <a href="<?php echo $is_wishlist ? 'delete_wishlist.php' : 'add_wishlist.php'; ?>?id=<?php echo $products['product_id']?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="<?php echo $is_wishlist ? '#9e1a1a' : '#ffff'; ?>" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="price">
                    <p>Rp. <?php echo number_format($products['harga'], 0, ',', '.'); ?></p>
                </div>
                
                <div class="product-description">
                    <p><?php echo $products['deskripsi']; ?></p>
                </div>

                <form action="" method="POST">
                    <div class="size-selector">
                        <h3>Select size</h3>
                        <div class="size-grid">
                            <?php foreach($size as $s): ?>
                            <button type="button" class="size-btn" data-size="<?php echo $s['id'] ?>"><?php echo $s['size'] ?></button>
                            <?php endforeach;?>
                            <input type="hidden" name="size" id="selected-size" required>
                        </div>
                    </div>
                    <div class="quantity-cart">
                        <button type="submit" name="add" class="add-to-cart-btn h-12">Add to cart</button>
                    </div>
                    <div class="quantity-cartt">
                        <button type="button" class="add-to-cart-btnn h-12" onclick="window.location.href = 'review.php'">Review</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
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


                // JavaScript untuk size selection
        document.addEventListener('DOMContentLoaded', function() {
            const sizeButtons = document.querySelectorAll('.size-btn');
            const selectedSizeInput = document.getElementById('selected-size');
            
            sizeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove selected class from all buttons
                    sizeButtons.forEach(btn => btn.classList.remove('selected'));
                    
                    // Add selected class to clicked button
                    this.classList.add('selected');
                    
                    // Set value ke hidden input
                    selectedSizeInput.value = this.dataset.size;
                });
            });
            
            // Validasi sebelum submit
            document.querySelector('.add-to-cart-form').addEventListener('submit', function(e) {
                if (!selectedSizeInput.value) {
                    e.preventDefault();
                    alert('Please select a size');
                }
            });
        });

        function toLogin(){
            window.location = "../login/login_form.php";
        }
    </script>
</body>
</html>