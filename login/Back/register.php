<?php
require "../../database/conn.php";
require "../../database/query.php";

if(isset($_POST['submitbtn'])){
    $firstname = $_POST['first'];
    $lastname = $_POST['last'];
    $fullname = $firstname . ' ' . $lastname;
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    
    // Hash password dan gunakan untuk insert
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
    
    // Gunakan password yang sudah di-hash
    $regis = insertNewUsers($fullname, $email, $hashed_password, $phone);
    
    if($regis && $regis->execute()){
        // Redirect ke login dengan pesan sukses
        header("Location: ../login_form.php?success=Account registered successfully");
        exit;
    } else {
        // Redirect dengan pesan error
        $error = "Registration failed. Please try again.";
        header("Location: ../register_form.php?error=" . urlencode($error));
        exit;
    }
} else {
    // Jika tidak ada data POST, redirect ke form
    header("Location: ../register_form.php");
    exit;
}
?>