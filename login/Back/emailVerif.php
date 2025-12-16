<?php
session_start();
require "../database/conn.php";
require "../database/query.php";

if (isset($_POST['kirim'])){
    $email = htmlspecialchars($_POST['email']);
    $user = getUserByEmail($email);
    if($user->num_rows > 0){
        $users = $user->fetch_assoc();
        $_SESSION['email_verify'] = $users['id'];

        include "sendmail.php";
        header('Location: otp_form.php');
        exit();
    }else{
        $error = "Email tidak ditemukan.";
    }
}
