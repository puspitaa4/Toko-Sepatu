<?php
require '../database/conn.php';
require '../database/query.php';
session_start();

$user = $_SESSION['email_verify'];
$users = getUserById($user);
$userss = $users->fetch_assoc();

if(isset($_POST['send_otp'])){

    $otp = htmlspecialchars($_POST['otp']);

    $kode = getOtpbyUserId($user);
    if($kode->num_rows > 0 ){
        $kodes = $kode->fetch_assoc();
        if($kodes['expires'] > Date('Y-m-d H:i:s') && $kodes['is_used'] === 'False' && $otp === $kodes['otp_code']){
            updateIsUsed($user);
            header("Location: change_form.php");
        }else{
            echo "<script>alert('The OTP Code Wrong Or Expired.')</script>";
        }
    }

}