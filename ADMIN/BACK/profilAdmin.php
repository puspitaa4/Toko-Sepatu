<?php
require "../database/query.php";
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    session_destroy();
    header("Location: ../login/login_form.php");
    exit(); // Wajib ada!
}
$userId = $_SESSION['user_id'];
$user = getUserById($userId);
if($user->num_rows > 0){
    $users = $user->fetch_assoc();
}

if(isset($_POST['save'])){
    $nama = htmlspecialchars($_POST['full_name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);

    updateProfile($userId, $nama, $email, $phone);
    header("Location: pengaturanadmin.php");
}
