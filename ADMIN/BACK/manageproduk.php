<?php
require "../database/conn.php";
require "../database/query.php";
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    session_destroy();
    header("Location: ../login/login_form.php");
    exit();
}

$sizes = getSize();
$kategori = getCategory();
$merk = getBrand();
$gender = getGender();

if (isset($_POST['tambah'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $size = $_POST['sizes'] ? $_POST['sizes'] : [];
    $stok = $_POST['stock'] ? $_POST['stock'] : [];
    $kategori = (int)$_POST['category'];
    $merk = (int)$_POST['brand'];
    $gender = (int)$_POST['gender'];
    $harga = (float)$_POST['price'];
    $gambar1 = $_FILES['product_image1'];
    $gambar2 = $_FILES['product_image2'];
    $gambar3 = $_FILES['product_image3'];
    $gambar4 = $_FILES['product_image4'];

    // Validate inputs
    if (empty($nama) || $harga <= 0 || $kategori <= 0 || $merk <= 0 || $gender <= 0) {
        echo "Error: Invalid input data.";
        exit;
    }

    // Calculate total stock
    $total_stock = array_sum($stok);

    // Add product
    addProduct($nama, $deskripsi, $harga, $kategori, $merk, $gender);

    $getProduct = getProduct();
    if ($getProduct->num_rows > 0) {
        $productData = $getProduct->fetch_assoc(); 
        $productId = $productData['id'];
        $stokIn = addStock($productId, $total_stock);
        if (strpos($stokIn, "Error") !== false) {
            echo $stokIn;
            exit;
        }

        // Add sizes and stock
        if (!empty($size)) {
            $sizeResult = addProductSize($productId, $size, $stok);
            if (strpos($sizeResult, "Error") !== false) {
                echo $sizeResult;
                exit;
            }
        }

        // Add product images
        $hasMainImage = false;
        $uploadedImages = [];

        if ($gambar1['name']) {
            if (addProductImage($productId, $gambar1, true)) {
                $hasMainImage = true;
                $uploadedImages[] = 'Gambar 1';
            }
        }

        if ($gambar2['name']) {
            if (addProductImage($productId, $gambar2, false)) {
                $uploadedImages[] = 'Gambar 2';
                if (!$hasMainImage) {
                    setMainImage($productId, 2);
                    $hasMainImage = true;
                }
            }
        }

        if ($gambar3['name']) {
            if (addProductImage($productId, $gambar3, false)) {
                $uploadedImages[] = 'Gambar 3';
                if (!$hasMainImage) {
                    setMainImage($productId, 3);
                    $hasMainImage = true;
                }
            }
        }

        if ($gambar4['name']) {
            if (addProductImage($productId, $gambar4, false)) {
                $uploadedImages[] = 'Gambar 4';
                if (!$hasMainImage) {
                    setMainImage($productId, 4);
                    $hasMainImage = true;
                }
            }
        }
        header("Location: manageproduct.php");
        exit;

    }

}


// Fetch products for display
$product = getProductAndImage();

$products = [];
while($row = $product->fetch_assoc()) {
    // Konversi MEDIUMBLOB ke base64 untuk ditampilkan
    $imageData = base64_encode($row['gambar_produk']);
    $imageSrc = 'data:image/jpeg;base64,' . $imageData; // Sesuaikan format jika bukan JPEG
    
    $products[] = [
        'id_produk' => $row['id_produk'],
        'nama_produk' => $row['nama_produk'],
        'harga' => $row['harga'],
        'stok' => $row['stok'],
        'gambar_produk' => $imageSrc,
        'kategori' => $row['kategori'],
        'merk' => $row['merk']
    ];
}


if(isset($_POST['restok'])){
    $id = htmlspecialchars($_POST['id']);
    $size = $_POST['size'] ? $_POST['size'] : [];
    $stok = $_POST['restock'] ? $_POST['restock'] : [];

    $total_restok = array_sum($stok);
    // Loop untuk setiap size
    restock($id, $size, $stok);

    addStock($id, $total_restok);
    header("Location: manageproduct.php");
}