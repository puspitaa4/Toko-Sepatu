<?php
session_start();
require "../database/query.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login_form.php");
    exit;
}
$user_id = $_SESSION['user_id'];

$wishlist = getWishlists($user_id);

$products = [];
while($row = $wishlist->fetch_assoc()) {
    $imageData = base64_encode($row['gambar']);
    $imageSrc = 'data:image/jpeg;base64,' . $imageData; 
        
    $products[] = [
        'id_user' => $row['id_user'],
        'id_produk' => $row['id_produk'],
        'nama_produk' => $row['nama_produk'],
        'harga' => $row['harga'],
        'stok' => $row['stok'],
        'gambar' => $imageSrc
    ];
}

$is_stocked = false;
if (isset($products[0]['stok']) && $products[0]['stok'] > 0){
    $is_stocked = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADIOS - Keranjang Saya</title>
    <link rel="stylesheet" href="keranjang.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
                    <div class="relative cursor-pointer hover:text-gray-300 transition-colors">
                        <i class="fas fa-shopping-cart text-lg"></i>
                    </div>
                    <a href="#">
                    <div class="cursor-pointer hover:text-gray-300 transition-colors">
                        <i class="far fa-heart text-lg"></i>
                    </div>
                    </a>
                    <div class="cursor-pointer hover:text-gray-300 transition-colors">
                        <a href='dashboard.html' class='text-white hover:text-gray-300'><i class='far fa-user text-lg'></i></a>
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

    <main>
        <div class="cart-header">
            <h1>Wishlist</h1>
        </div>

        <div class="cart-items">
            <?php if(empty($products)):?>
            <p class="justify-content-center">No Items in Wishlist</p>
            <?php else:?>
            <?php foreach($products as $p): ?>
            <!-- Item 1 -->
            <a href="productSession.php?id=<?php echo $p['id_produk'] ?>">
            <div class="cart-item">
                <div class="item-details">
                    <div class="product-image">
                        <img src="<?php echo $p['gambar'];?>" alt="<?php echo $p['nama_produk']; ?>">
                    </div>
                    <div class="product-info">
                        <h3><?php echo $p['nama_produk'];?></h3>
                        <p class="price">Rp. <?php echo number_format($p['harga'], 0, ',', '.'); ?></p>
                        <p class="stock">Stock status: <span class="in-stock"><?php echo $is_stocked ? "IN STOCK" : "OUT OF STOCK" ?></span></p>
                    </div>
                </div>
            </div>
            </a>
            <?php endforeach;?>
            <?php endif;?>
        </div>
    </main>

    <script src="keranjang.js"></script>
</body>
</html>