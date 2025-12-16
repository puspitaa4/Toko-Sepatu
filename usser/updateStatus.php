<?php
require "../database/query.php";
session_start();
$user = $_SESSION['user_id'];
$invoice = $_SESSION['invoice'];
$produk = $_SESSION['id_produk'];
$size = $_SESSION['size_id'];

$result = updateStock($produk, $size);
updateStatusOrder($user, $invoice);
stockOut($produk);

header("Location: ../index.php");

