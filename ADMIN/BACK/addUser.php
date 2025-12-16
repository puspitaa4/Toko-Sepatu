<?php
require "../database/conn.php";
require "../database/query.php";
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    session_destroy();
    header("Location: ../login/login_form.php");
    exit(); // Wajib ada!
}

if(isset($_POST['tambah'])){
    $nama = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $role = htmlspecialchars($_POST['role']);

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    addUserWithRole($nama, $email, $hashed_password, $role);
    header("Location: manageuser.php");
}