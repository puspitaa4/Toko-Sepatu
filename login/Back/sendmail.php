<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; 
require 'back/otp_generate.php';

$expiry_minutes = 5;
$user_id = $_SESSION['email_verify'];
$user = getUserById($user_id);
$users = $user->fetch_assoc();
$mail = new PHPMailer(true);
$otp = getOtpbyUserId($user_id);

$expiry_minutes = 5;
$expires_at = (new DateTime())->modify("+{$expiry_minutes} minutes")->format('Y-m-d H:i:s');
$otp_code = generate_otp();

if($otp->num_rows === 0){
    $addotp = insertNewOtps($user_id, $otp_code, $expires_at);
}else{
    $updateotp = updateOtps($otp_code, $expires_at, $user_id);
}

try {
    // Pengaturan Server SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'rplgacorr@gmail.com';
    $mail->Password   = 'nbhr ofjy jksz yskh'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Pengaturan Pengirim dan Penerima
    $mail->setFrom('rplgacorr@gmail.com', 'Adios');
   
    $mail->addAddress($users['email'], $users['name']); 

    // Konten Email
    $mail->isHTML(true);
    $mail->Subject = 'OTP Request';
    $mail->Body    = "This is your OTP code: <b>$otp_code</b>. This otp code will be expire in 5 minutes.";

    // Kirim Email
    $mail->send();

} catch (Exception $e) {
    echo "Email gagal dikirim. Error: {$mail->ErrorInfo}";
}