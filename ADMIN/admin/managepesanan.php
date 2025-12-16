<?php
session_start();
require "../database/query.php";
$user_id = $_SESSION['user_id'];
$order = getOrderssss();
$orders = [];
while($row = $order->fetch_assoc()) {
        
    $orders[] = [
        'name' => $row['name'],
        'status' => $row['status'],
        'nama' => $row['nama'],
        'invoice_kode' => $row['invoice_kode'],
        'tanggal_pemesanan' => $row['tanggal_pemesanan'],
        'order_id' => $row['order_id']
    ];
}



?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management Interface</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h1 class="text-xl font-bold text-gray-800">Manajemen Pesanan</h1>
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
                <a href="#" class="flex items-center px-6 py-3 text-white bg-red-600">
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
            <!-- Header -->
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-700 mb-6">
                <h1 class="text-2xl font-bold text-red-700 mb-2">Manajemen Pesanan</h1>
                <p class="text-gray-600">Kelola status pesanan dan persetujuan admin</p>
            </div>

            <!-- Orders Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Pesanan</h3>
                </div>

                <?php if (!empty($orders)): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. pesanan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($orders as $order): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?php echo $order['invoice_kode']; ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?php echo $order['name']; ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php echo $order['nama']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?php echo $order['status']; ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo date('d/m/Y', strtotime($order['tanggal_pemesanan'])); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php if($order['status'] === 'paid'): ?>
                                        <button class="px-4 py-2 bg-green-600 rounded-md text-white hover:bg-green-300" onclick="window.location.href = 'back/updateshipped.php?id=<?php echo $order['order_id'];?>'">Kirim Pesanan</button>
                                        <?php elseif($order['status'] === 'canceled'): ?>
                                        Pesanan dibatalkan.
                                        <?php endif;?>    
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                        <p>Belum ada pesanan</p>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function updateOrderStatus(orderId, newStatus, selectElement) {
            // Show loading state
            selectElement.disabled = true;
            
            // Create form data
            const formData = new FormData();
            formData.append('order_id', orderId);
            formData.append('status', newStatus);
            
            // Send AJAX request
            fetch('update_order_status.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the select styling based on new status
                    selectElement.className = `status-select ${newStatus === 'approved' ? 'status-approved' : 'status-process'}`;
                    selectElement.setAttribute('data-current-status', newStatus);
                    
                    // Show success message
                    showMessage('Status pesanan berhasil diperbarui!', 'success');
                    
                    // Update statistics (optional - reload page or update via AJAX)
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                // Revert selection on error
                selectElement.value = selectElement.getAttribute('data-current-status');
                showMessage(error.message || 'Gagal memperbarui status pesanan!', 'error');
            })
            .finally(() => {
                selectElement.disabled = false;
            });
        }

        function showMessage(message, type) {
            // Create message element
            const messageDiv = document.createElement('div');
            messageDiv.className = `fixed top-4 right-4 px-4 py-3 rounded z-50 ${
                type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'
            }`;
            messageDiv.textContent = message;
            
            // Add to page
            document.body.appendChild(messageDiv);
            
            // Remove after 3 seconds
            setTimeout(() => {
                messageDiv.remove();
            }, 3000);
        }
    </script>
</body>
</html>