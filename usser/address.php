<?php
session_start();
require "../database/query.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login_form.php");
    exit;
}
$userId = $_SESSION['user_id'];
$alamat = getAddress($userId);
$address = $alamat->fetch_assoc();

if(isset($_POST['tambah'])){
    $provinsi = htmlspecialchars($_POST['provinsi']);
    $kota = htmlspecialchars($_POST['kota']);
    $kecamatan = htmlspecialchars($_POST['kecamatan']);
    $detail = htmlspecialchars($_POST['detail']);

    addAddress($userId, $provinsi, $kota, $kecamatan, $detail);
    header("Location: alamat.php");    
}


if(isset($_POST['change'])){
    $provinsi = htmlspecialchars($_POST['provinsi']);
    $kota = htmlspecialchars($_POST['kota']);
    $kecamatan = htmlspecialchars($_POST['kecamatan']);
    $detail = htmlspecialchars($_POST['detail']);

    updateAddress($userId, $provinsi, $kota, $kecamatan, $detail);
    header("Location: alamat.php");    
}