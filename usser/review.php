<?php
require "../database/query.php";
session_start();
$id = $_SESSION['id'];
$review = getReview($id);
$reviews = $review->fetch_all(MYSQLI_ASSOC); // Mengambil semua baris
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADIOS - Penilaian Saya</title>
    <link rel="stylesheet" href="review.css">
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
    <main class="main-content">
        <!-- Back Navigation -->

        <!-- Reviews List -->
        <div class="reviews-container">
            <?php
            if(empty($reviews)){
                echo "belum ada review";
            }else{
            foreach ($reviews as $review) {
                echo '<div class="review-item">
                        <div class="review-header">
                            <div class="user-info">
                                <div class="user-avatar">👤</div>
                                <div class="user-details">
                                    <div class="username">' . htmlspecialchars($review['nama']) . '</div>
                                    <div class="star-rating">';
                for ($i = 0; $i < $review['rating']; $i++) {
                    echo '<span class="star">⭐</span>';
                }
                echo       '</div>
                                </div>
                            </div>
                        </div>
                        <div class="user-comment" style="margin-top: 12px; padding: 12px; background-color: #f9fafb; border-radius: 4px; font-size: 14px; color: #374151;">
                            ' . htmlspecialchars($review['review']) . '
                        </div>
                    </div>';
            }
        }
            ?>

        </div>
    </main>

    <script src="review.js"></script>
</body>
</html>
