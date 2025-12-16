<?php
require "../database/conn.php";
require "../database/query.php";

if (isset($_POST['login'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $users = getUserByEmail($email);
    if ($users->num_rows === 1) {
        session_start();
        $user = $users->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $update_status = updateUserStatus($user['id']);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../index.php");
            }
            exit();
        } else {
            $error = "Email or password is incorrect.";
        }
    } else {
        $error = "Email or password is incorrect.";
    }
}