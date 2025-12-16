<?php
require "back/otp_verif.php";
if(!isset($_SESSION['email_verify'])){
    header('Location: forgot_form.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP</title>
    <link rel="stylesheet" href="otp.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
</head>
<body>
    <div class="container">
        <h1>Verifikasi OTP</h1>
        <p class="sent">We have sent an email containing the password reset OTP code to "<?php echo $userss['email'];?>".</p>
        <form method="post">
            <div class="input-group">
                <input type="number" placeholder="Kode OTP" name="otp" required>
            </div>
            <p class="receive">"Didn't receive the email? Check your Spam or Promotions folder, or request a <a href="back/sendmail.php">new OTP</a>."</p>
            <button class="send" type="submit" name="send_otp">Confirm</button>
        </form>
        <button class="back" onclick="window.location.href='login.html'">Back to Login</button>
    </div>
</body>
</html>