<?php
require "../../database/query.php";

$order_id = $_GET['id'];
if(isset($_GET['id'])){
    updateShipped($order_id);
    header("Location: ../managepesanan.php");
}