<?php
session_start();
require "../database/query.php";
$user_id = $_SESSION['user_id'];
$user = getUserById($user_id);
$users = $user->fetch_assoc();
$order = getOrderss($user_id);
   $orders = [];
    while($row = $order->fetch_assoc()) {
        // Konversi MEDIUMBLOB ke base64 untuk ditampilkan
        $imageData = base64_encode($row['gambar']);
        $imageSrc = 'data:image/jpeg;base64,' . $imageData; // Sesuaikan format jika bukan JPEG
        
        $orders[] = [
            'harga' => $row['harga'],
            'status' => $row['status'],
            'gambar' => $imageSrc,
            'invoice_kode' => $row['invoice_kode'],
            'size_label' => $row['size_label'],
            'order_id' => $row['order_id'],
            'id_produk' => $row['id_produk']
        ];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADIOS - User Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
    <div class="dashboard-container"> 
            <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <h1 class="sidebar-title">Dashboard</h1>
            <nav class="sidebar-nav">
                <ul>
                    <li class="active">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="pesanan.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                            Pesanan
                        </a>
                    </li>
                    <li>
                        <a href="profile.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            Profil
                        </a>
                    </li>
                    <li>
                        <a href="alamat.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            Alamat
                        </a>
                    </li>
                    <li class="logout">
                        <a href="../logout.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            Keluar
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Profile Section -->
            <section class="content-section">
                <div class="section-header">
                    <h2>Profil</h2>
                </div>
                <div class="profile-container">
                    <div class="profile-info">
                        <div class="profile-avatar">
                            <img src="https://as2.ftcdn.net/v2/jpg/05/89/93/27/1000_F_589932782_vQAEAZhHnq1QCGu5ikwrYaQD0Mmurm0N.jpg" alt="Profile Avatar">
                        </div>
                        <div class="profile-email">
                            <p><b><?php echo $users['name'] ?></b></p>
                            <p><?php echo $users['email'] ?></p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Order History Section -->
            <section class="content-section">
                <div class="section-header">
                    <h2>Riwayat Pesanan</h2>
                </div>
                <?php if(empty($orders)):?>
                <div class="px-6 py-8 text-center text-gray-500">
                    <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                    <p>Belum ada pesanan</p>
                </div>
                <?php else: ?>
                <div class="order-history-container">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Status Pesanan</th>
                                <th>Aksi</th>
                            </tr>
                        <tbody>
                            <?php foreach($orders as $o):?>
                            <tr>
                                <td><?php echo $o['invoice_kode'] ?></td>
                                <td><img src="<?php echo $o['gambar'];?>" class="w-24 h-24 object-cover rounded"></td>
                                <td>Rp. <?php echo number_format($o['harga'], 0, ',', '.'); ?></td>
                                <td><?php echo $o['status']; ?></td>
                                <?php if($o['status'] === 'pending'):?>
                                <td><button class="px-4 py-2 bg-red-600 rounded-md text-white hover:bg-red-300">Cancel</button></td>
                                <?php elseif($o['status'] === 'paid'):?>
                                <td></td>
                                <?php elseif($o['status'] === 'shipped'):?>
                                <td><button class="px-4 py-2 bg-green-600 rounded-md text-white hover:bg-green-300" onclick="window.location.href = 'updateCompleted.php?order_id=<?php echo $o['order_id'];?>'">Pesanan Selesai</button></td>
                                <?php elseif($o['status'] === 'completed'):?>
                                <td><button class="px-4 py-2 bg-blue-600 rounded-md text-white hover:bg-blue-300" onclick="window.location.href = 'ulasan.php?product_id=<?php echo $o['id_produk'];?>';">Beri Review</button></td>
                                <?php elseif($o['status'] === 'canceled'):?>
                                <td>Pesanan Dibatalkan</td>
                                <?php endif;?> 
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                    <div class="table-footer">
                        <a href="pesanan.php" class="complete-address">Lihat Selengkapnya</a>
                    </div>
                </div>
                <?php endif; ?>
            </section>
        </main>
    </div>
    <script src="dashboard.js"></script>
</body>
</html>