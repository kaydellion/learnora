
<?php
include("connect.php"); // Include your database connection


$order_id = $_GET['order_id'] ?? '';
$user_id = $_GET['user_id'] ?? '';
$amount = $_GET['amount'] ?? '';
$training_id = $_GET['training_id'] ?? '';
$affiliate_id = $_GET['affiliate_id'] ?? '';
$file_id = 'donate'; // Default file ID for free items

// Insert into ln_orders
mysqli_query($con, "INSERT INTO ln_orders (order_id, user, status, total_amount, date)
VALUES ('$order_id', '$user_id', 'unpaid', '$amount', NOW())");

// Insert into order_items
mysqli_query($con, "INSERT INTO ln_order_items (item_id, training_id, price, original_price, loyalty_id, affiliate_id, order_id, date)
VALUES ('$file_id', '$training_id', '$amount', '$amount', '', '$affiliate_id', '$order_id', NOW())");


header("Location: " . $siteurl . "pay_success.php?ref=" . urlencode($order_id));
exit;


?>
