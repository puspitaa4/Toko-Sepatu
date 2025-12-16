<?php
require "database/conn.php";
require "database/query.php";
session_start();

// Periksa apakah pengguna sudah login
if (isset($_SESSION['user_id'])) {

    updateStatus($_SESSION['email_verify']);

}
session_unset();
session_destroy();

header("Location: index.php");
exit();