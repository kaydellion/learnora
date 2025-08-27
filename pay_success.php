<?php include "header.php"; 

// Get reference number (user ID) from Paystack
global $ref;
$ref = $_GET['ref'];
$date = date('Y-m-d H:i:s');
$attachments = []; // store training file paths to attach


// Get order details and order items
$sql_order = "SELECT * FROM ".$siteprefix."orders WHERE order_id = '$ref' AND status = 'unpaid'";
$sql_order_result = mysqli_query($con, $sql_order);
if (mysqli_affected_rows($con) > 0) {
    while ($row_order = mysqli_fetch_array($sql_order_result)) {
        $order_id = $row_order['order_id']; 
        $user_id = $row_order['user']; 
        $status = $row_order['status']; 
        $total_amount = $row_order['total_amount']; 
        $date = $row_order['date']; 
    }




// Fetch buyer's details
$sql_buyer = "SELECT email_address, display_name FROM ".$siteprefix."users WHERE s = '$user_id'";
$result_buyer = mysqli_query($con, $sql_buyer);

if ($result_buyer && mysqli_num_rows($result_buyer) > 0) {
    $buyer = mysqli_fetch_assoc($result_buyer);
    $email = $buyer['email_address']; // Buyer's email
    $username = $buyer['display_name']; // Buyer's name
}

// Get order items
$sql_items = "SELECT oi.*, t.title as resource_title , t.pricing
              FROM ".$siteprefix."order_items oi
              JOIN ".$siteprefix."training t ON oi.training_id = t.training_id
              WHERE oi.order_id = '$ref'";   
$sql_items_result = mysqli_query($con, $sql_items);

if (mysqli_affected_rows($con) > 0) {
    while ($row_item = mysqli_fetch_array($sql_items_result)) {
        $s = $row_item['s']; 
        $training_id = $row_item['training_id'];
        $price = $row_item['price']; 
        $original_price = $row_item['original_price']; 
        $loyalty_id = $row_item['loyalty_id']; 
        $affiliate_id = $row_item['affiliate_id']; 
        $order_id = $row_item['order_id']; 
        $date = $row_item['date'];   
        $resourceTitle = $row_item['resource_title']; // Fetch the resource title
      
// Initialize ticket information
$ticket_name = '';
$ticket_benefit = '';

// Get training pricing again (already fetched as $row_item)
$pricing_type = $row_item['pricing'];

if ($pricing_type === 'paid') {
    // Get the ticket details
    $sql_ticket = "SELECT ticket_name, benefits FROM {$siteprefix}training_tickets WHERE s = '$s' LIMIT 1";
    $ticket_result = mysqli_query($con, $sql_ticket);
    if ($ticket_result && mysqli_num_rows($ticket_result) > 0) {
        $ticket = mysqli_fetch_assoc($ticket_result);
        $ticket_name = $ticket['ticket_name'];
        $ticket_benefit = $ticket['benefits'];
    }



} elseif ($pricing_type === 'free') {
    $ticket_name = 'Free';
} else if ($pricing_type === 'donate') {
    $ticket_name = 'Donate';
}
// Initialize email message body
$emailMessageBody = '';
 if (!empty($ticket_benefit) AND $pricing_type === 'paid') {
    $emailMessageBody .= "<p><strong>Benefit:</strong> $ticket_benefit</p>";
}
else  {
$emailMessageBody .= " ";
}
    

        // Check if the item has an affiliate
        if ($affiliate_id != 0) {
            // Get affiliate details
            $sql_affiliate = "SELECT * FROM ".$siteprefix."users WHERE affliate = '$affiliate_id'";
            $sql_affiliate_result = mysqli_query($con, $sql_affiliate);
            if (mysqli_affected_rows($con) > 0) {
                while ($row_affiliate = mysqli_fetch_array($sql_affiliate_result)) {
                    $affiliate_user_id = $row_affiliate['s']; 
                    $affiliate_amount = $price * ($affiliate_percentage / 100);
                    
                    // Update affiliate wallet
                    $sql_update_affiliate_wallet = "UPDATE ".$siteprefix."users SET wallet = wallet + $affiliate_amount WHERE affliate = '$affiliate_id'";
                    mysqli_query($con, $sql_update_affiliate_wallet);
                    
                    // Insert into affiliate transactions
                    $note = "Affiliate Earnings from Order ID: ".$order_id;
                    $type = "credit";
                    insertWallet($con, $affiliate_user_id, $affiliate_amount, $type, $note, $date);
                    
                    // Notify affiliate
                    $message = "You have earned $sitecurrency$affiliate_amount from Order ID: $order_id";
                    $link = "wallet.php";
                    $msgtype = "wallet";
                    $status = 0;
                    insertaffiliateAlert($con, $affiliate_user_id, $message, $link, $date, $msgtype, $status);
                    insertAffliatePurchase($con, $s, $affiliate_amount, $affiliate_id,$date);
                }
            }
        }


        // Get seller ID
        $sql_seller = "SELECT u.s AS user, u.* FROM ".$siteprefix."users u LEFT JOIN ".$siteprefix."training t ON t.user=u.s WHERE t.training_id = '$training_id'";
        $sql_seller_result = mysqli_query($con, $sql_seller);
        if (mysqli_affected_rows($con) > 0) {
            while ($row_seller = mysqli_fetch_array($sql_seller_result)) {
                $seller_id = $row_seller['user']; 
                $vendorEmail = $row_seller['email_address'];
                $vendorName = $row_seller['display_name'];
                $sellertype = $row_seller['type'];
                $admin_commission=0;

                if($sellertype=="user"){
        // Admin commission deduction
        $admin_commission = $price * ($escrowfee / 100);
        $sql_insert_commission = "INSERT INTO ".$siteprefix."profits (amount, training_id, order_id,type, date) VALUES ('$admin_commission', '$training_id', '$order_id', 'Order Payment','$date')";
        mysqli_query($con, $sql_insert_commission);
        
        // Notify admin
        $message = "Admin Commission of $sitecurrency$admin_commission from Order ID: $order_id";
        $link = "profits.php";
        $msgtype = "profits";
        insertadminAlert($con, $message, $link, $date, $msgtype, 0);
        } 

        
  else if($sellertype=="admin"||$sellertype=="sub-admin"){
        // Admin commission deduction
        $admin_commission = $price;
        $sql_insert_commission = "INSERT INTO ".$siteprefix."profits (amount, training_id, order_id,type, date) VALUES ('$admin_commission', '$training_id', '$order_id', 'Order Payment','$date')";
        mysqli_query($con, $sql_insert_commission);
            
        // Notify admin
        $message = "Admin Commission of $sitecurrency$admin_commission from Order ID: $order_id";
        $link = "profits.php";
        $msgtype = "profits";
        insertadminAlert($con, $message, $link, $date, $msgtype, 0);
        }
                
                // Credit seller
                $seller_amount = $price - $admin_commission;
                $sql_update_seller_wallet = "UPDATE ".$siteprefix."users SET wallet = wallet + $seller_amount WHERE s = '$seller_id'";
                mysqli_query($con, $sql_update_seller_wallet);
                
                // Insert seller transactions
                $note = "Payment from Order ID: ".$order_id;
                $type = "credit";
                insertWallet($con, $seller_id, $seller_amount, $type, $note, $date);
                
                // Notify seller
                insertAlert($con, $seller_id, "You have received $sitecurrency$seller_amount from Order ID: $order_id", $date, 0);
                
// Enhanced email content
$emailSubject = "New Sale on Project Report Hub. Let's Keep the Momentum Going!";
$emailMessage = "<p>Great news! A new sale has just been made on $siteurl.</p>
<p><strong>Title of Resource:</strong> $resourceTitle</p>
<p><strong>Ticket:</strong> $ticket_name</p>
<p><strong>Price:</strong> $sitecurrencyCode$price</p>
$emailMessageBody
<p><strong>Earning:</strong> $sitecurrencyCode$seller_amount</p>
<p>This is a win for our community and a reminder that students and researchers are actively exploring and purchasing resources from our platform every day.</p>
<p>If you havenÃ¢â‚¬â„¢t updated your listings recently, now is a great time to:</p>
<ol>
    <li>Refresh your content and pricing</li>
    <li>Promote your reports on social media</li>
    <li>Add new documents that reflect trending industries</li>
</ol>
<p>The more visible and updated your resources are, the more sales opportunities you create.</p>
<p>Let's keep the momentum going and continue providing high-value insights to Nigeria and the world!</p>";

// Send email to seller
sendEmail($vendorEmail, $vendorName, $siteName, $siteMail, $emailMessage, $emailSubject);
            }
        }
    }
}

// Update order status to paid
$sql_update_order = "UPDATE ".$siteprefix."orders SET status = 'paid',date='$currentdatetime' WHERE order_id = '$ref'";
if (mysqli_query($con, $sql_update_order)) {

    // Get all items in the order
    $sql_items = "SELECT oi.*, t.pricing 
                  FROM ".$siteprefix."order_items oi
                  JOIN ".$siteprefix."training t ON oi.training_id = t.training_id
                  WHERE oi.order_id = '$ref'";
    $sql_items_result = mysqli_query($con, $sql_items);

    if (mysqli_num_rows($sql_items_result) > 0) {
        while ($row_item = mysqli_fetch_assoc($sql_items_result)) {
            $training_id = $row_item['training_id'];
            $pricing = $row_item['pricing'];

            // Only proceed if the training is paid
            if ($pricing == 'paid') {
                // Fetch current seatremain
                $seat_sql = "SELECT seatremain FROM ".$siteprefix."training_tickets WHERE training_id = '$training_id' LIMIT 1";
                $seat_result = mysqli_query($con, $seat_sql);

                if ($seat_result && mysqli_num_rows($seat_result) > 0) {
                    $seat_data = mysqli_fetch_assoc($seat_result);
                    $current_seats = (int)$seat_data['seatremain'];

                    // Subtract 1 seat
                    $new_seats = max(0, $current_seats - 1); // Prevent negative seats

                    // Update seatremain
                    $update_seat_sql = "UPDATE ".$siteprefix."training_tickets SET seatremain = '$new_seats' WHERE training_id = '$training_id'";
                    mysqli_query($con, $update_seat_sql);
                }
            }
        }
    }

}

// Send order confirmation email
$subject = "Order Confirmation";

// === Fetch order items (grouping event dates into one row per training) ===
$sql_items = "SELECT 
                oi.*, 
                t.*, 
                GROUP_CONCAT(
                    DISTINCT CONCAT(
                        DATE_FORMAT(tem.event_date, '%b %d, %Y'),
                        ' (',
                        DATE_FORMAT(tem.start_time, '%h:%i %p'),
                        ' – ',
                        DATE_FORMAT(tem.end_time, '%h:%i %p'),
                        ')'
                    )
                    ORDER BY tem.event_date SEPARATOR ', '
                ) AS event_datetime,
    tt.ticket_name
FROM {$siteprefix}order_items oi
JOIN {$siteprefix}training t ON oi.training_id = t.training_id
LEFT JOIN {$siteprefix}training_event_dates tem ON t.training_id = tem.training_id
         LEFT JOIN {$siteprefix}training_tickets tt 
                   ON oi.item_id = tt.s   
WHERE oi.order_id = '$ref'
GROUP BY oi.item_id";




$sql_items_result = mysqli_query($con, $sql_items);

$emailDetails = [];
$attachments = []; // initialize once outside loop

while ($row = mysqli_fetch_assoc($sql_items_result)) {
    $training_id = $row['training_id'];

    // Dates and Times
$date_time_str = $row['event_datetime'] ?? '';

    $format = ucfirst($row['delivery_format']);
    $details = '';

    // === Address/Link formats ===
    if ($format === 'Physical') {
        $fields = [
            'physical_address' => 'Address',
            'physical_state' => 'State',
            'physical_lga' => 'LGA',
            'physical_country' => 'Country',
            'foreign_address' => 'Foreign Address'
        ];
        foreach ($fields as $col => $label) {
            if (!empty($row[$col])) {
                $details .= "<li><strong>$label:</strong> " . htmlspecialchars($row[$col]) . "</li>";
            }
        }
    } elseif ($format === 'Hybrid') {
        $fields = [
            'hybrid_physical_address' => 'Physical Address',
            'hybrid_web_address' => 'Web Address',
            'hybrid_state' => 'State',
            'hybrid_lga' => 'LGA',
            'hybrid_country' => 'Country',
            'hybrid_foreign_address' => 'Foreign Address'
        ];
        foreach ($fields as $col => $label) {
            if (!empty($row[$col])) {
                $details .= "<li><strong>$label:</strong> " . htmlspecialchars($row[$col]) . "</li>";
            }
        }
    } elseif ($format === 'Online') {
        if (!empty($row['web_address'])) {
            $details .= "<li><strong>Link to join:</strong> <a href='" . htmlspecialchars($row['web_address']) . "'>" . htmlspecialchars($row['web_address']) . "</a></li>";
        }
    }

    // === Training Materials attachments ===
    if ($format === 'Text' || $format === 'Video' || $format === 'Video_text') {
        $details .= "<li><strong>Training Materials:</strong> (attached to this email)</li>";

        // Video modules
        if ($format === 'Video' || $format === 'Video_text') {
            $video_sql = "SELECT * FROM {$siteprefix}training_video_modules WHERE training_id='$training_id'";
            $video_res = mysqli_query($con, $video_sql);
            while ($vm = mysqli_fetch_assoc($video_res)) {
                if (!empty($vm['file_path'])) {
                    $filePath = $documentPath . $vm['file_path'];
                    if (file_exists($filePath)) {
                        $attachments[] = $filePath;
                    }
                }
            }
        }

        // Text modules
        if ($format === 'Text' || $format === 'Video_text') {
            $text_sql = "SELECT * FROM {$siteprefix}training_texts_modules WHERE training_id='$training_id'";
            $text_res = mysqli_query($con, $text_sql);
            while ($tm = mysqli_fetch_assoc($text_res)) {
                if (!empty($tm['file_path'])) {
                    $filePath = $documentPath . $tm['file_path'];
                    if (file_exists($filePath)) {
                        $attachments[] = $filePath;
                    }
                }
            }
        }
    }

    // Ticket name / price
    $ticket_name = !empty($row['ticket_name']) ? $row['ticket_name'] : 
        (($row['pricing'] === 'free') ? 'Free' : (($row['pricing'] === 'donate') ? 'Donate' : ''));
    $amount_paid = number_format($row['price'], 2);

    $emailDetails[] = [
        'training_title' => $row['title'],
        'date_time_str'  => $date_time_str,
        'format' => $format,
        'ticket_name' => $ticket_name,
        'amount_paid' => $amount_paid,
        'details' => $details
    ];
}

// === Build email message ===
$user_first_name = explode(' ', $username)[0];
$emailMessage = "<p>Hi $user_first_name,</p>";
$emailMessage .= "<p>Thank you for registering for:</p>";

foreach ($emailDetails as $ed) {
    $emailMessage .= "<ul>
        <li>🎓 <strong>Training:</strong> {$ed['training_title']}</li>
        <li>📅 <strong>Schedule:</strong> {$ed['date_time_str']}</li>
        <li>🌍 <strong>Format:</strong> {$ed['format']}</li>
        <li>⭐️ <strong>Ticket:</strong> {$ed['ticket_name']}</li>
        <li>💰 <strong>Amount Paid:</strong> ₦{$ed['amount_paid']}</li>
    </ul>
    <p>Here's what to expect:</p>
    <ul>
        {$ed['details']}
        <li>You'll get a reminder 24 hours before the event.</li>
        <li>Save this email, it contains your access details.</li>
    </ul>
    <hr>";
}

// === Send email with attachments ===
$subject = "Your Training Registration Details";
sendEmail2($email, $username, $siteName, $siteMail, $emailMessage, $subject, $attachments);


}
?>

