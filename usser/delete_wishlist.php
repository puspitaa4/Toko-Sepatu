<?php
require "../database/query.php";
session_start();
$user_id = $_SESSION['user_id'];
if(isset($_GET['id'])){
    $id_produk = $_GET['id'];

    deleteWishlist($user_id, $id_produk);
    header("Location: info.php");
}