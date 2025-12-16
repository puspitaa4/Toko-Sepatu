<?php
session_start();
require "../database/query.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    session_destroy();
    header("Location: ../login/login_form.php");
    exit(); // Wajib ada!
}

$view = countUserProduct();
$views = $view->fetch_assoc();
$order = viewDashboard();
$orders = $order->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Interface</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h1 class="text-xl font-bold text-gray-800">Dashboard</h1>
            </div>
            <nav class="mt-6">
                <a href="#" class="flex items-center px-6 py-3 text-white bg-red-600">
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
        <div class="flex-1 p-6">
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-700 mb-6">
                <h1 class="text-2xl font-bold text-red-700 mb-2">Dashboard</h1>
                <p class="text-gray-600">Welcome to your admin dashboard</p>
            </div>

            <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-4 mb-6">
                <div class="bg-gradient-to-r from-red-700 to-red-800 text-white p-6 rounded-lg shadow transform transition hover:scale-105">
                    <span class="block text-3xl font-bold" id="users-count"></span>
                    <span class="text-sm font-medium">Total Users</span>
                </div>
                <div class="bg-gradient-to-r from-red-700 to-red-800 text-white p-6 rounded-lg shadow transform transition hover:scale-105">
                    <span class="block text-3xl font-bold" id="products-count"></span>
                    <span class="text-sm font-medium">Products</span>
                </div>
                <div class="bg-gradient-to-r from-red-700 to-red-800 text-white p-6 rounded-lg shadow transform transition hover:scale-105">
                    <span class="block text-3xl font-bold" id="orders-count"></span>
                    <span class="text-sm font-medium">Orders Today</span>
                </div>
                <div class="bg-gradient-to-r from-red-700 to-red-800 text-white p-6 rounded-lg shadow transform transition hover:scale-105">
                    <span class="block text-3xl font-bold" id="revenue-count">$0</span>
                    <span class="text-sm font-medium">Revenue</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function animateCounter(element, target, isRevenue = false) {
            let current = 0;
            const increment = target / 100;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.textContent = isRevenue ? 'Rp. ' + Math.floor(current).toLocaleString() : Math.floor(current).toLocaleString();
            }, 20);
        }

        document.addEventListener('DOMContentLoaded', function () {
            animateCounter(document.getElementById('users-count'), <?php echo $views['total_user'];?>);
            animateCounter(document.getElementById('products-count'), <?php echo $views['total_produk'];?>);
            animateCounter(document.getElementById('orders-count'), <?php echo $orders['total_order'] ?? 0;?>);
            animateCounter(document.getElementById('revenue-count'), <?php echo $orders['total_pendapatan'] ?? 0;?>, true);
        });
    </script>
</body>
</html>