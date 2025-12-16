<?php
require "conn.php";

date_default_timezone_set('Asia/Jakarta');
$conn->query("SET time_zone = '+07:00'");
function getAllUsers(){
    global $conn;
    $result = $conn->query("SELECT * FROM users");
    return $result;
}

function getUserById($id){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result();
}

function getUserByEmail($email) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error); // Add error handling
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close(); // Close the statement to free resources
    return $result;
}

function updateUserStatus($userId) {
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET status = 'active' WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $affected_rows = $stmt->affected_rows;
    $stmt->close(); // Close the statement
    return $affected_rows > 0;
}

function insertNewUsers($name, $email, $password, $phone){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $phone);
    return $stmt;
}

function getUserIdByEmail($email) {
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error); // Add error handling
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close(); // Close the statement to free resources
    return $result;
}

function insertNewOtps($userId, $otpCode, $expire){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO otp_codes (user_id, otp_code, expires) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $userId, $otpCode, $expire);
    $result = $stmt->execute();
    return $result;
}

function updateOtps($otpCode, $expires, $userId){
    global $conn;
    $stmt = $conn->prepare("UPDATE otp_codes SET otp_code = ?, expires = ?, is_used = 'False' WHERE user_id = ?");
    $stmt->bind_param("ssi", $otpCode, $expires, $userId);
    $result = $stmt->execute();
    return $result;
}

function updateIsUsed($userId){
    global $conn;
    $stmt = $conn->prepare("UPDATE otp_codes SET is_used = 'True' WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $result = $stmt->execute();
    return $result;
}

function getOtpbyUserId($userId){
    global $conn;
    $stmt = $conn->prepare("SELECT otp_code, expires, is_used FROM otp_codes WHERE user_id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error); // Add error handling
    }
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close(); // Close the statement to free resources
    return $result;
}

function updatePasswords($password, $userId){
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $password, $userId);
    return $stmt;
}

function updateStatus($userId){
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET status = 'inactive' WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    return $stmt->get_result();
}

function getSize(){
    global $conn;
    $stmt = $conn->prepare("SELECT id, size_label FROM sizes");
    $stmt->execute();
    return $stmt->get_result();
}

function getCategory(){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM categories");
    $stmt->execute();
    return $stmt->get_result();
}

function getBrand(){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM brands");
    $stmt->execute();
    return $stmt->get_result();
}

function addProduct($name, $description, $price, $category, $brand, $gender, $total_stock=0){
    global $conn;
    $stmt = $conn->prepare("CALL spTambahProduk(?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiiii", $name, $description, $price, $category, $brand, $gender, $total_stock);
    $stmt->execute();
    return $conn;
}

// Fungsi untuk menambahkan gambar ke database
function addProductImage($productId, $image, $isMain = false) {
    global $conn;
    if ($image['error'] == 0) {
        // Validasi tipe file gambar
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($image['type'], $allowedTypes)) {
            return false; // Tipe file tidak diizinkan
        }
        
        // Validasi ukuran file (max 5MB)
        if ($image['size'] > 5 * 1024 * 1024) {
            return false; // File terlalu besar
        }
        
        // Jika ini akan menjadi gambar utama, set semua gambar lain menjadi bukan utama
        if ($isMain) {
            $resetStmt = $conn->prepare("UPDATE product_images SET is_main = 0 WHERE product_id = ?");
            $resetStmt->bind_param("i", $productId);
            $resetStmt->execute();
            $resetStmt->close();
        }
        
        // Baca file gambar sebagai binary data
        $imageData = file_get_contents($image['tmp_name']);
        // Dapatkan tipe MIME dari gambar
        $imageType = $image['type'];
        // Set nilai is_main
        $mainFlag = $isMain ? 1 : 0;
        
        // Buat prepared statement dengan kolom is_main
        $stmt = $conn->prepare("INSERT INTO product_images (product_id, image, is_main, image_type) VALUES (?, ?, ?, ?)");
        // Bind parameter
        $stmt->bind_param("isis", $productId, $imageData, $mainFlag, $imageType);
        // Eksekusi query
        $result = $stmt->execute();
        // Tutup statement
        $stmt->close();  
        return $result;
    }
    return false;
}

function addProductSize($product, $size, $stock){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO product_sizes (product_id, size_id, stock) VALUES (?,?,?)");
    foreach($size as $sizes){
        $currentStock = isset($stock[$sizes]) ? $stock[$sizes] : 0;
        $stmt->bind_param("iii", $product, $sizes, $currentStock);
        $stmt->execute();
    }
    $stmt->close();
    return true;
}

function getGender(){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM gender");
    $stmt->execute();
    return $stmt->get_result();
}

