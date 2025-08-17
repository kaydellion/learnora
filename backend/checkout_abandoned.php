<?php
include 'connect.php'; // Include your config file for database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['abandoned_ref'])) {
    // Handle abandoned checkout
    $ref = mysqli_real_escape_string($con, $_POST['abandoned_ref']);
    $query = mysqli_query($con, "SELECT * FROM orders WHERE order_reference='$ref' LIMIT 1");
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);

        // Update order to abandoned if not paid
        if ($row['status'] !== 'paid') {
            mysqli_query($con, "UPDATE orders SET status='abandoned' WHERE order_reference='$ref'");

            // Send reminder email
            $buyerEmail = $row['buyer_email'];
            $buyerName = $row['buyer_name'];
            $resourceTitle = $row['resource_title'];
            $price = $row['amount'];
            $checkoutLink = "https://$siteurl/checkout.php?ref=$ref";

            $subject = "You left something behind – complete your purchase!";
            $message = "
                <p>Hello $buyerName,</p>
                <p>We noticed you started checking out on <strong>$siteurl</strong> but didn’t complete your purchase.</p>
                <p><strong>Item:</strong> $resourceTitle</p>
                <p><strong>Price:</strong> $sitecurrencyCode$price</p>
                <p>Your model is still waiting for you. Complete your purchase in just a few clicks:</p>
                <p><a href='$checkoutLink' style='display:inline-block;padding:12px 20px;background:#007bff;color:#fff;text-decoration:none;border-radius:5px;'>Complete My Purchase</a></p>
                <p>Don’t miss out — complete your purchase today and unlock instant access.</p>
                <p>Best regards,<br>The $siteurl Team</p>
            ";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: no-reply@$siteurl";

            mail($buyerEmail, $subject, $message, $headers);
        }
    }
    exit; // stop here for AJAX requests
}

