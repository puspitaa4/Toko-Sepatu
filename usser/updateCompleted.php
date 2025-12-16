<?php
require "../database/query.php";
$id = $_GET['order_id'];
if(isset($_GET['order_id'])){
    updateCompleted($id);
    header("Location: pesanan.php");
}