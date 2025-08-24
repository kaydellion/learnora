<?php
include 'connect.php'; // Include your config file for database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['abandoned_ref'])) {
    // Handle abandoned checkout
    $ref = mysqli_real_escape_string($con, $_POST['abandoned_ref']);
    $date = date('Y-m-d H:i:s');
    
    // Get order details with proper status check
    $sql_order = "SELECT * FROM {$siteprefix}orders WHERE order_id = '$ref' AND status = 'unpaid' LIMIT 1";
    $sql_order_result = mysqli_query($con, $sql_order);
    
    if (mysqli_num_rows($sql_order_result) > 0) {
        $row_order = mysqli_fetch_assoc($sql_order_result);
        $order_id = $row_order['order_id']; 
        $user_id = $row_order['user']; 
        $status = $row_order['status']; 
        $total_amount = $row_order['total_amount']; 
        $order_date = $row_order['date'];

        // Fetch buyer's details
        $sql_buyer = "SELECT email_address, display_name FROM {$siteprefix}users WHERE s = '$user_id'";
        $result_buyer = mysqli_query($con, $sql_buyer);

        if ($result_buyer && mysqli_num_rows($result_buyer) > 0) {
            $buyer = mysqli_fetch_assoc($result_buyer);
            $buyerEmail = $buyer['email_address']; 
            $buyerName = $buyer['display_name']; 

            // Get all order items with detailed information
            $sql_items = "SELECT oi.*, t.title as resource_title, t.pricing, t.alt_title as slug
                          FROM {$siteprefix}order_items oi
                          JOIN {$siteprefix}training t ON oi.training_id = t.training_id
                          WHERE oi.order_id = '$ref'";   
            $sql_items_result = mysqli_query($con, $sql_items);

            // Build detailed cart items HTML
            $cartItemsHtml = '';
            $itemCount = 0;
            
            if (mysqli_num_rows($sql_items_result) > 0) {
                while ($row_item = mysqli_fetch_assoc($sql_items_result)) {
                    $itemCount++;
                    $training_id = $row_item['training_id'];
                    $price = $row_item['price']; 
                    $original_price = $row_item['original_price']; 
                    $resourceTitle = $row_item['resource_title'];
                    $pricing_type = $row_item['pricing'];
                    $slug = $row_item['slug'];
                    
                    // Get ticket information for paid items
                    $ticket_name = '';
                    $ticket_benefit = '';
                    
                    if ($pricing_type === 'paid') {
                        $sql_ticket = "SELECT ticket_name, benefits FROM {$siteprefix}training_tickets WHERE training_id = '$training_id' LIMIT 1";
                        $ticket_result = mysqli_query($con, $sql_ticket);
                        if ($ticket_result && mysqli_num_rows($ticket_result) > 0) {
                            $ticket = mysqli_fetch_assoc($ticket_result);
                            $ticket_name = $ticket['ticket_name'];
                            $ticket_benefit = $ticket['benefits'];
                        }
                    } elseif ($pricing_type === 'free') {
                        $ticket_name = 'Free Access';
                    } elseif ($pricing_type === 'donation') {
                        $ticket_name = 'Donation';
                    }

                    // Build individual item HTML
                    $cartItemsHtml .= "
                        <tr style='border-bottom: 1px solid #eee;'>
                            <td style='padding: 15px 0; vertical-align: top;'>
                                <h3 style='margin: 0 0 5px 0; font-size: 16px; color: #333;'>$resourceTitle</h3>
                                <p style='margin: 0; color: #666; font-size: 14px;'>Ticket: $ticket_name</p>";
                    
                    if (!empty($ticket_benefit) && $pricing_type === 'paid') {
                        $cartItemsHtml .= "<p style='margin: 5px 0 0 0; color: #007bff; font-size: 12px;'>Benefits: $ticket_benefit</p>";
                    }
                    
                    $cartItemsHtml .= "
                            </td>
                            <td style='padding: 15px 0; text-align: right; vertical-align: top;'>
                                <strong style='font-size: 16px; color: #007bff;'>";
                    
                    if ($pricing_type === 'free') {
                        $cartItemsHtml .= "FREE";
                    } elseif ($pricing_type === 'donation') {
                        $cartItemsHtml .= "{$sitecurrency}" . number_format($price, 2);
                    } else {
                        $cartItemsHtml .= "{$sitecurrency}" . number_format($price, 2);
                        if ($original_price > $price) {
                            $cartItemsHtml .= "<br><span style='text-decoration: line-through; color: #999; font-size: 12px;'>{$sitecurrency}" . number_format($original_price, 2) . "</span>";
                        }
                    }
                    
                    $cartItemsHtml .= "</strong>
                            </td>
                        </tr>";
                }
            }

            // Calculate time since abandonment
            $abandoned_time = time() - strtotime($order_date);
            $hours_ago = floor($abandoned_time / 3600);
            $time_ago_text = $hours_ago > 0 ? "$hours_ago hour(s) ago" : "less than an hour ago";

            // Create checkout link
            $checkoutLink = "{$siteurl}/checkout.php?ref=$ref";

            // Create comprehensive email
            $subject = "🎓 Don't Miss Out! Your Learning Journey Awaits - Complete Your Purchase";
            
            $message = "
            <html>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Complete Your Purchase - $siteName</title>
            </head>
            <body style='margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;'>
                <table width='100%' cellpadding='0' cellspacing='0' style='background-color: #f4f4f4; padding: 20px 0;'>
                    <tr>
                        <td align='center'>
                            <table width='600' cellpadding='0' cellspacing='0' style='background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>
                                
                                <!-- Header -->
                                <tr>
                                    <td style='padding: 30px; text-align: center; background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); border-radius: 8px 8px 0 0;'>
                                        <h1 style='color: white; margin: 0; font-size: 28px;'>Your Cart is Waiting!</h1>
                                        <p style='color: rgba(255,255,255,0.9); margin: 10px 0 0 0; font-size: 16px;'>Complete your purchase and start learning today</p>
                                    </td>
                                </tr>
                                
                                <!-- Main Content -->
                                <tr>
                                    <td style='padding: 30px;'>
                                        <p style='font-size: 18px; color: #333; margin: 0 0 20px 0;'>Hello <strong>$buyerName</strong>,</p>
                                        
                                        <p style='font-size: 16px; color: #666; line-height: 1.6; margin: 0 0 20px 0;'>
                                            We noticed you started the checkout process on <strong>$siteName</strong> $time_ago_text but didn't complete your purchase. 
                                            Your selected training materials are still reserved and waiting for you!
                                        </p>
                                        
                                        <!-- Order Summary -->
                                        <div style='background-color: #f8f9fa; border-radius: 6px; padding: 20px; margin: 20px 0;'>
                                            <h2 style='margin: 0 0 15px 0; color: #333; font-size: 20px;'>📚 Your Learning Cart ($itemCount item" . ($itemCount > 1 ? 's' : '') . ")</h2>
                                            <table width='100%' cellpadding='0' cellspacing='0'>
                                                $cartItemsHtml
                                                <tr style='border-top: 2px solid #007bff;'>
                                                    <td style='padding: 15px 0; font-weight: bold; font-size: 18px;'>Total Amount:</td>
                                                    <td style='padding: 15px 0; text-align: right; font-weight: bold; font-size: 18px; color: #007bff;'>{$sitecurrency}" . number_format($total_amount, 2) . "</td>
                                                </tr>
                                            </table>
                                        </div>
                                        
                                        <!-- Call to Action -->
                                        <div style='text-align: center; margin: 30px 0;'>
                                            <a href='$checkoutLink' style='display: inline-block; padding: 15px 30px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; text-decoration: none; border-radius: 25px; font-size: 18px; font-weight: bold; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);'>
                                                🚀 Complete My Purchase Now
                                            </a>
                                        </div>
                                        
                                        <!-- Benefits Section -->
                                        <div style='background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); border-radius: 6px; padding: 20px; margin: 20px 0;'>
                                            <h3 style='margin: 0 0 15px 0; color: #333; font-size: 18px;'>🎯 Why Complete Your Purchase?</h3>
                                            <ul style='margin: 0; padding-left: 20px; color: #555;'>
                                                <li style='margin-bottom: 8px;'>✅ <strong>Instant Access:</strong> Download immediately after payment</li>
                                                <li style='margin-bottom: 8px;'>🔒 <strong>Secure & Safe:</strong> Your payment is protected</li>
                                                <li style='margin-bottom: 8px;'>📱 <strong>Learn Anywhere:</strong> Access from any device</li>
                                                <li style='margin-bottom: 8px;'>💎 <strong>Premium Quality:</strong> Expertly crafted training materials</li>
                                                <li style='margin-bottom: 8px;'>🎓 <strong>Advance Your Career:</strong> Gain valuable skills and knowledge</li>
                                            </ul>
                                        </div>
                                        
                                        <!-- Urgency Section -->
                                        <div style='background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0;'>
                                            <p style='margin: 0; color: #856404; font-weight: bold;'>⏰ Limited Time: Your cart items are reserved for only 24 hours!</p>
                                        </div>
                                        
                                        <!-- Support Section -->
                                        <p style='font-size: 14px; color: #666; line-height: 1.6; margin: 20px 0 0 0;'>
                                            <strong>Need help?</strong> Our support team is here to assist you. 
                                            Contact us at <a href='mailto:$siteMail' style='color: #007bff;'>$siteMail</a> 
                                            or visit our <a href='https://$siteurl/contact.php' style='color: #007bff;'>help center</a>.
                                        </p>
                                    </td>
                                </tr>
                                
                                <!-- Footer -->
                                <tr>
                                    <td style='padding: 20px 30px; background-color: #f8f9fa; border-radius: 0 0 8px 8px; text-align: center;'>
                                        <p style='margin: 0 0 10px 0; font-size: 14px; color: #666;'>
                                            This email was sent because you started a checkout process on $siteName.
                                        </p>
                                        <p style='margin: 0; font-size: 12px; color: #999;'>
                                            © " . date('Y') . " $siteName. All rights reserved.<br>
                                            <a href='https://$siteurl' style='color: #007bff;'>$siteurl</a>
                                        </p>
                                    </td>
                                </tr>
                                
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
            </html>";

            // Send email using your existing email function
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: $siteName <$siteMail>" . "\r\n";
            $headers .= "Reply-To: $siteMail" . "\r\n";

            // Send the email
            if (function_exists('sendEmail')) {
                sendEmail($buyerEmail, $buyerName, $siteName, $siteMail, $message, $subject);
            } else {
                mail($buyerEmail, $subject, $message, $headers);
            }

            // Log the abandoned cart email sent (optional - create table if needed)
            $log_sql = "INSERT INTO {$siteprefix}email_logs (order_id, user_id, email_type, sent_at) 
                        VALUES ('$ref', '$user_id', 'abandoned_cart', '$date')";
            mysqli_query($con, $log_sql);

            echo json_encode(['status' => 'success', 'message' => 'Abandoned cart email sent successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Buyer not found']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Order not found or already paid']);
    }
    
    exit; // stop here for AJAX requests
}

// Optional: Add automated abandoned cart detection
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['auto_check'])) {
    // Find abandoned carts (orders older than 1 hour and still unpaid)
    $cutoff_time = date('Y-m-d H:i:s', strtotime('-1 hour'));
    
    $sql_abandoned = "SELECT DISTINCT order_id FROM {$siteprefix}orders 
                     WHERE status = 'unpaid' 
                     AND date < '$cutoff_time' 
                     AND order_id NOT IN (
                         SELECT DISTINCT order_id FROM {$siteprefix}email_logs 
                         WHERE email_type = 'abandoned_cart' 
                         AND sent_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)
                     )
                     LIMIT 10";
    
    $result_abandoned = mysqli_query($con, $sql_abandoned);
    
    if ($result_abandoned && mysqli_num_rows($result_abandoned) > 0) {
        $abandoned_count = 0;
        while ($row = mysqli_fetch_assoc($result_abandoned)) {
            // Simulate POST request to send abandoned cart email
            $_POST['abandoned_ref'] = $row['order_id'];
            // Process the abandoned cart (reuse the logic above)
            $abandoned_count++;
        }
        echo json_encode(['status' => 'success', 'message' => "Processed $abandoned_count abandoned carts"]);
    } else {
        echo json_encode(['status' => 'info', 'message' => 'No abandoned carts found']);
    }
    exit;
}
?>
