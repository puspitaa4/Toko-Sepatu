<?php
/*Install Midtrans PHP Library (https://github.com/Midtrans/midtrans-php)
composer require midtrans/midtrans-php
                              
Alternatively, if you are not using **Composer**, you can download midtrans-php library 
(https://github.com/Midtrans/midtrans-php/archive/master.zip), and then require 
the file manually.   

require_once dirname(__FILE__) . '/pathofproject/Midtrans.php'; */
require_once __DIR__ . '/../vendor/autoload.php';

//SAMPLE REQUEST START HERE
session_start();
require "../database/query.php";
$user_id = $_SESSION['user_id'];
$user = getUserById($user_id);
$users = $user->fetch_assoc();
$invoice_kode = $_SESSION['invoice'];
$order = getOrder($user_id, $invoice_kode);
$item_details = [];
$gross_amount = 0;

while ($row = $order->fetch_assoc()) {
    $item_details[] = [
        'id' => $row['id_produk'],
        'price' => (int)$row['harga'],
        'quantity' => 1,
        'name' => $row['nama'] . ' (' . $row['size_label'] . ')'
    ];
    $gross_amount += $row['harga'];
}

// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-JR8TJ_ZLrl25GbbN6DUmC75c';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;

$params = array(
    'transaction_details' => array(
        'order_id' => $invoice_kode,
        'gross_amount' => $gross_amount,
    ),
    'customer_details' => array(
        'first_name' => $users['name'],
        'email' => $users['email'],
        'phone' => $users['phone'],
    ),
    'item_details' => $item_details
);

$snapToken = \Midtrans\Snap::getSnapToken($params);

echo $snapToken;