<div class="container mt-5 mb-5">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Payment Successful!</h4>
        <p>Your payment was successful. An email has been sent to you with your invoice.</p>
        <hr>
        <p class="mb-0">Thank you for your order.</p>
    </div>
    <div class="card text-center">
        <div class="card-header bg-success text-white">Thank You for Your Purchase!</div>
        <div class="card-body">
            <h5 class="card-title">Order processed successfully.</h5>
            <a href="my_orders.php" class="btn btn-primary mt-4"> Back to My Orders</a>
        </div>
        <div class="card-footer text-muted">We appreciate your patronage!</div>
    </div>
    <!-- Table of Purchased Reports -->
<div class="mt-5">
    <h3>Your Purchased Trainings</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
               <th>Training Title</th>
                <th>Price</th>
                <th>Ticket</th>
                 <th></th>
            </tr>
        </thead>
       <tbody>
<?php
$sql_items = "SELECT oi.*, t.title, t.pricing
              FROM {$siteprefix}order_items oi
              JOIN {$siteprefix}training t ON oi.training_id = t.training_id
              WHERE oi.order_id = '$ref'";
$sql_items_result = mysqli_query($con, $sql_items);

if (mysqli_num_rows($sql_items_result) > 0) {
    while ($row_item = mysqli_fetch_assoc($sql_items_result)) {
        $training_title = htmlspecialchars($row_item['title']);
        $pricing_type = strtolower($row_item['pricing']);
        $training_id = $row_item['training_id'];
        $item_id = $row_item['item_id'];
        $order_id = $row_item['order_id'];
        $price = number_format($row_item['price'], 2);

        // Default ticket info
        $ticket_name = '';
        $ticket_benefit = '';

        if ($pricing_type === 'paid') {
            // Get ticket name and benefit using item_id as ticket_id
            $sql_ticket = "SELECT ticket_name, benefits FROM {$siteprefix}training_tickets WHERE s= '$item_id' LIMIT 1";
            $ticket_result = mysqli_query($con, $sql_ticket);
            if ($ticket_result && mysqli_num_rows($ticket_result) > 0) {
                $ticket = mysqli_fetch_assoc($ticket_result);
                $ticket_name = htmlspecialchars($ticket['ticket_name']);
                $ticket_benefit = htmlspecialchars($ticket['benefits']);
            } else {
                $ticket_name = 'Paid Ticket';
            }
        } elseif ($pricing_type === 'free') {
            $ticket_name = 'Free';
        } elseif ($pricing_type === 'donate') {
            $ticket_name = 'Donate';
        }

        echo "<tr>";
        echo "<td><strong>$training_title</strong></td>";
        echo "<td>₦$price</td>";
        echo "<td>";
        echo "<strong>$ticket_name</strong>";
        if (!empty($ticket_benefit)) {
            echo "<br><small>Benefit: $ticket_benefit</small>";
        }
        echo "</td>";
        echo "<td>
                <a href='view-tickets.php?training_id=$training_id&item_id=$item_id&order_id=$order_id' class='btn btn-sm btn-success' target='_blank'>View Ticket</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No trainings found.</td></tr>";
}
?>
</tbody>

    </table>
       <div class="alert alert-info mt-3">
        Please check your email for your event access details and confirmation.<br>
        You can also go to your <a href="dashboard.php" class="btn btn-primary btn-sm">Dashboard</a> to view your trainings.
    </div>
</div>
</div>
<?php include "footer.php"; ?>