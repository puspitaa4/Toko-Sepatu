<?php
require '../database/conn.php';
require '../database/query.php';

session_start();
if(!isset($_SESSION['email_verify'])){
    header('location: forgot_form.php');
}

if(isset($_POST['reset'])) {
    $user = $_SESSION['email_verify'];
    $password = htmlspecialchars($_POST['password']);
    $confPassword = htmlspecialchars($_POST['confirm']);

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    echo "<script>confirm(Apakah Anda yakin ingin mengganti password?)</script>";

    $update = updatePasswords($hashed_password, $user);

    if($update && $update->execute()){
        echo "<script>alert('Password telah berhasil diubah. Silahkan login dengan password baru.')</script>";
        header("location: login_form.php");
        session_unset();
        session_destroy();
    }else{
        echo "<script>alert('Password gagal diubah.')</script>";
        header("location: change_form.php");

    }
}