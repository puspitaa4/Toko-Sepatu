<?php
include "back/emailVerif.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="forgot.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
</head>
<body>
    <div class="container">
        <h1>Forgot Password</h1>
        <p class="signup-text">Enter the email you used to create your account so we can send you instructions on how to reset your password.</p>

        <form method="post">
            <div class="input-group">
                <input type="email" placeholder="Email" name="email" required>
            </div>
            
            <button class="send" type="submit" name="kirim">Send</button>
            <button class="back" onclick="window.location.href='login.html'">Back to Login</button>
        </form>
    </div>
</body>
</html>