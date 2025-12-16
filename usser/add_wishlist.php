<?php
session_start();
require "../database/query.php";

if(!isset($_SESSION['user_id']) && !isset($_GET['id'])){
    die("User ID atau Produk ID Tidak Ditemukan!");
}else{
    $user_id = $_SESSION['user_id'];
    $produk_id = $_GET['id'];
    addWishlist($user_id, $produk_id);
    header("Location: info.php");
}