// Fungsi untuk mengatur gambar sebagai gambar utama
function setMainImage($productId, $imagePosition) {
    global $conn;
    
    // Reset semua gambar menjadi bukan utama
    $resetStmt = $conn->prepare("UPDATE product_images SET is_main = 0 WHERE product_id = ?");
    $resetStmt->bind_param("i", $productId);
    $resetStmt->execute();
    $resetStmt->close();
    
    // Set gambar terakhir yang diupload sebagai utama
    $mainStmt = $conn->prepare("UPDATE product_images SET is_main = 1 WHERE product_id = ? ORDER BY id DESC LIMIT 1");
    $mainStmt->bind_param("i", $productId);
    $result = $mainStmt->execute();
    $mainStmt->close();
    
    return $result;
}

// Fungsi untuk mendapatkan gambar utama produk
function getMainImage($productId) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM product_images WHERE product_id = ? AND is_main = 1 LIMIT 1");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $image = $result->fetch_assoc();
    $stmt->close();
    return $image;
}

// Fungsi untuk mendapatkan semua gambar produk
function getAllProductImages($productId) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM product_images WHERE product_id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $images = [];
    while($row = $result->fetch_assoc()) {
        $images[] = $row;
    }
    $stmt->close();
    return $images;
}

function getProductAndImage(){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM vproduk");
    $stmt->execute();
    return $stmt->get_result();
}

function addStock($product_id, $qty) {
    global $conn;
    // Validate product_id
    $sql_check = "SELECT id FROM products WHERE id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $product_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    if ($result_check->num_rows == 0) {
        $stmt_check->close();
        return "Error: Product ID $product_id does not exist.";
    }
    $stmt_check->close();

    // Call stored procedure
    $sql = "INSERT INTO stock_in (product_id, qty) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $product_id, $qty);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

function getProduct(){
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM products ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    return $stmt->get_result();
}

function viewDashboard(){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM vpenjualanharian");
    $stmt->execute();
    return $stmt->get_result();
}

function countUserProduct(){
    global $conn;
    $stmt = $conn->prepare("SELECT (SELECT count(id) FROM users WHERE role = 'user') AS total_user, (SELECT count(id) FROM products) AS total_produk");
    $stmt->execute();
    return $stmt->get_result();
}

function addUserWithRole($nama, $email, $password, $role){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $email, $password, $role);
    $result = $stmt->execute();
    return $result;
}

function getProductNew(){
    global $conn;
    $stmt = $conn->prepare("SELECT vp.id_produk AS id_produk, vp.nama_produk AS nama_produk, vp.gambar_produk AS gambar_produk, vp.harga AS harga, vp.stok AS stok, vp.kategori AS kategori, vp.merk AS merk, p.created_at AS tanggal_rilis FROM vproduk vp INNER JOIN products p ON vp.nama_produk = p.name ORDER BY p.created_at DESC LIMIT 8;");
    $stmt->execute();
    return $stmt->get_result();
}
function getProductSearch(){
    global $conn;
    $stmt = $conn->prepare("SELECT vp.id_produk AS id_produk, vp.nama_produk AS nama_produk, vp.gambar_produk AS gambar_produk, vp.harga AS harga, vp.stok AS stok, vp.kategori AS kategori, vp.merk AS merk, p.created_at AS tanggal_rilis FROM vproduk vp INNER JOIN products p ON vp.nama_produk = p.name");
    $stmt->execute();
    return $stmt->get_result();
}

function getProductNewArrival(){
    global $conn;
    $stmt = $conn->prepare("SELECT vp.id_produk AS id_produk, vp.nama_produk AS nama_produk, vp.gambar_produk AS gambar_produk, vp.harga AS harga, vp.stok AS stok, vp.kategori AS kategori, vp.merk AS merk, p.created_at AS tanggal_rilis FROM vproduk vp INNER JOIN products p ON vp.nama_produk = p.name ORDER BY p.created_at DESC;");
    $stmt->execute();
    return $stmt->get_result();
}

function getProductMen(){
    global $conn;
    $stmt = $conn->prepare("SELECT vp.id_produk AS id_produk, vp.nama_produk AS nama_produk, vp.gambar_produk AS gambar_produk, vp.harga AS harga, vp.stok AS stok, vp.kategori AS kategori, vp.merk AS merk, p.created_at AS tanggal_rilis FROM vproduk vp INNER JOIN products p ON vp.nama_produk = p.name AND p.gender_id = 1;");
    $stmt->execute();
    return $stmt->get_result();
}

function getProductWomen(){
    global $conn;
    $stmt = $conn->prepare("SELECT vp.id_produk AS id_produk, vp.nama_produk AS nama_produk, vp.gambar_produk AS gambar_produk, vp.harga AS harga, vp.stok AS stok, vp.kategori AS kategori, vp.merk AS merk, p.created_at AS tanggal_rilis FROM vproduk vp INNER JOIN products p ON vp.nama_produk = p.name AND p.gender_id = 2;");
    $stmt->execute();
    return $stmt->get_result();
}

