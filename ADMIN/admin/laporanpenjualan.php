<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report Interface</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h1 class="text-xl font-bold text-gray-800">Laporan Penjualan</h1>
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
                <a href="#" class="flex items-center px-6 py-3 text-white bg-red-600">
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
        <main class="flex-1 p-6">
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-700 mb-6">
                <h2 class="text-2xl font-bold text-red-700 mb-2">Laporan Penjualan</h2>
                <p class="text-gray-600">Laporan Penjualan Setiap Bulan Selama 1 Tahun.</p>
            </div>

                    <!-- Form untuk input tahun -->
            <form method="GET" action="" class="mb-8 flex justify-center">
                <div class="flex items-center space-x-4">
                    <label for="tahun" class="text-lg">Tahun:</label>
                    <input type="number" id="tahun" name="tahun" value="<?php echo isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); ?>" 
                        class="border rounded-lg p-2 w-24" min="2000" max="<?php echo date('Y'); ?>" required>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Tampilkan</button>
                </div>
            </form>

            <?php
            require "../database/conn.php";

            if (!$conn) {
                echo "<div class='text-red-500 text-center'>Koneksi database gagal: " . mysqli_connect_error() . "</div>";
                exit;
            }

            $tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');

            $query = "CALL spLaporanPenjualanBulanan($tahun)";
            $result = mysqli_multi_query($conn, $query);

            if ($result) {
                $monthly_data = mysqli_store_result($conn);
                $chart_labels = [];
                $chart_pendapatan = [];

                if ($monthly_data && mysqli_num_rows($monthly_data) > 0){
            ?>

            <div class="bg-white p-6 rounded-lg shadow">
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-red-700 text-white">
                            <tr>
                                <th class="px-4 py-2 text-left">Bulan</th>
                                <th class="px-4 py-2 text-left">Nama Bulan</th>
                                <th class="px-4 py-2 text-left">Total Order</th>
                                <th class="px-4 py-2 text-left">Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <?php
                            while ($row = mysqli_fetch_assoc($monthly_data)) {
                                $chart_labels[] = $row['nama_bulan'];
                                $chart_pendapatan[] = str_replace(',', '', $row['total_pendapatan']); // Hapus koma untuk chart
                            ?>
                                <tr>
                                    <td class="px-4 py-2"><?php echo $row['bulan']; ?></td>
                                    <td class="px-4 py-2"><?php echo $row['nama_bulan']; ?></td>
                                    <td class="px-4 py-2"><?php echo $row['total_order']; ?></td>
                                    <td class="px-4 py-2">Rp <?php echo $row['total_pendapatan']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Chart Pendapatan Bulanan -->
            <div class="bg-white p-6 rounded-lg shadow mt-6">
                <h2 class="text-xl font-semibold mb-4">Grafik Pendapatan Bulanan <?php echo $tahun; ?></h2>
                <canvas id="salesChart" height="100"></canvas>
            </div>

            <script>
                const ctx = document.getElementById('salesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($chart_labels); ?>,
                        datasets: [{
                            label: 'Total Pendapatan (Rp)',
                            data: <?php echo json_encode($chart_pendapatan); ?>,
                            backgroundColor: 'rgba(220, 38, 38, 0.5)',
                            borderColor: 'rgba(220, 38, 38, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: { display: true, position: 'top' }
                        }
                    }
                });
            </script>
            <?php
            }
            }
            ?> 
        </main>
    </div>
</body>
</html>