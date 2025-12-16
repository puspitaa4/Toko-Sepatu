<?php
session_start();
if(isset($_GET['id'])){
   $_SESSION['id'] = $_GET['id'];
   
   header("Location: info.php");
   exit();
}else{
    echo "Product ID not found.";
}