function getProductUnisex(){
    global $conn;
    $stmt = $conn->prepare("SELECT vp.id_produk AS id_produk, vp.nama_produk AS nama_produk, vp.gambar_produk AS gambar_produk, vp.harga AS harga, vp.stok AS stok, vp.kategori AS kategori, vp.merk AS merk, p.created_at AS tanggal_rilis FROM vproduk vp INNER JOIN products p ON vp.nama_produk = p.name AND p.gender_id = 3;");
    $stmt->execute();
    return $stmt->get_result();
}

function getProductNewest(){
    global $conn;
    $stmt = $conn->prepare("SELECT vp.id_produk AS id_produk, vp.nama_produk AS nama_produk, vp.gambar_produk AS gambar_produk, vp.harga AS harga, vp.stok AS stok, vp.kategori AS kategori, vp.merk AS merk, p.description AS deskripsi, p.created_at AS tanggal_rilis FROM vproduk vp INNER JOIN products p ON vp.nama_produk = p.name ORDER BY p.created_at DESC LIMIT 1;");
    $stmt->execute();
    return $stmt->get_result();
}

function updateProfile($userId, $name, $email, $phone){
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $phone, $userId);
    $result = $stmt->execute();
    return $result;
}

function restock($productId, $sizeId, $stok){
    global $conn;
    $stmt = $conn->prepare("
                    INSERT INTO product_sizes (product_id, size_id, stock, created_at, updated_at) 
                    VALUES (?, ?, ?, NOW(), NOW()) 
                    ON DUPLICATE KEY UPDATE 
                        stock = stock + VALUES(stock), 
                        updated_at = NOW()
                ");
    foreach($sizeId as $sizes){
        $currentStock = isset($stok[$sizes]) ? $stok[$sizes] : 0;
        $stmt->bind_param("iii", $productId, $sizes, $currentStock);
        $stmt->execute();
    }
    $stmt->close();
    return true;
}

function getProductById($id){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result();
}

function updateProduct($id, $name, $description, $price){
    global $conn;
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssii", $name, $description, $price, $id);
    $result = $stmt->execute();
    return $result;
}

function getProductDetail($id){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM vproduct_detail WHERE product_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result();
}

function getShoeSize($Id){
    global $conn;
    $stmt = $conn->prepare("SELECT s.size_label AS size, ps.id AS id FROM sizes s, products p, product_sizes ps WHERE s.id = ps.size_id AND p.id = ps.product_id AND p.id = ?;");
    $stmt->bind_param("i", $Id);
    $stmt->execute();
    return $stmt->get_result();
}

function getWishlist($productId, $userId){
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM wishlists WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    return $stmt->get_result();
}

function addWishlist($userId, $productId){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO wishlists(user_id, product_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $userId, $productId);
    $result = $stmt->execute();
    return $result;
}

function deleteWishlist($userId, $productId){
    global $conn;
    $stmt = $conn->prepare("DELETE FROM wishlists WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $userId, $productId);
    $result = $stmt->execute();
    return $result;
}

function getWishlists($userId){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM vwishlist WHERE id_user = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    return $stmt->get_result();
}

function getOrder($user_Id, $invoice){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM vorder WHERE user_id = ? AND invoice_kode = ? AND status = 'pending' ORDER BY tanggal_pemesanan DESC");
    $stmt->bind_param("is", $user_Id, $invoice);
    $stmt->execute();
    return $stmt->get_result();
}

function getOrderss($user_Id){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM vorder WHERE user_id = ? ORDER BY tanggal_pemesanan DESC LIMIT 2");
    $stmt->bind_param("i", $user_Id);
    $stmt->execute();
    return $stmt->get_result();
}
function getOrdersss($user_Id){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM vorder WHERE user_id = ? ORDER BY tanggal_pemesanan DESC");
    $stmt->bind_param("i", $user_Id);
    $stmt->execute();
    return $stmt->get_result();
}
function getOrderssss(){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM vorder");
    $stmt->execute();
    return $stmt->get_result();
}

function getAddress($userId){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM addresses WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    return $stmt->get_result();
}

function addAddress($user_Id, $provinsi, $kota, $kecamatan, $detail){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO addresses (user_id, provinsi, kota_kab, kecamatan, alamat_lengkap) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_Id, $provinsi, $kota, $kecamatan, $detail);
    $result = $stmt->execute();
    return $result;
}

function updateAddress($user_Id, $provinsi, $kota, $kecamatan, $detail){
    global $conn;
    $stmt = $conn->prepare("UPDATE addresses SET provinsi = ?, kota_kab = ?, kecamatan = ?, alamat_lengkap = ? WHERE user_id = ?");
    $stmt->bind_param("ssssi", $provinsi, $kota, $kecamatan, $detail, $user_Id);
    $result = $stmt->execute();
    return $result;
}

function addCart($user){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO carts(user_id) VALUES (?)");
    $stmt->bind_param("i", $user);
    $result = $stmt->execute();
    return $result;
}

function addCartItems($cartId, $productSize){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO cart_items(cart_id, product_size_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $cartId, $productSize);
    $result = $stmt->execute();
    return $result;
}

function getCart($userId){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM carts WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    return $stmt->get_result();
}

function getKeranjang($user_Id){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM vkeranjang WHERE id_user = ?");
    $stmt->bind_param("i", $user_Id);
    $stmt->execute();
    return $stmt->get_result();
}

function deleteItem($id){
    global $conn;
    $stmt = $conn->prepare("DELETE FROM cart_items WHERE product_size_id = ?");
    foreach($id as $ids){
        $stmt->bind_param("i", $ids);
        $stmt->execute();
    }
    $stmt->close();
    return true;
}

function addOrder($userId, $address, $harga, $invoice){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO orders(user_id, address_id, total_harga, invoice_kode) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $userId, $address, $harga, $invoice);
    $result = $stmt->execute();
    return $result;
}

