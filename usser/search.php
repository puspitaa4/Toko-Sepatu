<?php
session_start();

// Fungsi untuk membersihkan input
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Ambil query pencarian
$searchQuery = '';
$results = [];
$hasSearch = false;

if (isset($_GET['q']) && !empty($_GET['q'])) {
    $searchQuery = cleanInput($_GET['q']);
    $hasSearch = true;
    
    // KONFIGURASI DATABASE
    $host = 'localhost';
    $dbname = 'shoes_store';  // Ganti dengan nama database Anda
    $username = 'root';     // Ganti dengan username database
    $password = '';     // Ganti dengan password database
    
    try {
        // Koneksi ke database
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Query pencarian - tambahkan semua field yang diperlukan
        $sql = "SELECT id_produk, nama_produk, harga, stok, gambar_produk, kategori, merk 
                FROM vproduk 
                WHERE nama_produk LIKE :search 
                ORDER BY nama_produk ASC 
                LIMIT 20";
        
        $stmt = $pdo->prepare($sql);
        $searchTerm = "%$searchQuery%";
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        
        // Ambil hasil pencarian
        $rawResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Proses hasil untuk konversi gambar
        $results = [];
        foreach ($rawResults as $row) {
            // Konversi MEDIUMBLOB ke base64 untuk ditampilkan
            $imageSrc = '';
            if (!empty($row['gambar_produk'])) {
                $imageData = base64_encode($row['gambar_produk']);
                $imageSrc = 'data:image/jpeg;base64,' . $imageData;
            } else {
                // Gunakan placeholder jika tidak ada gambar
                $imageSrc = 'path/to/placeholder-image.jpg';
            }
            
            $results[] = [
                'id_produk' => $row['id_produk'],
                'nama_produk' => $row['nama_produk'],
                'harga' => $row['harga'],
                'stok' => $row['stok'],
                'gambar_produk' => $imageSrc,
                'kategori' => $row['kategori'] ?? '',
                'merk' => $row['merk'] ?? ''
            ];
        }
        
    } catch(PDOException $e) {
        // Log error (optional)
        error_log("Database Error: " . $e->getMessage());
        
        // Fallback: gunakan data sample jika ada
        $sampleData = [
            // tambahkan data sample di sini jika diperlukan
        ];
        
        // Filter data sample berdasarkan pencarian
        $filteredResults = [];
        foreach ($sampleData as $item) {
            if (stripos($item['nama_produk'], $searchQuery) !== false) {
                $filteredResults[] = $item;
            }
        }
        $results = $filteredResults;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADIOS - Shoe Store</title>
    <link rel="stylesheet" href="search.css">
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
                        <form action="" method="get">
                            <input type="text" placeholder="Search for anything..." 
                                class="flex-1 px-4 py-2 text-gray-800 rounded-l border-none outline-none focus:ring-2 focus:ring-red-300">
                            <button class="bg-white text-gray-600 px-4 py-2 rounded-r hover:bg-gray-100 transition-colors">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
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

    <!-- Main Content -->
    <main>
        
        <div class="content-container">
            
                <?php foreach($results as $p):?>
                <a href="productSession.php?id=<?php echo $p['id_produk']; ?>">
                    <div class="bg-white rounded-lg overflow-hidden hover:transform hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                        <div class="bg-gray-100 p-5 flex justify-center items-center h-60">
                            <img src="<?php echo $p['gambar_produk']; ?>" alt="<?php echo $p['nama_produk']; ?>" class="w-full h-full object-cover rounded">
                        </div>
                        <div class="p-4 h-50">
                            <h3 class="font-semibold text-base mb-2"><?php echo $p['nama_produk']; ?></h3>
                            <p class="text-base font-bold">Rp. <?php echo number_format($p['harga'], 0, ',', '.'); ?></p>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
        </div>
    </main>
    
    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <p>Don't missout on once-in-a-while-deals:</p>
            <div class="social-icons">
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-pinterest"></i></a>
            </div>
        </div>
    </footer>
</body>
</html>