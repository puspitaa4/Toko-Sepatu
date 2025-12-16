<?php 
require "../database/query.php";
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    session_destroy();
    header("Location: ../login/login_form.php");
    exit(); // Wajib ada!
}
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $product = getProductById($id);
    $products = $product->fetch_assoc();
}

if(isset($_POST['update'])){
    $nama = htmlspecialchars($_POST['nama']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $price = htmlspecialchars($_POST['price']);

    updateProduct($id, $nama, $deskripsi, $price);
    header("Location: manageproduct.php");
}