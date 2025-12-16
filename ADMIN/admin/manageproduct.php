<?php
include "back/manageproduk.php";
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
                    <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                        
                        <!-- Product Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Gambar Produk 1
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                <input type="file" name="product_image1" id="product_image1" accept="image/*" class="hidden" required>
                                <label for="product_image1" class="cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-600">Klik untuk upload gambar</p>
                                </label>
                                <div id="image_preview1" class="mt-4 hidden">
                                    <img id="preview_img1" src="/placeholder.svg" alt="Preview" class="max-w-xs mx-auto rounded-lg">
                                </div>
                            </div>
                            <br>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Gambar Produk 2
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                <input type="file" name="product_image2" id="product_image2" accept="image/*" class="hidden" required>
                                <label for="product_image2" class="cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-600">Klik untuk upload gambar</p>
                                </label>
                                <div id="image_preview2" class="mt-4 hidden">
                                    <img id="preview_img2" src="/placeholder.svg" alt="Preview" class="max-w-xs mx-auto rounded-lg">
                                </div>
                            </div>
                            <br>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Gambar Produk 3
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                <input type="file" name="product_image3" id="product_image3" accept="image/*" class="hidden" required>
                                <label for="product_image3" class="cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-600">Klik untuk upload gambar</p>
                                </label>
                                <div id="image_preview3" class="mt-4 hidden">
                                    <img id="preview_img3" src="/placeholder.svg" alt="Preview" class="max-w-xs mx-auto rounded-lg">
                                </div>
                            </div>
                            <br>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Gambar Produk 4
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                <input type="file" name="product_image4" id="product_image4" accept="image/*" class="hidden" required>
                                <label for="product_image4" class="cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-600">Klik untuk upload gambar</p>
                                </label>
                                <div id="image_preview4" class="mt-4 hidden">
                                    <img id="preview_img4" src="/placeholder.svg" alt="Preview" class="max-w-xs mx-auto rounded-lg">
                                </div>
                            </div>
                        </div>

                        <!-- Shoe Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori Sepatu
                            </label>
                            <select name="category" id="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($kategori as $k):?>
                                    <option value="<?php echo $k['id']?>"><?php echo $k['name']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>

                        <!-- Shoe Brand -->
                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">
                                Merk Sepatu
                            </label>
                            <select name="brand" id="brand" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" required>
                                <option value="">Pilih Merk</option>
                                <?php foreach($merk as $m):?>
                                    <option value="<?php echo $m['id']?>"><?php echo $m['name']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                                Gender
                            </label>
                            <select name="gender" id="gender" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" required>
                                <option value="">Pilih Gender</option>
                                <?php foreach($gender as $g):?>
                                    <option value="<?php echo $g['id']?>"><?php echo $g['gender']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Product Name -->
                        <div>
                            <label for="product_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Produk
                            </label>
                            <input type="text" id="product_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" name="nama" required>
                        </div>

                        <div>
                            <label for="product_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea name="deskripsi" id="product_name" class="w-full h-32 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" name="nama" required></textarea>
                        </div>

                        <!-- Size and Stock -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">
                                Ukuran dan Stok
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <?php
                                foreach($sizes as $size): ?>
                                <div class="border rounded-lg p-3">
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" name="sizes[]" value="<?php echo $size['id']; ?>" id="sizes<?php echo $size['id']; ?>" class="mr-2 size-checkbox" onchange="toggleStockInput(<?php echo $size['id']; ?>)">
                                        <label for="sizes<?php echo $size['id']; ?>" class="text-sm font-medium">Size <?php echo $size['size_label']; ?></label>
                                    </div>
                                    <div id="stocks_input<?php echo $size['id']; ?>" class="hidden">
                                        <input type="number" name="stock[<?php echo $size['id']; ?>]" placeholder="Stok" min="0" class="w-full px-2 py-1 text-sm border border-gray-300 rounded">
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                Harga (Rp)
                            </label>
                            <input type="number" name="price" id="price" min="0" step="1000" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4">
                            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" name="tambah">
                                Tambah Produk
                            </button>
                        </div>
                    </form>
                    <!-- Product Table -->
                    <div class="mt-10">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Daftar Produk</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 text-sm text-left">
                                <thead class="bg-red-100 text-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 border">Gambar</th>
                                        <th class="px-4 py-2 border">Nama Produk</th>
                                        <th class="px-4 py-2 border">Kategori</th>
                                        <th class="px-4 py-2 border">Merek</th>
                                        <th class="px-4 py-2 border">Stok</th>
                                        <th class="px-4 py-2 border">Harga</th>
                                        <th class="px-4 py-2 border">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($products as $p):?>
                                    <tr class="hover:bg-gray-50">

                                        <td class="px-4 py-2 border">
                                            <img src="<?php echo $p['gambar_produk']; ?>" alt="<?php echo $p['nama_produk']; ?>" class="w-16 h-16 object-cover rounded">
                                        </td>
                                        <td class="px-4 py-2 border"><?php echo $p['nama_produk']; ?></td>
                                        <td class="px-4 py-2 border"><?php echo $p['kategori']; ?></td>
                                        <td class="px-4 py-2 border"><?php echo $p['merk']; ?></td>
                                        <td class="px-4 py-2 border"><?php echo $p['stok']; ?></td>
                                        <td class="px-4 py-2 border">Rp <?php echo number_format($p['harga'], 0, ',', '.'); ?></td>
                                        <td class="px-4 py-2 border space-x-5">
                                            <div class="flex gap-2">
                                                <button class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-xs" onclick="editProduk(<?php echo $p['id_produk']; ?>)">Edit</button>
                                                <button class="btn-restok px-3 py-1 bg-blue-400 text-white rounded hover:bg-blue-500 text-xs" data-id="<?php echo $p['id_produk']; ?>">Restock</button>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div id="restokModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 w-md hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Restok Produk</h3>
                <form action="" method="POST">
                        <!-- Size and Stock -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">
                                Ukuran dan Stok
                            </label>
                            <input type="hidden" name="id" placeholder="Stok" min="0" class="w-full px-2 py-1 text-sm border border-gray-300 rounded" id="product_id_input" value="">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <?php
                                foreach($sizes as $size): ?>
                                <div class="border rounded-lg p-3">
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" name="size[]" value="<?php echo $size['id']; ?>" id="restoksize_<?php echo $size['id']; ?>" class="mr-2 size-checkbox" onchange="toggleRestockInput(<?php echo $size['id']; ?>)">
                                        <label for="restoksize_<?php echo $size['id']; ?>" class="text-sm font-medium">Size <?php echo $size['size_label']; ?></label>
                                    </div>
                                    <div id="restock_input_<?php echo $size['id']; ?>" class="hidden">
                                        <input type="number" name="restock[<?php echo $size['id']; ?>]" placeholder="Stok" min="0" class="w-full px-2 py-1 text-sm border border-gray-300 rounded">
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" onclick="closerestokModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" name="restok">
                            Tambah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Image preview functionality
        document.getElementById('product_image1').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview_img1').src = e.target.result;
                    document.getElementById('image_preview1').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
        document.getElementById('product_image2').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview_img2').src = e.target.result;
                    document.getElementById('image_preview2').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
        document.getElementById('product_image3').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview_img3').src = e.target.result;
                    document.getElementById('image_preview3').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
        document.getElementById('product_image4').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview_img4').src = e.target.result;
                    document.getElementById('image_preview4').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        // Toggle stock input based on size checkbox
        function toggleStockInput(sizes) {
            const checkboxs = document.getElementById('sizes' + sizes);
            const stockInput = document.getElementById('stocks_input' + sizes);
            
            if (checkboxs.checked) {
                stockInput.classList.remove('hidden');
                stockInput.querySelector('input').required = true;
            } else {
                stockInput.classList.add('hidden');
                stockInput.querySelector('input').required = false;
                stockInput.querySelector('input').value = '';
            }
        }
        function toggleRestockInput(size) {
            const checkbox = document.getElementById('restoksize_' + size);
            const restockInput = document.getElementById('restock_input_' + size);
            
            if (checkbox.checked) {
                restockInput.classList.remove('hidden');
                restockInput.querySelector('input').required = true;
            } else {
                restockInput.classList.add('hidden');
                restockInput.querySelector('input').required = false;
                restockInput.querySelector('input').value = '';
            }
        }

        document.querySelectorAll('.btn-restok').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('restokModal').classList.remove('hidden');
                const productId = this.getAttribute('data-id'); // ✅ 'this' benar
                document.getElementById('product_id_input').value = productId;
            });
        });

        function closerestokModal() {
            document.getElementById('restokModal').classList.add('hidden');
        }

        // Format price input
        document.getElementById('price').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });
        function editProduk(id){
            window.location = "editProduk.php?id=" + id;
        };
        
    </script>
</body>
</html>