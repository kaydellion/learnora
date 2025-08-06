<?php include "header.php";

if (!isset($_GET['order_id'])) {
    echo "Invalid Order ID.";
    exit();
}

$order_id = $_GET['order_id'];

// Fetch order
$sql = "SELECT * FROM {$siteprefix}orders WHERE order_id = ? AND user = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("ss", $order_id, $user_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows == 0) {
    echo "Order not found.";
    exit();
}

$order = $order_result->fetch_assoc();

// Fetch user info (for buyer's name)
$user_sql = "SELECT first_name, last_name FROM {$siteprefix}users WHERE s = ?";
$user_stmt = $con->prepare($user_sql);
$user_stmt->bind_param("s", $user_id);
$user_stmt->execute();
$user_info = $user_stmt->get_result()->fetch_assoc();
$buyer_name = $user_info ? $user_info['first_name'] . ' ' . $user_info['last_name'] : '';

// Fetch ordered items with ticket type
$sql_items = "SELECT 
    oi.*, 
    t.title, t.alt_title, 
    ti.picture, 
    tt.price AS ticket_price, 
    tt.ticket_name, 
    tt.benefits, 
    t.pricing
FROM {$siteprefix}order_items oi 
LEFT JOIN {$siteprefix}training t ON oi.training_id = t.training_id 
LEFT JOIN {$siteprefix}training_images ti ON t.training_id = ti.training_id
LEFT JOIN {$siteprefix}training_tickets tt ON tt.s = oi.item_id
WHERE oi.order_id = ?";
$stmt = $con->prepare($sql_items);
$stmt->bind_param("s", $order_id);
$stmt->execute();
$items_result = $stmt->get_result();
?>

<div class="container mt-5 mb-5">
    <h2 class="mb-4">Order Details</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Order ID: #<?= htmlspecialchars($order['order_id']) ?></h5>  
            <p><strong>Buyer Name:</strong> <?= htmlspecialchars($buyer_name) ?></p>
            <p><strong>Date:</strong> <?= formatDateTime($order['date']) ?></p>
            <p><strong>Status:</strong> 
                <span class="badge bg-<?= ($order['status'] === 'Completed' || $order['status'] === 'paid') ? 'success' : 'warning'; ?>">
                    <?= ucfirst($order['status']) ?>
                </span>
            </p>
            <p><strong>Total Amount:</strong> ₦<?= formatNumber($order['total_amount'], 2) ?></p>
        </div>
    </div>

    <h4>Items Purchased</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Ticket Type</th>
                    <th>Original Price</th>
                    <th>Discounted Price</th>
                    <th>Quantity</th>
                    <th>Review</th>
                    <th>Download Ticket</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $items_result->fetch_assoc()) {
                    $ticketType = 'Paid';
                    if (strtolower($item['pricing']) === 'free') {
                        $ticketType = 'Free';
                    } elseif (strtolower($item['pricing']) === 'donate') {
                        $ticketType = 'Donate';
                    }

                    $ticketLink = "view-tickets.php?training_id={$item['training_id']}&order_id={$order_id}&item_id={$item['item_id']}";
                    ?>
                    <tr>
                        <td>
                            <img src="<?= $imagePath . '/' . $item['picture'] ?>" alt="Image" style="width:50px; height:auto;">
                        </td>
                        <td><?= htmlspecialchars($item['title']) ?></td>
                        <td><?= $ticketType ?></td>
                        <td>₦<?= formatNumber($item['original_price'], 2) ?></td>
                        <td>₦<?= formatNumber($item['price'], 2) ?></td>
                        <td>1</td>
                        <td>
                            <a href="<?= $siteurl . '/events/' . $item['alt_title'] ?>">Give Review</a>
                        </td>
                        <td>
                            <a href="<?= $ticketLink ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                                View Ticket
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <a href="my_orders.php" class="btn btn-primary mt-3">Back to My Orders</a>
</div>

<?php include "footer.php"; ?>
