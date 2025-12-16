<?php
require "../database/query.php";
session_start();
$product = getProductWomen();
$brand = getBrand();
$kategori = getCategory();
   $products = [];
    while($row = $product->fetch_assoc()) {
        // Konversi MEDIUMBLOB ke base64 untuk ditampilkan
        $imageData = base64_encode($row['gambar_produk']);
        $imageSrc = 'data:image/jpeg;base64,' . $imageData; // Sesuaikan format jika bukan JPEG
        
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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADIOS - Shoe Store</title>
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
<body class="bg-gray-100">
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
                    <a href="fav.php">
                    <div class="cursor-pointer hover:text-gray-300 transition-colors">
                        <i class="far fa-heart text-lg"></i>
                    </div>
                    </a>
                    <div class="cursor-pointer hover:text-gray-300 transition-colors">
                        <?php 
                        if(isset($_SESSION['user_id'])){
                            echo "<a href='dashboard.html' class='text-white hover:text-gray-300'><i class='far fa-user text-lg'></i></a>";
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
                <li><a href="../index.php" class="text-black font-bold text-lg uppercase hover:text-adios-red transition-colors">HOME</a></li>
                <li><a href="men.php" class="text-black font-bold text-lg uppercase hover:text-adios-red transition-colors">MEN</a></li>
                <li><a href="#" class="text-black font-bold text-lg uppercase hover:text-adios-red transition-colors">WOMEN</a></li>
                <li><a href="unisex.php" class="text-black font-bold text-lg uppercase hover:text-adios-red transition-colors">UNISEX</a></li>
                <li><a href="newarrival.php" class="text-black font-bold text-lg uppercase hover:text-adios-red transition-colors">THE NEW ARRIVALS</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-5 py-5">
        
        <div class="flex gap-5">
            <!-- Sidebar Filters -->
            <aside class="w-64 bg-white p-5 rounded h-fit">
                <!-- Brands Filter -->
                <div class="mb-6">
                    <h3 class="text-base font-semibold mb-3 text-gray-800">Brands</h3>
                    <div class="space-y-2">
                        <?php foreach($brand as $b): ?>
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" class="brand-filter" value="<?php echo $b['name']; ?>">
                            <span><?php echo $b['name']; ?></span>
                        </label>
                        <?php endforeach;?>
                    </div>
                </div>
                
                <!-- Price Range Filter -->
                <div class="mb-6">
                    <h3 class="text-base font-semibold mb-3 text-gray-800">Price range</h3>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="price-range" class="price-filter" value="under-500k">
                            <span>Dibawah Rp. 500.000</span>
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="price-range" class="price-filter" value="500k-1m">
                            <span>Rp. 500.001 - Rp. 1.000.000</span>
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="price-range" class="price-filter" value="1m-1.5m">
                            <span>Rp. 1.000.001 - Rp. 1.500.000</span>
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="price-range" class="price-filter" value="above-1.5m">
                            <span>Diatas Rp. 1.500.000</span>
                        </label>
                    </div>
                </div>
                
                <!-- Categories Filter -->
                <div class="mb-6">
                    <h3 class="text-base font-semibold mb-3 text-gray-800">Categories</h3>
                    <div class="space-y-2">
                        <?php foreach($kategori as $k):?> 
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" class="category-filter" value="<?php echo $k['name'] ?>">
                            <span>sepatu <?php echo $k['name'] ?></span>
                        </label>
                        <?php endforeach;?>
                    </div>
                </div>
                
                <button onclick="applyFilters()" class="w-full bg-red-700 hover:bg-red-800 text-white py-2 px-4 rounded text-sm font-medium transition-colors">
                    Filter
                </button>
            </aside>
            
            <!-- Product Grid -->
            <div class="flex-1">
                <div id="product-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <!-- Products will be populated by JavaScript -->
                </div>
                <div id="no-products" class="hidden text-center py-12">
                    <p class="text-gray-500">Tidak ada produk yang sesuai dengan filter Anda.</p>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="mt-10 py-5 text-center">
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <p class="text-sm text-gray-600">Don't missout on once-in-a-while-deals:</p>
            <div class="flex gap-4">
                <a href="#" class="text-red-800 hover:text-red-900 text-lg">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="text-red-800 hover:text-red-900 text-lg">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="text-red-800 hover:text-red-900 text-lg">
                    <i class="fab fa-pinterest"></i>
                </a>
            </div>
        </div>
    </footer>

    <script>
        // Product data
        const products = [<?php foreach($products as $p):?>

            ,{
                id: <?php echo $p['id_produk']; ?>,
                name: "<?php echo $p['nama_produk']; ?>",
                price: <?php echo $p['harga']; ?>,
                image: "<?php echo $p['gambar_produk']; ?>",
                brand: "<?php echo $p['merk']; ?>",
                category: "<?php echo $p['kategori']; ?>"
            }
        <?php endforeach;?>];

        // Format price to Indonesian Rupiah
        function formatPrice(price) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(price);
        }

        // Render products
        function renderProducts(productsToRender) {
            const productGrid = document.getElementById('product-grid');
            const noProducts = document.getElementById('no-products');
            
            if (productsToRender.length === 0) {
                productGrid.innerHTML = '';
                noProducts.classList.remove('hidden');
                return;
            }
            
            noProducts.classList.add('hidden');
            
            productGrid.innerHTML = productsToRender.map(product => `
                <a href="productSession.php?id=${product.id}">
                <div class="bg-white rounded overflow-hidden hover:shadow-lg transition-shadow transform hover:-translate-y-1">
                    <div class="h-48 bg-gray-100 flex items-center justify-center">
                        <img src="${product.image}" alt="${product.name}" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="p-4">
                        <h3 class="text-base font-semibold mb-2 text-gray-800">${product.name}</h3>
                        <p class="text-sm font-bold text-gray-800">${formatPrice(product.price)}</p>
                    </div>
                </div>
                </a>
            `).join('');
        }

        // Filter products
        function filterProducts() {
            const selectedBrands = Array.from(document.querySelectorAll('.brand-filter:checked')).map(cb => cb.value);
            const selectedCategories = Array.from(document.querySelectorAll('.category-filter:checked')).map(cb => cb.value);
            const selectedPriceRange = document.querySelector('.price-filter:checked')?.value;

            return products.filter(product => {
                // Brand filter
                if (selectedBrands.length > 0 && !selectedBrands.includes(product.brand)) {
                    return false;
                }

                // Category filter
                if (selectedCategories.length > 0 && !selectedCategories.includes(product.category)) {
                    return false;
                }

                // Price range filter
                if (selectedPriceRange) {
                    switch (selectedPriceRange) {
                        case 'under-500k':
                            return product.price < 500000;
                        case '500k-1m':
                            return product.price >= 500001 && product.price <= 1000000;
                        case '1m-1.5m':
                            return product.price >= 1000001 && product.price <= 1500000;
                        case 'above-1.5m':
                            return product.price > 1500000;
                        default:
                            return true;
                    }
                }

                return true;
            });
        }

        // Apply filters
        function applyFilters() {
            const filteredProducts = filterProducts();
            renderProducts(filteredProducts);
        }

        // Add event listeners for real-time filtering
        document.addEventListener('DOMContentLoaded', function() {
            // Initial render
            renderProducts(products);

            // Add event listeners to all filter inputs
            document.querySelectorAll('.brand-filter, .category-filter, .price-filter').forEach(input => {
                input.addEventListener('change', applyFilters);
            });
        });
        function toLogin(){
            window.location.href = "login/login_form.php"
        }
    </script>
</body>
</html>
