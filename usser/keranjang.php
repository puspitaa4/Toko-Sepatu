<?php
require "../database/query.php";
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user'){
    header("Location: ../login/login_form.php");
}
$user_id = $_SESSION['user_id'];
$keranjang = getKeranjang($user_id);
$products = [];

while($row = $keranjang->fetch_assoc()) {
    $imageData = base64_encode($row['gambar']);
    $imageSrc = 'data:image/jpeg;base64,' . $imageData;
    
    $products[] = [
        'id_user' => $row['id_user'],
        'id_item' => $row['id_item'],
        'id_produk' => $row['id_produk'],
        'nama' => $row['nama'],
        'harga' => $row['harga'],
        'stok' => $row['stok'],
        'gambar' => $imageSrc,
        'size' => $row['size']
    ];
}

if(isset($_POST['hapus'])){
    $check = $_POST['check'] ? $_POST['check'] : [];

    if(!empty($check)){
        deleteItem($check);
        header("location: keranjang.php");
        exit(); 
    }else{
        echo "<script>alert('Pilih Salah Satu Barang untuk Dihapus!')</script>";
    }
}

if(isset($_POST['order'])){
    $check = $_POST['check'] ? $_POST['check'] : [];
    $harga = $_POST['harga'] ? $_POST["harga"] : [];
    $total_harga = 0;
    foreach($harga as $h){
        $price = intval($h);
        $total_harga += $price;
    }


    $address = getAddress($user_id);
    $addresses = $address->fetch_assoc();
    function generateKode($prefix = "AD") {
        $timestamp = substr(time(), -4);
        $random = '';
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            
        for ($i = 0; $i < 6; $i++) {
            $random .= $characters[rand(0, strlen($characters) - 1)];
        }
            
        return $prefix . $timestamp . $random;
    }
    $invoice = generateKode();

    addOrder($user_id, $addresses['id'], $total_harga, $invoice);
     

    $orderId = getOrderId($user_id);
    if($orderId->num_rows > 0){
        $order = $orderId->fetch_assoc();
        $_SESSION['invoice'] = $order['invoice_kode'];
        $ordersId = $order['id'];
        if (!empty($check)) {
            $Result = addOrderItem($ordersId, $check, $harga);
            
            if (strpos($Result, "Error") !== false) {
                exit;
        }
        
        
    }
    }
    deleteItem($check);
    header("Location: checkout.php");
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
                    <a href="fav.php">
                    <div class="cursor-pointer hover:text-gray-300 transition-colors">
                        <i class="far fa-heart text-lg"></i>
                    </div>
                    </a>
                    <div class="cursor-pointer hover:text-gray-300 transition-colors">
                        <a href='dashboard.php' class='text-white hover:text-gray-300'><i class='far fa-user text-lg'></i></a>
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
    <form action="" method="POST">
        <main>
            <div class="cart-items">
                <?php foreach($products as $p):?>
                <!-- Item 1 -->
                <div class="cart-item">
                    <div class="item-details">
                        <div class="item-checkbox">
                            <input type="checkbox" id="<?php echo $p['id_item'];?>" class="product-check" data-price="<?php echo $p['harga']; ?>" name="check[]" value="<?php echo $p['id_item'];?>">
                            <label for="<?php echo $p['id_item'];?>"></label>
                            <input type="hidden" id="harga_<?php echo $p['id_item']; ?>" name="harga[<?php echo $p['id_item'];?>]">
                        </div>
                        <div class="product-image">
                            <img src="<?php echo $p['gambar'];?>" alt="<?php echo $p["nama"];?>">
                        </div>
                        <div class="product-info">
                            <h3><?php echo $p['nama'];?></h3>
                            <input type="hidden" value="<?php echo $p['id_produk']; ?>" name="id[]">
                            <p class="stock">Size: <?php echo $p['size'];?></p>
                            <p class="price">Rp. <?php echo number_format($p['harga'], 0, ',', '.'); ?></p>
                            
                        </div>
                    </div>
                </div>
                <?php endforeach;?>

            <div class="cart-footer">
                <div class="select-all">
                    <input type="checkbox" id="selectAll" class="select-all-check">
                    <label for="selectAll">Semua</label>
                </div>
                <div class="total-section">
                    <div class="total-label">Total</div>
                    <div class="total-amount">Rp0</div>
                </div>
                <button class="delete" type="submit" name="hapus">Hapus Barang</button>
                <button class="checkout-button" type="submit" name="order">Buat Pesanan</button>
            </div>
        </main> 
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('selectAll');
            const storeCheckboxes = document.querySelectorAll('.store-check');
            const productCheckboxes = document.querySelectorAll('.product-check');
            const checkoutButton = document.querySelector('.checkout-button');
            const totalAmount = document.querySelector('.total-amount');

            // Function to update hidden inputs and total price
            function updateInputsAndTotal() {
                let total = 0;
                productCheckboxes.forEach(checkbox => {
                    const itemId = checkbox.value;
                    const price = parseFloat(checkbox.dataset.price) || 0;
                    const hiddenInput = document.getElementById("harga_" + itemId);
                    
                    if (checkbox.checked && hiddenInput) {
                        hiddenInput.value = price; // Set hidden input value to data-price
                        total += price;
                    } else if (hiddenInput) {
                        hiddenInput.value = ''; // Clear hidden input when unchecked
                    }
                });
                totalAmount.textContent = 'Rp' + total.toLocaleString('id-ID');
            }

            // Function to update Select All checkbox status
            function updateSelectAllStatus() {
                const allChecked = Array.from(productCheckboxes).every(checkbox => checkbox.checked);
                const someChecked = Array.from(productCheckboxes).some(checkbox => checkbox.checked);
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            }

            // Select All functionality
            selectAllCheckbox.addEventListener('change', function () {
                productCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                storeCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateInputsAndTotal();
                updateSelectAllStatus();
            });

            // Store checkbox functionality (if applicable)
            storeCheckboxes.forEach(storeCheckbox => {
                storeCheckbox.addEventListener('change', function () {
                    const storeId = this.id.replace('store', '');
                    productCheckboxes.forEach(productCheckbox => {
                        if (productCheckbox.dataset.storeId === storeId) {
                            productCheckbox.checked = this.checked;
                        }
                    });
                    updateInputsAndTotal();
                    updateSelectAllStatus();
                });
            });

            // Product checkbox functionality
            productCheckboxes.forEach(productCheckbox => {
                productCheckbox.addEventListener('change', function () {
                    updateInputsAndTotal();
                    updateSelectAllStatus();

                    const storeId = this.dataset.storeId;
                    const relatedStoreCheckbox = document.getElementById(`store${storeId}`);
                    if (relatedStoreCheckbox) {
                        const relatedProducts = document.querySelectorAll(`.product-check[data-store-id="${storeId}"]`);
                        relatedStoreCheckbox.checked = Array.from(relatedProducts).every(checkbox => checkbox.checked);
                        relatedStoreCheckbox.indeterminate = Array.from(relatedProducts).some(checkbox => checkbox.checked) && !relatedStoreCheckbox.checked;
                    }
                });
            });

            // Initialize inputs and total
            updateInputsAndTotal();
        });
    </script>
</body>
</html>