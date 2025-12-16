<?php
session_start();
require "../database/query.php";
$userId = $_SESSION['user_id'];
$user = getUserById($userId);
$users = $user->fetch_Assoc();
if(isset($_POST['save'])){
    $nama = htmlspecialchars($_POST['full_name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);

    updateProfile($userId, $nama, $email, $phone);
    header("Location: profile.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADIOS - User Profile</title>
    <link rel="stylesheet" href="profile.css">
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
    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <h1 class="sidebar-title">Profil</h1>
            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="dashboard.php">
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
                    <li class="active">
                        <a href="#">
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
                        <a href="index.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            Keluar
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Personal Data Section -->
            <section class="content-section">
                <div class="section-header">
                    <h2>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Data Diri
                    </h2>
                </div>
                <div class="profile-form">
                    <div class="profile-avatar">
                        <img src="https://as2.ftcdn.net/v2/jpg/05/89/93/27/1000_F_589932782_vQAEAZhHnq1QCGu5ikwrYaQD0Mmurm0N.jpg" alt="Profile Avatar">
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
            </section>
            
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
        </main>
    </div>

    <script src="profile.js"></script>
</body>
</html>