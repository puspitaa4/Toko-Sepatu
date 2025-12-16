<?php
require "back/profilAdmin.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile Interface</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h1 class="text-xl font-bold text-gray-800">Pengaturan Admin</h1>
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
                <a href="manageproduct.php" class="flex items-center px-6 py-3 text-gray-600 hover:bg-red-50">
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
                <a href="#" class="flex items-center px-6 py-3 text-white bg-red-600">
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
            <!-- Header -->
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-700 mb-6">
                <h1 class="text-2xl font-bold text-red-700 mb-2">Pengaturan Admin</h1>
                <p class="text-gray-600">Kelola informasi profil dan akun admin</p>
            </div>

            <!-- Profile Settings Form -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Profil</h3>
                </div>
                
                <div class="p-6">
                    <form action="" method="POST" class="space-y-6">
                        
                        <div class="">
                            <!-- Full Name -->
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($users['name']); ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>  
                            <br>                      
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($users['email']); ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>
                            <br>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telp.</label>
                                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($users['phone']); ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>
                        </div>
                        <br>
                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" name="save">
                                <i class="fas fa-save mr-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>