function getOrders($user_Id){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");
    $stmt->bind_param("i", $user_Id);
    $stmt->execute();
    return $stmt->get_result();
}

function addOrderItem($orderId, $productSize, $harga){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO order_items(order_id, product_size_id, price) VALUES (?, ?, ?)");
    foreach($productSize as $sizes){
        $currentStock = isset($harga[$sizes]) ? $harga[$sizes] : 0;
        $stmt->bind_param("iii", $orderId, $sizes, $currentStock);
        $stmt->execute();
    }
    $stmt->close();
    return true;
}

function getOrderId($user_Id){
    global $conn;
    $stmt = $conn->prepare("SELECT id, invoice_kode FROM orders WHERE user_id = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("i", $user_Id);
    $stmt->execute();
    return $stmt->get_result();
}

function stockOut($productIds, $qtyPerItem = 1){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO stock_out (product_id, qty) VALUES (?, ?)");
    foreach($productIds as $id){
        $stmt->bind_param("ii", $id, $qtyPerItem);
        $stmt->execute();
    }
    $stmt->close();
    return true;
}

function updateStatusOrder($user, $invoice){
    global $conn;
    $stmt = $conn->prepare("UPDATE orders SET status = 'paid' WHERE user_id = ? AND invoice_kode = ?");
    $stmt->bind_param("is", $user, $invoice);
    $result = $stmt->execute();
    return $result;
}

function updateShipped($order_id){
    global $conn;
    $stmt = $conn->prepare("UPDATE orders SET status = 'shipped' WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $result = $stmt->execute();
    return $result;
}
function updateCompleted($order_id){
    global $conn;
    $stmt = $conn->prepare("UPDATE orders SET status = 'completed' WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $result = $stmt->execute();
    return $result;
}
function updateCanceled($order_id){
    global $conn;
    $stmt = $conn->prepare("UPDATE orders SET status = 'canceled' WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $result = $stmt->execute();
    return $result;
}

function addReview($rating, $komen, $user, $produk){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO ratings(user_id, product_id, rating, review) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $user, $produk, $rating, $komen);
    $result = $stmt->execute();
    return $result;
}

function getReview($product){
    global $conn;
    $stmt = $conn->prepare("SELECT u.name AS nama, r.rating AS rating, r.review AS review FROM ratings r, users u WHERE product_id = ? AND r.user_id = u.id");
    $stmt->bind_param("i", $product);
    $stmt->execute();
    return $stmt->get_result();
}

function getSizeId($label){
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM sizes WHERE size_label = ?");
    $stmt->bind_param("i", $label);
    $stmt->execute();
    return $stmt->get_result();
}

function updateStock($produkIds, $sizeIds) {
    global $conn;
    
    $success = 0;
    $failed = 0;
    
    for ($i = 0; $i < count($produkIds); $i++) {
        $produkId = $produkIds[$i];
        $sizeId = isset($sizeIds[$i]) ? $sizeIds[$i] : null;
        
        if ($sizeId) {
            $query = "UPDATE product_sizes SET stock = stock - 1 WHERE product_id = ? AND size_id = ? AND stock > 0";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $produkId, $sizeId);
            
            if ($stmt->execute() && $stmt->affected_rows > 0) {
                $success++;
            } else {
                $failed++;
            }
        }
    }
    
    return ['success' => $success, 'failed' => $failed];
}