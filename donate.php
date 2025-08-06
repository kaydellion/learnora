
<?php include "header.php"; 

$training_id = $_GET['training_id'] ?? '';
$user_id = $_GET['user_id'] ?? '';
$order_id = $_GET['order_id'] ?? '';
$affiliate_id = $_GET['affiliate_id'] ?? '';


?>


  <!-- Checkout Section -->
    <section id="checkout" class="checkout section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <div class="col-lg-8 mx-auto">
            <form id="donateForm">

  <div class="row mb-3">
    <div class="col-md-12 form-group">
      <label for="email">Email:</label>
      <input type="email" id="emails" class="form-control" value="<?php echo $email_address; ?>" placeholder="Enter your email" required readonly>
    </div>
  </div>

  <div class="row mb-3">
    <div class="col-md-12 form-group">
      <label for="amount">Amount:</label>
      <input type="number" id="amounts" class="form-control" min="100" required>
    </div>
  </div>
<div class="row mb-3">
 <button type="submit" class="btn btn-primary">Donate</button>

</div>
  <input type="hidden" id="user_ids" value="<?php echo $user_id; ?>">
  <input type="hidden" id="training_ids" value="<?php echo $training_id; ?>">
  <input type="hidden" id="order_ids" value="<?php echo $order_id; ?>">
  <input type="hidden" id="affiliate_ids" value="<?php echo $affiliate_id; ?>">
</div>
</div>
</form>
</div>
</section><!-- End Checkout Section -->
<script>
document.getElementById("donateForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const email = document.getElementById("emails").value;
  const amount = parseFloat(document.getElementById("amounts").value);
  const user_id = document.getElementById("user_ids").value;
  const training_id = document.getElementById("training_ids").value;
  const affiliate_id = document.getElementById("affiliate_ids").value;
  const siteurl = "<?php echo $siteurl; ?>";

  if (!email || isNaN(amount) || amount <= 0) {
    alert("Please enter a valid email and amount.");
    return;
  }

  const order_id = "ORDER_" + Math.floor(Math.random() * 1000000000);

  const options = {
    amount: amount, // VPay expects Naira (not Kobo)
    currency: 'NGN',
    domain: 'sandbox', // change to 'live' in production
    key: '<?php echo $apikey; ?>',
    email: email,
    transactionref: order_id,
    customer_logo: 'https://www.vpay.africa/static/media/vpayLogo.91e11322.svg',
    customer_service_channel: '+2348030007000, support@yourcompany.com',
    txn_charge: 6,
    txn_charge_type: 'flat',
    onSuccess: function(response) {
      window.location.href = siteurl + "backend/donate_payment?" +
        "order_id=" + encodeURIComponent(order_id) +
        "&user_id=" + encodeURIComponent(user_id) +
        "&amount=" + encodeURIComponent(amount) +
        "&training_id=" + encodeURIComponent(training_id) +
        "&affiliate_id=" + encodeURIComponent(affiliate_id) +
        "&ref=" + encodeURIComponent(order_id); // VPay uses your ref
    },
    onExit: function(response) {
      alert("Transaction was cancelled.");
    }
  };

  if (window.VPayDropin) {
    const { open } = VPayDropin.create(options);
    open();
  } else {
    alert("VPayDropin library not loaded.");
  }
});
</script>

<?php include "footer.php"; ?>