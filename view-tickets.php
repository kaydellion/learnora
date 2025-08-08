<?php
require_once 'backend/connect.php';

$training_id = mysqli_real_escape_string($con, $_GET['training_id']);
$order_id    = mysqli_real_escape_string($con, $_GET['order_id']);
$item_id     = mysqli_real_escape_string($con, $_GET['item_id']);

// Query to fetch ticket + user info
$sql = "SELECT 
    oi.*, 
    t.*, 
    tem.event_date, 
    tem.start_time, 
    tem.end_time, 
    tt.ticket_name,
    tt.benefits,
    tu.first_name AS training_creator_first_name,
    tu.last_name AS training_creator_last_name,
    ou.first_name AS order_user_first_name,
    ou.last_name AS order_user_last_name
FROM {$siteprefix}order_items oi
JOIN {$siteprefix}training t ON oi.training_id = t.training_id
LEFT JOIN {$siteprefix}training_event_dates tem ON t.training_id = tem.training_id
LEFT JOIN {$siteprefix}training_tickets tt ON tt.s = oi.item_id
LEFT JOIN {$siteprefix}orders o ON o.order_id = oi.order_id
LEFT JOIN {$siteprefix}users ou ON ou.s = o.user        
LEFT JOIN {$siteprefix}users tu ON tu.s = t.user        
WHERE oi.training_id = '$training_id' 
  AND oi.order_id = '$order_id' 
  AND oi.item_id = '$item_id'
LIMIT 1";

$res = mysqli_query($con, $sql);
if (!$res || mysqli_num_rows($res) == 0) {
    echo "Ticket not found.";
    exit;
}

$row = mysqli_fetch_assoc($res);

// Format date and time
$date_str = '';
$time_str = '';
if (!empty($row['event_date']) && !empty($row['start_time']) && !empty($row['end_time'])) {
    $date_str = date('M d, Y', strtotime($row['event_date']));
    $time_str = date('h:i A', strtotime($row['start_time'])) . ' - ' . date('h:i A', strtotime($row['end_time']));
}

// Ticket logic
$pricing = strtolower($row['pricing']);
if ($pricing === 'free') {
    $ticket_name = 'Free';
    $ticket_benefit = 'Access to free training';
} elseif ($pricing === 'donate') {
    $ticket_name = 'Donate';
    $ticket_benefit = 'Donation-based access';
} else {
    $ticket_name = $row['ticket_name'] ?: 'Paid Ticket';
    $ticket_benefit = $row['benefits'] ?? '';
}

// Location logic
$format = ucfirst($row['delivery_format']);
$location_details = '';
if ($format === 'Physical') {
    $fields = [
        'physical_address' => 'Address',
        'physical_state' => 'State',
        'physical_lga' => 'LGA',
        'physical_country' => 'Country',
        'foreign_address' => 'Foreign Address'
    ];
} elseif ($format === 'Hybrid') {
    $fields = [
        'hybrid_physical_address' => 'Physical Address',
        'hybrid_web_address' => 'Web Address',
        'hybrid_state' => 'State',
        'hybrid_lga' => 'LGA',
        'hybrid_country' => 'Country',
        'hybrid_foreign_address' => 'Foreign Address'
    ];
} else {
    $fields = [];
}

foreach ($fields as $key => $label) {
    if (!empty($row[$key])) {
        $location_details .= "<li><strong>$label:</strong> " . htmlspecialchars($row[$key]) . "</li>";
    }
}

// User full name
$buyer_name = trim($row['order_user_first_name'] . ' ' . $row['order_user_last_name']);
$trainer_name = trim($row['training_creator_first_name'] . ' ' . $row['training_creator_last_name']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Training Ticket</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: #f8f9fa;
        }
        .ticket-box {
            border: double 4px #ccc;
            padding: 30px;
            margin: 20px auto;
            background-color: #fff;
            max-width: 800px;
        }
        .ticket-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .ticket-header img {
            max-height: 60px;
            margin-bottom: 10px;
        }
        .ticket-title {
            font-size: 20px;
            font-weight: bold;
        }
        .ticket-section p {
            margin-bottom: 10px;
        }
        #downloadBtn {
            display: block;
            margin: 20px auto;
        }

        @media print {
            #downloadBtn {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<div class="container" id="ticketContent">
    <div class="ticket-box shadow">

        <div class="ticket-header">
            <img src="assets/img/learnora-logo.png" alt="Logo">
            <div class="ticket-title"><?= htmlspecialchars($row['title']) ?></div>
        </div>

        <div class="ticket-section">
            <p><strong>Events:</strong> <?= htmlspecialchars($row['title']) ?></p>
            <p><strong>Trainer:</strong> <?= htmlspecialchars($trainer_name) ?></p>
            <p><strong>Buyer Name:</strong> <?= htmlspecialchars($buyer_name) ?></p>
            <p><strong>Date:</strong> <?= $date_str ?></p>
            <p><strong>Time:</strong> <?= $time_str ?></p>
            <p><strong>Delivery Format:</strong> <?= $format ?></p>

            <?php if (!empty($location_details)): ?>
                <p><strong>Location:</strong></p>
                <ul><?= $location_details ?></ul>
            <?php endif; ?>

            <p><strong>Ticket:</strong> <?= htmlspecialchars($ticket_name) ?></p>

            <?php if (!empty($ticket_benefit)): ?>
                <p><strong>Benefit:</strong> <?= htmlspecialchars($ticket_benefit) ?></p>
            <?php endif; ?>

            <p><strong>Order ID:</strong> <?= htmlspecialchars($order_id) ?></p>
            <p><strong>Amount Paid:</strong> ₦<?= number_format($row['price'], 2) ?></p>
        </div>
    </div>

    <button onclick="downloadPDF()" id="downloadBtn" class="btn btn-primary">Download Ticket as PDF</button>
</div>

<!-- jsPDF & html2canvas -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    async function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const ticket = document.getElementById('ticketContent');

        // Hide button before capture
        const button = document.getElementById('downloadBtn');
        button.style.display = 'none';

        const canvas = await html2canvas(ticket, { scale: 2 });
        const imgData = canvas.toDataURL('image/png');

        const pdf = new jsPDF('p', 'mm', 'a4');
        const width = pdf.internal.pageSize.getWidth();
        const height = (canvas.height * width) / canvas.width;

        pdf.addImage(imgData, 'PNG', 0, 0, width, height);
        pdf.save("training_ticket.pdf");

        // Show button again
        button.style.display = 'block';
    }
</script>
</body>
</html>
