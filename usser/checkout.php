<?php
session_start();
require "../database/query.php";
$user_id = $_SESSION['user_id'];
$invoice = $_SESSION['invoice'];
$order = getOrder($user_id, $invoice);
$orders = [];
while($row = $order->fetch_assoc()) {
    $imageData = base64_encode($row['gambar']);
    $imageSrc = 'data:image/jpeg;base64,' . $imageData;
    
    $orders[] = [
        'harga' => $row['harga'],
        'id_produk' => $row['id_produk'],
        'nama' => $row['nama'],
        'status' => $row['status'],
        'gambar' => $imageSrc,
        'invoice_kode' => $row['invoice_kode'],
        'size_label' => $row['size_label'],
        'tanggal_pemesanan' => $row['tanggal_pemesanan']
    ];
}

foreach ($orders as $order) {
    $sizeResult = getSizeId($order['size_label']);
    if ($sizeResult && $sizeResult->num_rows > 0) {
        $sizeRow = $sizeResult->fetch_assoc();
        $size[] = $sizeRow['id']; // atau nama field yang sesuai dengan ID size
    }
}
$address = getAddress($user_id);
$addresses = $address->fetch_Assoc();
$totalHarga = array_sum(array_column($orders, 'harga'));
$_SESSION['id_produk'] = array_column($orders, 'id_produk');
$_SESSION['size_id'] = $size;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADIOS - Shopping Cart</title>
    <link rel="stylesheet" href="cart.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-Ie0lEMniRU58Fpcj"></script>
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
                    <a href="keranjang.php">
                    <div class="relative cursor-pointer hover:text-gray-300 transition-colors">
                        <i class="fas fa-shopping-cart text-lg"></i>
                    </div>
                    </a>
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

    <main>
        <div class="container">
            <div class="cart-section">
                <?php foreach($orders as $o):?>
                <div class="cart-items">
                    <div class="cart-item">
                        <div class="item-image">
                            <img src="<?php echo $o['gambar']; ?>" alt="Jordan Delta 2">
                        </div>
                        <div class="item-details">
                            <h3><?php echo $o['nama']; ?></h3>
                            <p class="price">Size: <?php echo $o['size_label'];?></p>
                        </div>
                        <div class="item-total">
                            <p>Rp. <?php echo number_format($o['harga'], 0, ',', '.'); ?></p>
                        </div>
                    </div>
                </div>
                <br>
                <?php endforeach;?>
            </div>

            <div class="order-summary">
                <h2>Order summary</h2>
                <form>
                    <div class="summary-row">
                        <span>Kode Pesanan:</span>
                        <span><?php echo $orders[0]['invoice_kode']?></span>
                    </div>
                    <div class="summary-row">
                        <span>Tanggal Pemesanan:</span>
                        <span><?php echo date('d/m/Y', strtotime($orders[0]['tanggal_pemesanan']));?></span>
                    </div>
                    <div class="summary-row">
                        <span>Waktu Pemesanan:</span>
                        <span><?php echo date('H:i', strtotime($orders[0]['tanggal_pemesanan']));?></span>
                    </div>
                    <div class="summary-row">
                        <span>Alamat:</span>
                        <span><?php echo $addresses['alamat_lengkap']; ?>, kec. <?php echo $addresses['kecamatan']; ?>, <?php echo $addresses['kota_kab']; ?></span>
                    </div>
                    <div class="summary-divider"></div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>Rp. <?php echo number_format($totalHarga, 0, ',', '.'); ?></span>
                    </div>
                    <button class="checkout-btn" id="pay-button">Bayar Sekarang</button>
                </form>
            </div>
        </div>
    </main>
    <script type="text/javascript">
      // Versi yang benar dan sederhana
document.addEventListener('DOMContentLoaded', function() {
    var payButton = document.getElementById('pay-button');
    
    if (payButton) {
        console.log('Button found');
        
        payButton.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Button clicked');
            
            // Fetch token dari PHP
            fetch('get_token.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                }
            })
            .then(function(response) {
                console.log('Response status:', response.status);
                
                if (!response.ok) {
                    throw new Error('HTTP error ' + response.status);
                }
                
                return response.text();
            })
            .then(function(snapToken) {
                console.log('Token received:', snapToken);
                
                // Bersihkan token dari whitespace
                var cleanToken = snapToken.trim();
                
                if (cleanToken.length > 0) {
                    console.log('Calling snap.pay with token:', cleanToken);
                    
                    // Panggil Midtrans Snap
                    window.snap.pay(cleanToken, {
                        onSuccess: function(result) {
                            console.log('Payment success:', result);
                            alert('Pembayaran berhasil!');
                            // Redirect atau update UI
                            window.location.href = 'updateStatus.php';
                        },
                        onPending: function(result) {
                            console.log('Payment pending:', result);
                            alert('Pembayaran pending, silakan selesaikan');
                        },
                        onError: function(result) {
                            console.log('Payment error:', result);
                            alert('Terjadi kesalahan pembayaran');
                        },
                        onClose: function() {
                            console.log('Payment popup closed');
                        }
                    });
                } else {
                    console.error('Token kosong');
                    alert('Gagal mendapatkan token pembayaran');
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            });
        });
    } else {
        console.error('Button dengan id "pay-button" tidak ditemukan');
    }
});

// Versi alternatif dengan async/await (pilih salah satu)
/*
document.addEventListener('DOMContentLoaded', async function() {
    var payButton = document.getElementById('pay-button');
    
    if (payButton) {
        payButton.addEventListener('click', async function(e) {
            e.preventDefault();
            
            try {
                console.log('Fetching token...');
                
                const response = await fetch('get_token.php', {
                    method: 'POST'
                });
                
                if (!response.ok) {
                    throw new Error('HTTP error ' + response.status);
                }
                
                const snapToken = await response.text();
                console.log('Token:', snapToken);
                
                const cleanToken = snapToken.trim();
                
                if (cleanToken) {
                    window.snap.pay(cleanToken, {
                        onSuccess: function(result) {
                            alert('Pembayaran berhasil!');
                        },
                        onPending: function(result) {
                            alert('Pembayaran pending');
                        },
                        onError: function(result) {
                            alert('Pembayaran error');
                        }
                    });
                }
                
            } catch (error) {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            }
        });
    }
});
*/
    </script>
</body>
</html>