<?php
require "back/editproduk.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management Interface</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h1 class="text-xl font-bold text-gray-800">Manajemen Produk</h1>
            </div>
            <nav class="mt-6">
                <a href="dashboard.php" class="flex items-center px-6 py-3 text-gray-600 hover:bg-red-50">
                    <i class="fas fa-th-large mr-3"></i>
                    Dashboard
                </a>
                <a href="manageuser.php" class="flex items-center px-6 py-3 text-gray-600 hover:bg-red-50">
                    <i class="fas fa-users mr-3"></i>
                    Manajemen Pengguna
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-white bg-red-600">
                    <i class="fas fa-box mr-3"></i>
                    Manajemen Produk
                </a>
                <a href="managepesanan.php" class="flex items-center px-6 py-3 text-gray-600 hover:bg-red-50">
                    <i class="fas fa-shopping-cart mr-3"></i>
                    Manajemen Pesanan
                </a>
                <a href="laporanpenjualan.php" class="flex items-center px-6 py-3 text-gray-600 hover:bg-red-50">
                    <i class="fas fa-clipboard mr-3"></i>
                    Laporan Penjualan
                </a>
                <a href="pengaturanadmin.php" class="flex items-center px-6 py-3 text-gray-600 hover:bg-red-50">
                    <i class="fas fa-user mr-3"></i>
                    Profile Admin
                </a>
                <a href="../logout.php" class="flex items-center px-6 py-3 text-gray-600 hover:bg-red-50">
                    <i class="fas fa-sign-out mr-3"></i>
                    Logout
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-2xl font-bold text-red-700 mb-2">Manajemen Produk</h1>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <form action="" method="POST" class="space-y-6">
                        <!-- Product Name -->
                        <div>
                            <label for="product_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Produk
                            </label>
                            <input type="text" id="product_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" name="nama" required value="<?php echo $products['name']; ?>">
                        </div>

                        <div>
                            <label for="product_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea name="deskripsi" id="product_name" class="w-full h-32 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" name="nama" required><?php echo $products['description']; ?></textarea>
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                Harga (Rp)
                            </label>
                            <input type="number" name="price" id="price" min="0" step="1000" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" required value="<?php echo $products['price']; ?>">
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-between space-x-4">
                            <button type="button" class="px-6 py-2 bg-gray-300 rounded-md hover:bg-gray-400" onclick="window.location.href = 'manageproduct.php'">
                                Kembali
                            </button>
                            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" name="update">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>