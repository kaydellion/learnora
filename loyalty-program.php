
<?php include "header.php";

?>

 <div class="container mt-5">
        <div class="row">
        <div class="col-lg-12">
            <h3>Loyalty Program</h3>
           <p>
        At <strong>Learnora.ng</strong>, we’re passionate about supporting your growth through continuous learning. Our Loyalty Program is designed to reward returning learners with exclusive discounts and priority access—the more you learn, the more you save!
    </p>
    <p>
        Choose from one of our tailored subscription packages and enjoy automatic discounts every time you purchase a course, register for a seminar, or download a premium learning resource.
    </p>
        </div>
</div>
       
        <div class="row mt-3 plans">
        <?php
$query = "SELECT * FROM ".$siteprefix."subscription_plans WHERE status = 'active' ORDER BY s DESC";
$result = mysqli_query($con, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $plan_id = $row['s'];
        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
        $discount = $row['discount'];
        $downloads = $row['downloads'];
        $duration = $row['duration'];
        $benefits = explode(',', $row['benefits']); // Convert benefits into an array
        $status = $row['status'];
        $no_of_duration = $row['no_of_duration'];
        $image_path = !empty($row['image']) ? $imagePath.$row['image'] : $imagePath."default4.jpg";
        $created_at = $row['created_at'];

        include "plan-card.php"; // Include your plan display template
    }
} else {
    debug('No subscription plans found.');
}
?>

</div></div>
<!-- Modal for login prompt -->
<!-- Modal for login prompt -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login Required</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>You need to be logged in to subscribe to a plan.</p>
        <a href="login.php" class="btn btn-primary w-100">Go to Login</a>
      </div>
    </div>
  </div>
</div>

<?php include "footer.php"; ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let payButtons = document.querySelectorAll(".payButton");

    payButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            let planId = button.dataset.planId;
            let amount = parseFloat(button.dataset.amount); // VPay accepts amount in Naira, no need to multiply by 100
            let planName = button.dataset.planName;
            let userId = button.dataset.userId;
            let email = button.dataset.email;

            if (!email || isNaN(amount)) {
                alert("Invalid payment details. Please try again.");
                return;
            }

            const ref = 'VP-' + Date.now() + '-' + Math.floor(Math.random() * 1000);
            const siteurl = document.getElementById('siteurl').value;

            const options = {
                amount: amount,
                currency: 'NGN',
                domain: 'live', // change to 'live' when you go live
                key: '<?php echo $apikey; ?>', // your VPay public key
                email: email,
                transactionref: ref,
                customer_logo: 'https://www.vpay.africa/static/media/vpayLogo.91e11322.svg',
                customer_service_channel: '+2348030007000, support@yourcompany.com',
                txn_charge: 6,
                txn_charge_type: 'flat',
                onSuccess: function (response) {
                    window.location.href = siteurl + 'backend/verify_payment.php?action=verify_payment&reference=' + ref + '&plan_id=' + planId + '&user_id=' + userId;
                },
                onExit: function (response) {
                    alert("Payment was canceled.");
                }
            };

            if (window.VPayDropin) {
                const { open } = VPayDropin.create(options);
                open();
            } else {
                alert("VPayDropin library not loaded.");
            }
        });
    });
});
</script>