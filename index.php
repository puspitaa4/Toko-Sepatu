<?php
session_Start();
require "database/conn.php";
require "database/query.php";
$product = getProductNew();
$product2 = getProductNewest();
$products2 = $product2->fetch_assoc();
$imageData2 = base64_encode($products2['gambar_produk']);
$imageSrc2 = 'data:image/jpeg;base64,' . $imageData2;

$products = [];
while($row = $product->fetch_assoc()) {

    $imageData = base64_encode($row['gambar_produk']);
    $imageSrc = 'data:image/jpeg;base64,' . $imageData;
        
    $products[] = [
        'id_produk' => $row['id_produk'],
        'nama_produk' => $row['nama_produk'],
        'harga' => $row['harga'],
        'stok' => $row['stok'],
        'gambar_produk' => $imageSrc,
        'kategori' => $row['kategori'],
        'merk' => $row['merk']
    ];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADIOS - Sneaker Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
<body class="bg-adios-bg">
    <!-- Top Navigation Bar -->
    <header class="bg-adios-red text-white py-4">
        <div class="max-w-6xl mx-auto px-5">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
                <div class="text-2xl font-bold tracking-wide">ADIOS</div>
                
                <div class="flex-1 max-w-lg w-full">
                    <form action="user/search.php" method="get">
                        <div class="flex">
                            <input type="text" placeholder="Search for anything..." name="q" 
                                class="flex-1 px-4 py-2 text-gray-800 rounded-l border-none outline-none focus:ring-2 focus:ring-red-300">
                            <button class="bg-white text-gray-600 px-4 py-2 rounded-r hover:bg-gray-100 transition-colors" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="flex items-center gap-5">
                    <a href="user/keranjang.php">
                    <div class="relative cursor-pointer hover:text-gray-300 transition-colors">
                        <i class="fas fa-shopping-cart text-lg"></i>
                    </div>
                    </a>
                    <a href="user/fav.php">
                    <div class="cursor-pointer hover:text-gray-300 transition-colors">
                        <i class="far fa-heart text-lg"></i>
                    </div>
                    </a>
                    <div class="cursor-pointer hover:text-gray-300 transition-colors">
                        <?php 
                        if(isset($_SESSION['user_id'])){
                            echo "<a href='user/dashboard.php' class='text-white hover:text-gray-300'><i class='far fa-user text-lg'></i></a>";
                        }else{
                            echo "<button class='bg-adios-dark-red text-white px-4 py-2 rounded text-sm font-medium hover:bg-red-900 transition-colors' onclick='toLogin()'>Login/Register</button>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Category Navigation -->
    <nav class="bg-adios-bg py-4 border-b border-gray-300">
        <div class="max-w-6xl mx-auto px-5">
            <ul class="flex flex-wrap justify-center gap-6 lg:gap-12">
                <li><a href="#" class="text-black font-bold text-lg uppercase hover:text-adios-red transition-colors">HOME</a></li>
                <li><a href="user/men.php" class="text-black font-bold text-lg uppercase hover:text-adios-red transition-colors">MEN</a></li>
                <li><a href="user/women.php" class="text-black font-bold text-lg uppercase hover:text-adios-red transition-colors">WOMEN</a></li>
                <li><a href="user/unisex.php" class="text-black font-bold text-lg uppercase hover:text-adios-red transition-colors">UNISEX</a></li>
                <li><a href="user/newarrival.php" class="text-black font-bold text-lg uppercase hover:text-adios-red transition-colors">THE NEW ARRIVALS</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-5">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                <div class="max-w-md text-center lg:text-left">
                    <h1 class="text-5xl lg:text-6xl font-bold leading-tight mb-5">
                        <br><?php echo $products2['nama_produk']; ?>
                    </h1>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        Sepatu <?php echo $products2['kategori']; ?>
                    </p>
                    <div class="text-2xl font-bold mb-5">Rp. <?php echo number_format($products2['harga'], 0, ',', '.'); ?></div>
                    <button class="bg-adios-pink text-white px-6 py-3 rounded font-bold hover:bg-pink-600 transition-colors" onclick="window.location.href='user/productSession.php?id=<?php echo $products2['id_produk'];?>'">
                        See Detail
                    </button>
                </div>
                <div class="flex-1 max-w-lg">
                    <div class="bg-gray-100 rounded-lg p-8">
                        <img src="<?php echo $imageSrc2; ?>" alt="<?php echo $products2['nama_produk']; ?>" class="w-full h-auto">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- New Arrivals Section -->
    <section class="py-10 pb-20">
        <div class="max-w-6xl mx-auto px-5">
            <h2 class="text-2xl font-semibold mb-8">All the new arrivals</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                <?php foreach($products as $p):?>
                <a href="user/productSession.php?id=<?php echo $p['id_produk']; ?>">
                    <div class="bg-white rounded-lg overflow-hidden hover:transform hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                        <div class="bg-gray-100 p-5 flex justify-center items-center h-60">
                            <img src="<?php echo $p['gambar_produk']; ?>" alt="<?php echo $p['nama_produk']; ?>" class="w-full h-full object-cover rounded">
                        </div>
                        <div class="p-4 h-50">
                            <h3 class="font-semibold text-base mb-2"><?php echo $p['nama_produk']; ?></h3>
                            <p class="text-base font-bold">Rp. <?php echo number_format($p['harga'], 0, ',', '.'); ?></p>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            
            <div class="flex justify-center mt-8">
                <button class="bg-red-600 text-white px-6 py-3 rounded font-bold hover:bg-red-700 transition-colors" onclick="window.location.href='newarrival.html'">
                    View More
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="mt-10 py-5 text-center">
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <p class="text-sm text-gray-600">Don't missout on once-in-a-while-deals:</p>
            <div class="flex gap-4">
                <a href="#" class="text-red-800 hover:text-red-900 text-lg transition-colors">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="text-red-800 hover:text-red-900 text-lg transition-colors">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="text-red-800 hover:text-red-900 text-lg transition-colors">
                    <i class="fab fa-pinterest"></i>
                </a>
            </div>
        </div>
    </footer>

    <script>
        function toLogin(){
            window.location.href = "login/login_form.php"
        }
    </script>
</body>
</html>
