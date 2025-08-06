<?php
// filepath: c:\wamp64\www\text\learnora\ticket.php
require_once "backend/connect.php";

$order_id = isset($_GET['order_id']) ? mysqli_real_escape_string($con, $_GET['order_id']) : '';
$training_id = isset($_GET['training_id']) ? mysqli_real_escape_string($con, $_GET['training_id']) : '';

if (!$order_id || !$training_id) {
    die("Invalid ticket link.");
}

// Fetch ticket details
$sql = "SELECT 
            o.order_id,
            u.display_name,
            t.title,
            t.delivery_format,
            t.pricing,
            tt.ticket_name,
            tt.benefits,
            tem.event_date,
            tem.start_time,
            tem.end_time
        FROM {$siteprefix}orders o
        JOIN {$siteprefix}order_items oi ON o.order_id = oi.order_id
        JOIN {$siteprefix}training t ON oi.training_id = t.training_id
        JOIN {$siteprefix}users u ON o.user = u.s
        LEFT JOIN {$siteprefix}training_tickets tt ON t.training_id = tt.training_id
        LEFT JOIN {$siteprefix}training_event_dates tem ON t.training_id = tem.training_id
        WHERE o.order_id = '$order_id' AND t.training_id = '$training_id'
        LIMIT 1";
$result = mysqli_query($con, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Ticket not found.");
}

$row = mysqli_fetch_assoc($result);

// Set ticket name for free/donate if not set
if (empty($row['ticket_name'])) {
    if ($row['pricing'] === 'free') {
        $row['ticket_name'] = 'Free';
    } elseif ($row['pricing'] === 'donate') {
        $row['ticket_name'] = 'Donate';
    } else {
        $row['ticket_name'] = 'Standard';
    }
}

// Format event date/time
$date_str = '';
$time_str = '';
if (!empty($row['event_date'])) {
    $date_str = date('M d, Y', strtotime($row['event_date']));
}
if (!empty($row['start_time']) && !empty($row['end_time'])) {
    $time_str = date('h:i A', strtotime($row['start_time'])) . ' - ' . date('h:i A', strtotime($row['end_time']));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Training Ticket</title>
    <style>
        .ticket-container {
            max-width: 500px;
            margin: 40px auto;
            border: 2px dashed #28a745;
            border-radius: 16px;
            padding: 32px 24px;
            background: #f9fff9;
            box-shadow: 0 2px 12px #0001;
            font-family: 'Poppins', Arial, sans-serif;
        }
        .ticket-header {
            text-align: center;
            color: #28a745;
            margin-bottom: 16px;
        }
        .ticket-details {
            font-size: 16px;
            margin-bottom: 16px;
        }
        .ticket-details strong {
            color: #333;
        }
        .print-btn, .pdf-btn {
            display: inline-block;
            margin: 12px 8px 0 0;
            padding: 10px 28px;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }
        @media print {
            .print-btn, .pdf-btn { display: none; }
        }
    </style>
    <!-- html2pdf.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</head>
<body>
    <div id="ticket-content" class="ticket-container">
        <h2 class="ticket-header">Training Entry Ticket</h2>
        <div class="ticket-details">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($row['display_name']); ?></p>
            <p><strong>Training:</strong> <?php echo htmlspecialchars($row['title']); ?></p>
            <p><strong>Format:</strong> <?php echo ucfirst(htmlspecialchars($row['delivery_format'])); ?></p>
            <p><strong>Ticket Type:</strong> <?php echo htmlspecialchars($row['ticket_name']); ?></p>
            <?php if (!empty($row['benefits'])): ?>
                <p><strong>Benefits:</strong> <?php echo htmlspecialchars($row['benefits']); ?></p>
            <?php endif; ?>
            <?php if ($date_str): ?>
                <p><strong>Date:</strong> <?php echo $date_str; ?></p>
            <?php endif; ?>
            <?php if ($time_str): ?>
                <p><strong>Time:</strong> <?php echo $time_str; ?></p>
            <?php endif; ?>
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?></p>
            <p><strong>Date Issued:</strong> <?php echo date('M d, Y'); ?></p>
        </div>
    </div>
    <button class="print-btn" onclick="window.print()">Print Ticket</button>
    <button class="pdf-btn" onclick="downloadPDF()">Download as PDF</button>
    <small style="display:block;margin-top:10px;color:#888;">Tip: You can also use your browser's Print &rarr; Save as PDF.</small>
    <script>
    function downloadPDF() {
      var element = document.getElementById('ticket-content');
      var opt = {
        margin:       0.2,
        filename:     'ticket_<?php echo htmlspecialchars($order_id . "_" . $training_id); ?>.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'in', format: 'A4', orientation: 'portrait' }
      };
      html2pdf().set(opt).from(element).save();
    }
    </script>
</body>
</html>