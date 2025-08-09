
<?php 
include "header.php"; 
include "event-details.php";

//get and decode affliate_id if it exists
$affliate_id = isset($_GET['affiliate']) ? base64_decode($_GET['affiliate']) : 0;
$event_passed = false;

if (!empty($event_dates)) {
    $now = date('Y-m-d H:i:s');
    $all_past = true;

    foreach ($event_dates as $ed) {
        // Ensure both date and time are valid before checking
        if (!empty($ed['event_date']) && !empty($ed['end_time'])) {
            $event_end = $ed['event_date'] . ' ' . $ed['end_time'];

            if ($event_end >= $now) {
                $all_past = false; // Found an upcoming or ongoing event
                break;
            }
        }
    }

    $event_passed = $all_past;
}


$is_in_cart = false;

if (isset($order_id)) {
    if ($pricing === 'free') {
        // Check if "free" training is already in cart
        $sql = "SELECT COUNT(*) as count FROM {$siteprefix}order_items 
                WHERE training_id = '$training_id' AND order_id = '$order_id' AND item_id = 'free'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        if ($row['count'] > 0) {
            $is_in_cart = true;
        }
    } else {
        // For paid items, ensure all variations are in cart
        $sql = "SELECT s FROM {$siteprefix}training_tickets WHERE training_id = '$training_id'";
        $ticket_result = mysqli_query($con, $sql);
        $ticket_ids = [];

        while ($ticket_row = mysqli_fetch_assoc($ticket_result)) {
            $ticket_ids[] = $ticket_row['s'];
        }

        // Now check how many of those tickets are in the cart
        $ticket_ids_string = "'" . implode("','", $ticket_ids) . "'";
        $sql = "SELECT COUNT(DISTINCT item_id) as count FROM {$siteprefix}order_items 
                WHERE training_id = '$training_id' AND order_id = '$order_id' 
                AND item_id IN ($ticket_ids_string)";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);

        if ($row['count'] == count($ticket_ids)) {
            $is_in_cart = true;
        }
    }
}


// Check if user has purchased THIS product
$purchase_query = "SELECT * FROM ".$siteprefix."orders o 
JOIN ".$siteprefix."order_items oi ON o.order_id = oi.order_id 
WHERE o.user = ? AND oi.training_id = ? AND o.status = 'paid'";
$stmt = $con->prepare($purchase_query);
$stmt->bind_param("ss", $user_id, $training_id);
$stmt->execute();
$purchase_result = $stmt->get_result();
$user_purchased= $purchase_result->num_rows > 0;

// Check if user already left a review
$existing_review_query = "SELECT * FROM ".$siteprefix."reviews WHERE user = ? AND training_id = ?";
$stmt = $con->prepare($existing_review_query);
$stmt->bind_param("si", $user_id, $training_id);
$stmt->execute();
$existing_review_result = $stmt->get_result();
$user_review = $existing_review_result->fetch_assoc();

 
?>
 <!-- Product Details Section -->
    <section id="product-details" class="product-details section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gx-2 gy-1">
		
          <!-- Product Images Column -->
          <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right" data-aos-delay="200">
		  <div class="row">
		  <div class="col-12">
		  		  <div class="product-data">
              <!-- Product Meta -->
              <div class="product-meta">
                     <div class="d-flex justify-content-between align-items-center mb-3">
                     
                  <span class="product-category"><?php echo $event_type; ?></span>

                  <div class="product-share">
                    <button class="share-btn" id="webShareBtn" aria-label="Share product">
                      <i class="bi bi-share"></i>
                    </button>
                    <div class="share-dropdown">
                   <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($siteurl . 'events?slug=' . $slug); ?>&text=<?php echo urlencode($title); ?>" 
     target="_blank" rel="noopener" title="Share on Twitter">
    <i class="bi bi-twitter"></i>
  </a>

  <!-- Facebook -->
  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($siteurl . 'events?slug=' . $slug); ?>" 
     target="_blank" rel="noopener" title="Share on Facebook">
    <i class="bi bi-facebook"></i>
  </a>

  <!-- LinkedIn -->
  <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($siteurl . 'events?slug=' . $slug); ?>&title=<?php echo urlencode($title); ?>" 
     target="_blank" rel="noopener" title="Share on LinkedIn">
    <i class="bi bi-linkedin"></i>
  </a>

                    </div>
                     <span>Event ID: <?php echo $training_id; ?></span>
                  </div>
                </div>
			      <h4 class="product-title"><?php echo $title; ?></h4>
				  
				      <div class="row mb-1">
                    <div class="col-6">
                        <h6>Created by: </h6>
                      <div class="user_info mb-1 d-flex">
                   <a href="<?php echo $siteurl . 'trainer-store?seller_id=' . $seller_id; ?>"><img src="<?php echo $siteurl . $seller_photo; ?>" alt="<?php echo $seller_name; ?>" class="user-image rounded-circle me-2" width="32" height="32">
                    <span class="mt-3"><?php echo $seller_name; ?></span></a>
                </div>
             </div>
                <div class="col-6">
              
                <div class="product-rating">
                  <div class="stars">
                    <?php
                     for ($i = 1; $i <= 5; $i++) {
        if ($average_rating >= $i) {
            echo '<i class="bi bi-star-fill"></i>';
        } elseif ($average_rating >= $i - 0.5) {
            echo '<i class="bi bi-star-half"></i>';
        } else {
            echo '<i class="bi bi-star"></i>';
        }
    }
    ?>
    <span class="rating-value"><?php echo htmlspecialchars($average_rating, ENT_QUOTES, 'UTF-8'); ?></span>
                  </div>
                 
                </div>
              </div>

                <div class="col-6">
    <!-- Instructor Section -->
    <h6>Instructor:</h6>
    <div class="user_info mb-1 d-flex align-items-center instructor-click" 
         data-user-id="<?php echo $instructor_user; ?>" style="cursor:pointer;">
        <img src="<?php echo $siteurl . $instructor_picture; ?>" 
             alt="<?php echo $instructor_name; ?>" 
             class="user-image rounded-circle me-2" width="32" height="32">
        <span><?php echo $instructor_name; ?></span>
    </div>
</div>
            </div>
			  </div>
            </div>
          

            <div class="product-gallery mb-3">
            
              <!-- Main Image -->
              <div class="main-image-wrapper">
                <div class="image-zoom-container">
                  <a href="<?php echo $siteurl.$image_paths; ?>" class="glightbox" data-gallery="product-gallery">
                    <img src="<?php echo $siteurl.$image_paths; ?>" alt="Product Image" class="img-fluid main-image drift-zoom" id="main-product-image" data-zoom="<?php echo $siteurl.$image_paths; ?>">
                    <div class="zoom-overlay">
                      <i class="bi bi-zoom-in"></i>
                    </div>
                  </a>
                </div>
              </div>
			  </div>
			   </div>
            </div>
			
			
			
                
<div class="col-12">
  <div class="table-requirements">

    <!-- Visa Requirement Section -->
    <div class="collapsible-section mb-4">
      <h6>Visa Requirement</h6>
      <?php
$visa_text = '

<strong>For Trainings in Nigeria:</strong><br>
If you reside outside Nigeria and plan to attend one of our trainings, a visitor visa may be required. We recommend applying early, as visa processing can take time. Citizens of Visa Waiver Program countries may not need an invitation letter. For full details and application guidance, visit: <a href="https://portal.immigration.gov.ng/pages/welcome" target="_blank">https://portal.immigration.gov.ng/pages/welcome</a>.<br><br>

<strong>For Trainings Outside Nigeria:</strong><br>
Participants attending training sessions abroad will need to obtain a visa independently. Learnora (Kyneli Business Support Services) does not process visas on behalf of trainees. Please contact the appropriate embassy for visa requirements specific to your destination country.';

      $visa_words = explode(' ', strip_tags($visa_text));
      $visa_short = implode(' ', array_slice($visa_words, 0, 30));
      $visa_long = $visa_text;
      $visa_is_long = count($visa_words) > 30;
      ?>
      <p>
        <span class="short-desc"><?php echo $visa_short; ?><?php if ($visa_is_long) echo '...'; ?></span>
        <?php if ($visa_is_long): ?>
          <span class="full-desc" style="display:none;"><?php echo $visa_long; ?></span>
          <br>
          <button type="button" class="btn btn-link btn-sm p-0 read-more-btn" style="text-decoration: none;">Read More</button>
          <button type="button" class="btn btn-link btn-sm p-0 read-less-btn" style="text-decoration: none; display:none;">Read Less</button>
        <?php endif; ?>
      </p>
    </div>

    <!-- Cancellation Policy Section -->
    <div class="collapsible-section">
      <h6>Cancellation Policy</h6>
      <?php
$cancel_text = "All cancellations must be submitted in writing to <a href=\"mailto:hello@learnora.ng\">hello@learnora.ng</a> at least three (3) days before the event. A twenty percent (20%) administrative fee applies to all cancellations. Substitutions are permitted at any time at no extra cost. For inquiries, you may also call <a href=\"tel:+2348033782777\">+234 (0) 803 3782 777</a> or <a href=\"tel:+23412952413\">+234 (01) 29 52 413</a>.";

$cancel_words = explode(' ', strip_tags($cancel_text));
      $cancel_short = implode(' ', array_slice($cancel_words, 0, 30));
      $cancel_long = $cancel_text;
      $cancel_is_long = count($cancel_words) > 30;
      ?>
      <p>
        <span class="short-desc"><?php echo $cancel_short; ?><?php if ($cancel_is_long) echo '...'; ?></span>
        <?php if ($cancel_is_long): ?>
          <span class="full-desc" style="display:none;"><?php echo $cancel_long; ?></span>
          <br>
          <button type="button" class="btn btn-link btn-sm p-0 read-more-btn" style="text-decoration: none;">Read More</button>
          <button type="button" class="btn btn-link btn-sm p-0 read-less-btn" style="text-decoration: none; display:none;">Read Less</button>
        <?php endif; ?>
      </p>
    </div>

  </div>
</div>
			

          </div>


          <!-- Product Info Column -->
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
		  <div class="row">
		  <div class="col-12">
            <div class="product-info-wrapper" id="product-info-sticky">
              <!-- Product Meta -->
              <div class="product-meta">
<div class="product-short-description mb-1">
<?php
// Fetch from DB (already contains TinyMCE HTML)
$description_html = $description;

// Count words in plain text
$plainText = strip_tags($description_html);
$wordCount = str_word_count($plainText);

if ($wordCount > 30) {
    // Split words
    $words = explode(' ', $plainText);

    // Get first 30 words
    $first30 = implode(' ', array_slice($words, 0, 30));

    // Build preview HTML with TinyMCE styles
    ?>
    <div>
        <div class="preview" style="display:inline;">
            <?php
            // We use full HTML, but CSS will hide anything after 30 words
            echo '<span class="preview-text">' . $first30 . '...</span>';
            ?>
        </div>
        <div class="more-text" style="display:none;">
            <?php echo $description_html; ?>
        </div>
        <a href="javascript:void(0);" class="toggle-btn">Read More</a>
    </div>
<?php
} else {
    // If 30 words or fewer, just display the HTML directly
    echo "<div>$description_html</div>";
}
?>
</div>

              <!-- Product Price -->
              <div class="product-price-container">
                <div class="price-wrapper">
                  <span class="current-price">
            <?php
                if ($pricing === 'paid') {
                  echo '<span id="paidPrice"></span>'; // Empty placeholder for JS
                } elseif ($pricing === 'free') {
                echo 'Free';
                } elseif ($pricing === 'donation') {
                echo 'Donate';
                }
            ?>
            </span>
              </div>
           
  <div class="mb-1">
    <!-- Loyalty Display -->
    <?php if ($loyalty == 1): ?>
      <span class="badge text-light bg-danger mb-1">Loyalty Material</span>
    <?php endif; ?>
<?php foreach ($ticket_list as $ticket): ?>
    <?php 
      $ticket_price = floatval($ticket['price']); // Get ticket price safely
    ?>
<?php endforeach; ?>
    <?php if ($loyalty_id < 1): ?>
  <h6>Buy for Less – <a href="<?php echo $siteurl; ?>loyalty-program.php">Sign up</a> as a loyalty member today!</h6>
  <div class="product-loyalty-container mb-3" style="display:none;">
    <?php
      $loyalty_query = "SELECT name, discount FROM {$siteprefix}subscription_plans WHERE status = 'active'";
      $loyalty_result = mysqli_query($con, $loyalty_query);

      if ($loyalty_result && mysqli_num_rows($loyalty_result) > 0) {
        while ($row = mysqli_fetch_assoc($loyalty_result)) {
            $plan_name = $row['name'];
            $discount = $row['discount'];
            ?>
            <span class="badge text-light bg-primary me-1 loyalty-badge"
                  data-discount="<?php echo $discount; ?>"
                  data-plan="<?php echo htmlspecialchars($plan_name); ?>">
              <a href="<?php echo $siteurl; ?>loyalty-program.php" class="text-white text-decoration-none">
                <span class="loyalty-plan-name"><?php echo $plan_name; ?></span> - ₦
                <span class="loyalty-price">0.00</span>

              </a>
            </span>
    <?php } } ?>
  </div>
<?php endif; ?>

          <!-- Action Buttons -->
              <?php if ($pricing === 'paid'): ?>
  <div class="mb-3">
    <label><strong>Select Tickets:</strong></label><br>
    <div class="btn-group mb-1 flex-wrap" role="group" aria-label="Variation checkbox group">
      <?php 
        $sql = "SELECT * FROM {$siteprefix}training_tickets WHERE training_id = '$training_id' ORDER BY price ASC";
        $sql2 = mysqli_query($con, $sql);
        if (!$sql2) { die("Query failed: " . mysqli_error($con)); }

        while ($row = mysqli_fetch_array($sql2)) {
            $ticket_id = $row['s'];
            $ticket_name = $row['ticket_name'];
            $amount = floatval($row['price']);
            $seatremain = intval($row['seatremain']);
            $benefits = $row['benefits']; // safe for output

            $isSoldOut = $seatremain <= 0;
      ?>
        <div class="m-1 position-relative">
          <input 
              type="checkbox"
              class="btn-check variation-checkbox"
              value="<?php echo $ticket_id; ?>"
              name="variation_ids[]"
              id="ticket<?php echo $ticket_id; ?>"
              data-price="<?php echo $amount; ?>"
              <?php if ($isSoldOut) echo 'disabled'; ?>
              autocomplete="off">

          <!-- Label with tooltip -->
          <label 
              class="btn btn-outline-<?php echo $isSoldOut ? 'secondary' : 'primary'; ?>" 
              for="ticket<?php echo $ticket_id; ?>"
              <?php if ($isSoldOut): ?>
                title="Ticket Sold Out. Please select another."
              <?php endif; ?>
          >
            <?php echo htmlspecialchars($ticket_name); ?> 
            (₦<?php echo number_format($amount, 2); ?>)
            <?php if ($isSoldOut): ?>
              <span class="text-danger fw-bold"> - Sold Out</span>
            <?php endif; ?>
          </label>

          <!-- Hidden inputs for JS -->
          <input type="hidden" id="seat-<?php echo $ticket_id; ?>" value="<?php echo $seatremain; ?>">
          <input type="hidden" id="benefits-<?php echo $ticket_id; ?>" value="<?php echo $benefits; ?>">

          <!-- JS output area -->
          <div class="ticket-info mt-1 small text-muted" id="info-<?php echo $ticket_id; ?>" style="display:none;"></div>
        </div>
      <?php } ?>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const checkboxes = document.querySelectorAll('.variation-checkbox');

      checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
          const ticketId = this.value;
          const infoDiv = document.getElementById('info-' + ticketId);
          const seatRemain = document.getElementById('seat-' + ticketId).value;
          const benefits = document.getElementById('benefits-' + ticketId).value;

          if (this.checked) {
            let html = `
              <strong>Remaining Seat:</strong> ${seatRemain}<br>
              <strong>Benefits:</strong> ${benefits}
            `;
            infoDiv.innerHTML = html;
            infoDiv.style.display = 'block';
          } else {
            infoDiv.style.display = 'none';
          }
        });
      });
    });
  </script>
<?php endif; ?>
</div>
            

    

<div class="product-actions">
    <?php if ($event_passed): ?>
        <a class="btn btn-danger">Event Passed</a>
    <?php elseif ($user_purchased): ?>
        <a href="<?php echo $siteurl; ?>dashboard.php" class="btn btn-success">
            <i class="bi bi-person"></i> Go to Dashboard
        </a>
    <?php else: ?>
        <?php if ($pricing === 'paid' || $pricing === 'free') : ?>
            <?php if ($is_in_cart): ?>
                <a href="<?php echo $siteurl; ?>cart.php" class="btn btn-primary add-to-cart-btn">
                    <i class="bi bi-cart-check"></i> View Cart
                </a>
            <?php else: ?>
              <input type="hidden" name="pricing" id="pricing" value="<?php echo $pricing; ?>">
                <input type="hidden" name="affliate_id" id="affliate_id" value="<?php echo $affliate_id; ?>">
                <input type="hidden" name="training_id" id="current_training_id" value="<?php echo $training_id; ?>">
                <button class="btn btn-primary add-to-cart-btn" data-report="<?php echo $training_id; ?>" name="add" id="addCart">
                    <i class="bi bi-cart-plus"></i> Add to Cart
                </button>
            <?php endif; ?>
        <?php elseif ($pricing === 'donation'): ?>
            <button class="btn btn-primary donate-btn" type="button"
                id="donateBtn"
                data-training-id="<?php echo $training_id; ?>"
                data-affiliate-id="<?php echo $affliate_id; ?>"
                data-orders_id="<?php echo uniqid('OD'); ?>">
                <i class="bi bi-cash-coin"></i> Donate
            </button>
        <?php endif; ?>

        <!-- Wishlist button is always shown if event hasn't passed -->
      <button class="btn btn-outline-secondary wishlist-btn<?php echo $theinitialicon ? ' '.$theinitialicon : ''; ?>" data-product-id="<?php echo $training_id; ?>" aria-label="Add to wishlist">
            <i class="bi bi-heart"></i>
        </button>
    <?php endif; ?>

        <!-- Report Product Button -->
               <?php if ($active_log == 1): ?>
       <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reportProductModal">
  <i class="bi bi-flag"></i> Report
</button>

    <?php else: ?>
        <button class="btn btn-secondary" disabled>
            <i class="bi bi-flag"></i> Report
        </button>
     <?php endif; ?>
</div>

<div class="inhouse-proposal my-3 p-3 border rounded bg-light">
    <h6 class="mb-2"><i class="bi bi-building"></i>Request an In-House Training Proposal</h6>
    <p class="mb-1">
      Interested in hosting this training & event at your organization? Let us know if you’d like to arrange a customized in-house session for your team.
    </p>
    <a href="<?php echo $siteurl; ?>inhouse-proposal.php?training_id=<?php echo $training_id; ?>" class="btn btn-outline-primary btn-sm">
        Request Now
    </a>
</div>

<div>

<a href="<?php echo $siteurl; ?>attendees.php?training_id=<?php echo $training_id; ?>" class="btn btn-primary">
    See Who’s Attending
</a>

        </div>

		  </div>
      </div>
	    </div>
      </div>

           			  <div class="col-12 mb-3" data-aos="fade-left" data-aos-delay="300">
       <!-- Language and Event Dates/Times Table (Borderless) -->
               <div class="table-actions">
 <table class="table table-borderless mt-3">
    <tbody>
        <tr>
            <td><i class="bi bi-bar-chart"></i> Level:</td>
            <td><?php echo htmlspecialchars($level); ?></td>
        </tr>
        <tr>
            <td><i class="bi bi-translate"></i> Language:</td>
            <td><?php echo htmlspecialchars($language); ?></td>
        </tr>
        <tr>
            <td><i class="bi bi-people"></i> Target Audience:</td>
            <td><?php echo $target_audience; ?></td>
        </tr>

        <!-- ✅ Insert Delivery Format Location Info -->
        <?php echo $delivery_details; ?>

     <?php

// ✅ Fetch all event dates for this training
$event_dates = [];
$dates_sql = "SELECT event_date, start_time, end_time
              FROM {$siteprefix}training_event_dates
              WHERE training_id = '$id'
              ORDER BY event_date ASC, start_time ASC";
$dates_result = mysqli_query($con, $dates_sql);

while ($d = mysqli_fetch_assoc($dates_result)) {
    $event_dates[] = $d;
}


?>
           <!-- ✅ Event Dates -->
<?php if (!empty($event_dates)): ?>
    <?php foreach ($event_dates as $ed): ?>
        <tr>
            <td><i class="bi bi-calendar-event"></i> Date & Time:</td>
            <td>
                <?php
                echo date('D, M j, Y', strtotime($ed['event_date'])) . ' — ';
                echo date('g:ia', strtotime($ed['start_time'])) . ' to ' . date('g:ia', strtotime($ed['end_time']));
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td><i class="bi bi-calendar-event"></i> Date & Time:</td>
        <td>No scheduled dates yet.</td>
    </tr>
<?php endif; ?>

    </tbody>
</table>

                </div>

                    </div>
	  
	

        </div>               
</div>




	    </div>
		<div class="row mb-2">
		
		<!-- Course Info & Review Tabs Column -->
<div class="col-12 mb-3" data-aos="fade-left" data-aos-delay="300">
  <div class="card shadow-sm">
    <div class="card-body">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs mb-3" id="courseTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">
            Course Info
          </button>
        </li>
		
          <?php if (!empty($training_video)) { ?>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="video-tab" data-bs-toggle="tab" data-bs-target="#video" type="button" role="tab" aria-controls="video" aria-selected="false">
           Course Video
          </button>
        </li>

        <?php } ?>
		
          <?php if ($user_purchased) { ?>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="false">
            Review
          </button>
        </li>

        <?php } ?>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content" id="courseTabContent">
        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
      
	  
	      <div class="product-description mb-1">
      <?php if (!empty($description)): ?>
    <div class="accordion mb-3" id="benefitAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingBenefit">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBenefit" aria-expanded="false" aria-controls="collapseBenefit">
                      Course Description
                </button>
            </h2>
            <div id="collapseBenefit" class="accordion-collapse collapse show" aria-labelledby="headingBenefit" data-bs-parent="#benefitAccordion">
                
            <div class="accordion-body">
                 <div class="product-short-description mb-1">
<?php
// Fetch from DB (already contains TinyMCE HTML)
$description_html = $description;

// Count words in plain text
$plainText = strip_tags($description_html);
$wordCount = str_word_count($plainText);

if ($wordCount > 30) {
    // Split words
    $words = explode(' ', $plainText);

    // Get first 30 words
    $first30 = implode(' ', array_slice($words, 0, 30));

    // Build preview HTML with TinyMCE styles
    ?>
    <div>
        <div class="preview" style="display:inline;">
            <?php
            // We use full HTML, but CSS will hide anything after 30 words
            echo '<span class="preview-text">' . $first30 . '...</span>';
            ?>
        </div>
        <div class="more-text" style="display:none;">
            <?php echo $description_html; ?>
        </div>
        <a href="javascript:void(0);" class="toggle-btn">Read More</a>
    </div>
<?php
} else {
    // If 30 words or fewer, just display the HTML directly
    echo "<div>$description_html</div>";
}
?>
</div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
                    </div>
                    <div class="product-description mb-1">
<?php if (!empty($course_requirrement)): ?>
    <div class="accordion mb-3" id="requirementsAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingRequirements">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRequirements" aria-expanded="false" aria-controls="collapseRequirements">
                    Course Requirements
                </button>
            </h2>
            <div id="collapseRequirements" class="accordion-collapse collapse" aria-labelledby="headingRequirements" data-bs-parent="#requirementsAccordion">
                <div class="accordion-body">
            <div class="product-short-description mb-1">
<?php
// Fetch from DB (already contains TinyMCE HTML)
$description_html = $course_requirrement;

// Count words in plain text
$plainText = strip_tags($description_html);
$wordCount = str_word_count($plainText);

if ($wordCount > 30) {
    // Split words
    $words = explode(' ', $plainText);

    // Get first 30 words
    $first30 = implode(' ', array_slice($words, 0, 30));

    // Build preview HTML with TinyMCE styles
    ?>
    <div>
        <div class="preview" style="display:inline;">
            <?php
            // We use full HTML, but CSS will hide anything after 30 words
            echo '<span class="preview-text">' . $first30 . '...</span>';
            ?>
        </div>
        <div class="more-text" style="display:none;">
            <?php echo $description_html; ?>
        </div>
        <a href="javascript:void(0);" class="toggle-btn">Read More</a>
    </div>
<?php
} else {
    // If 30 words or fewer, just display the HTML directly
    echo "<div>$description_html</div>";
}
?>
</div>

                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
    </div>

<?php if (!empty($learning_objectives)): ?>
    <div class="accordion mb-3" id="objectivesAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingObjectives">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseObjectives" aria-expanded="false" aria-controls="collapseObjectives">
                    Learning Objectives
                </button>
            </h2>
            <div id="collapseObjectives" class="accordion-collapse collapse" aria-labelledby="headingObjectives" data-bs-parent="#objectivesAccordion">
                <div class="accordion-body">
                        <div class="product-short-description mb-1">
<?php
// Fetch from DB (already contains TinyMCE HTML)
$description_html = $learning_objectives;

// Count words in plain text
$plainText = strip_tags($description_html);
$wordCount = str_word_count($plainText);

if ($wordCount > 30) {
    // Split words
    $words = explode(' ', $plainText);

    // Get first 30 words
    $first30 = implode(' ', array_slice($words, 0, 30));

    // Build preview HTML with TinyMCE styles
    ?>
    <div>
        <div class="preview" style="display:inline;">
            <?php
            // We use full HTML, but CSS will hide anything after 30 words
            echo '<span class="preview-text">' . $first30 . '...</span>';
            ?>
        </div>
        <div class="more-text" style="display:none;">
            <?php echo $description_html; ?>
        </div>
        <a href="javascript:void(0);" class="toggle-btn">Read More</a>
    </div>
<?php
} else {
    // If 30 words or fewer, just display the HTML directly
    echo "<div>$description_html</div>";
}
?>
</div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


    <?php if (!empty(trim($target_audience))): ?>
    <div class="accordion mb-3" id="audienceAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingAudience">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAudience" aria-expanded="false" aria-controls="collapseAudience">
                    Target Audience
                </button>
            </h2>
            <div id="collapseAudience" class="accordion-collapse collapse show" aria-labelledby="headingAudience" data-bs-parent="#audienceAccordion">
                <div class="accordion-body">
                    <?php echo $target_audience; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<?php if (!empty($additional_notes)): ?>
    <div class="accordion mb-3" id="notesAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingNotes">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNotes" aria-expanded="false" aria-controls="collapseNotes">
                    Additional Notes
                </button>
            </h2>
            <div id="collapseNotes" class="accordion-collapse collapse" aria-labelledby="headingNotes" data-bs-parent="#notesAccordion">
                <div class="accordion-body">
                                         <div class="product-short-description mb-1">
<?php
// Fetch from DB (already contains TinyMCE HTML)
$description_html = $additional_notes;

// Count words in plain text
$plainText = strip_tags($description_html);
$wordCount = str_word_count($plainText);

if ($wordCount > 30) {
    // Split words
    $words = explode(' ', $plainText);

    // Get first 30 words
    $first30 = implode(' ', array_slice($words, 0, 30));

    // Build preview HTML with TinyMCE styles
    ?>
    <div>
        <div class="preview" style="display:inline;">
            <?php
            // We use full HTML, but CSS will hide anything after 30 words
            echo '<span class="preview-text">' . $first30 . '...</span>';
            ?>
        </div>
        <div class="more-text" style="display:none;">
            <?php echo $description_html; ?>
        </div>
        <a href="javascript:void(0);" class="toggle-btn">Read More</a>
    </div>
<?php
} else {
    // If 30 words or fewer, just display the HTML directly
    echo "<div>$description_html</div>";
}
?>
</div>
           
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


        </div>


         <div class="tab-pane fade" id="video" role="tabpanel" aria-labelledby="video-tab">
           <div class="product-description mb-1">
         <?php if (!empty($training_video)): ?>
    <div class="accordion mb-3" id="videoAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingVideo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseVideo" aria-expanded="false" aria-controls="collapseVideo">
                    Course Video
                </button>
            </h2>
            <div id="collapseVideo" class="accordion-collapse collapse show" aria-labelledby="headingVideo" data-bs-parent="#videoAccordion">
                <div class="accordion-body">
                    <div class="product-video">
                        <video controls width="100%">
                            <source src="<?php echo $siteurl . $training_video; ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

           </div>
         </div>

<?php if ($user_purchased) { ?>
        <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
          <!-- Review Content -->
           <div class="product-details-accordion"> 
  <!-- Reviews Accordion -->
              <div class="accordion-item" id="reviews">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#reviewsContent" aria-expanded="true" aria-controls="reviewsContent">
                    Write a Review
                  </button>
                </h2>
                <div id="reviewsContent" class="accordion-collapse collapse show">
                  <div class="accordion-body">
                    <div class="product-reviews">
                     <div class="review-form-container mt-5">
                        <h4>Write a Review</h4>
                             <form class="review-form" method="POST">
                         <input type="hidden" name="training_id" value="<?php echo $training_id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <div class="rating-select mb-4">
                          <label class="form-label">Your Rating</label>
                          <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5"><label for="star5" title="5 stars"><i class="bi bi-star-fill"></i></label>
                              <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="4 stars"><i class="bi bi-star-fill"></i></label>
                              <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="3 stars"><i class="bi bi-star-fill"></i></label>
                              <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="2 stars"><i class="bi bi-star-fill"></i></label>
                              <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="1 star"><i class="bi bi-star-fill"></i></label>
                          </div>
                        </div>
                        <div class="mb-4">
                          <label for="review-content" class="form-label">Your Review</label>
                          <textarea class="form-control" id="review-content" rows="4" name="review" required=""></textarea>

                        </div>

                        <div class="d-grid">
                          <button type="submit" name="submit-review" class="btn btn-primary">Submit Review</button>
                        </div>
                      </form>
                      </div>
                      </div>
                      </div>
                      </div>
                      </div>
					  
             <?php
// Fetch all reviews for the product
$all_reviews_query = "SELECT r.*, u.display_name AS user_name 
                      FROM {$siteprefix}reviews r
                      JOIN {$siteprefix}users u ON r.user = u.s
                      WHERE r.training_id = ?
                      ORDER BY r.date DESC";
$stmt = $con->prepare($all_reviews_query);
$stmt->bind_param("i", $training_id);
$stmt->execute();
$all_reviews_result = $stmt->get_result();
$all_reviews = $all_reviews_result->fetch_all(MYSQLI_ASSOC);
?>
					     <?php if (!empty($all_reviews)): ?>
                    <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#reviewssummary" aria-expanded="false" aria-controls="reviewssummary">
                 All Reviews
                  </button>
                </h2>
                <div id="reviewssummary" class="accordion-collapse collapse">
                  <div class="accordion-body">
                     <div class="product-reviews">
<div class="reviews-summary">
  <div class="row">
    <div class="col-lg-4">
      <div class="overall-rating">
        <div class="rating-number"><?php echo number_format($average_rating, 1); ?></div>
        <div class="rating-stars">
          <?php
          for ($i = 1; $i <= 5; $i++) {
            if ($average_rating >= $i) {
              echo '<i class="bi bi-star-fill"></i>';
            } elseif ($average_rating >= $i - 0.5) {
              echo '<i class="bi bi-star-half"></i>';
            } else {
              echo '<i class="bi bi-star"></i>';
            }
          }
          ?>
        </div>
        <div class="rating-count">
          Based on <?php echo (int)$review_count; ?> review<?php echo ($review_count == 1 ? '' : 's'); ?>
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="rating-breakdown">
        <?php
          for ($i = 5; $i >= 1; $i--) {
              echo getRatingBar($i, $ratings[$i], $review_count);
          }
        ?>
      </div>
    </div>
  </div>
</div>
                      </div>

<div class="reviews-list mt-5" id="reviews-list">
  <h4>Customer Reviews</h4>

  <?php foreach ($all_reviews as $i => $review): ?>
    <div class="review-item mb-4" style="<?php echo $i > 2 ? 'display:none;' : ''; ?>">
      <div class="review-header d-flex justify-content-between align-items-center">
        <div class="reviewer-info d-flex align-items-center">
          <div>
            <h5 class="reviewer-name mb-0"><?php echo htmlspecialchars($review['user_name']); ?></h5>
            <div class="review-date"><?php echo date('m/d/Y', strtotime($review['date'])); ?></div>
          </div>
        </div>
        <div class="review-rating">
          <?php
            $rating = (int)$review['rating'];
            for ($j = 1; $j <= 5; $j++) {
              echo $j <= $rating ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>';
            }
          ?>
        </div>
      </div>
      <div class="review-content mt-2">
        <p><?php echo nl2br(htmlspecialchars($review['review'])); ?></p>
      </div>
    </div>
  <?php endforeach; ?>

  <?php if (count($all_reviews) > 3): ?>
    <div class="text-center">
      <button id="loadMoreReviews" class="btn btn-outline-primary btn-sm">Load More</button>
    </div>
  <?php endif; ?>


</div>



        </div>
		
      </div>
    </div>
	

    <?php else: ?>
  <p>No reviews yet.</p>
    <?php endif; ?>
	</div>
  </div>
  <?php }  ?>

</div>
   </div>
     </div>
	 </div>
		
		</div>
      </div>
     

    </section><!-- /Product Details Section -->


        <!-- Best Sellers Section -->
    <section id="best-sellers" class="best-sellers section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Related Events</h2>
        <p>Explore events that complement your learning journey. Connect with industry experts and fellow learners.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4">
          <!-- Product 1 -->
          <?php
$categoryIDs = explode(',', $category);
$subcategoryIDs = explode(',', $subcategory);

$escapedCategoryIDs = array_map('intval', $categoryIDs);
$escapedSubcategoryIDs = array_map('intval', $subcategoryIDs);

$categoryIDList = implode(',', $escapedCategoryIDs);
$subcategoryIDList = implode(',', $escapedSubcategoryIDs);


$query = "SELECT t.*, 
                u.name AS display_name, 
                tt.price, 
                u.photo AS profile_picture, 
                l.category_name AS category, 
                sc.category_name AS subcategory, 
                ti.picture 
          FROM {$siteprefix}training t
          LEFT JOIN {$siteprefix}categories l ON FIND_IN_SET(l.id, t.category)
          LEFT JOIN {$siteprefix}categories sc ON FIND_IN_SET(sc.id, t.subcategory)
          LEFT JOIN {$siteprefix}instructors u ON t.instructors = u.s
          LEFT JOIN {$siteprefix}training_tickets tt ON t.training_id = tt.training_id
          LEFT JOIN {$siteprefix}training_images ti ON t.training_id = ti.training_id
          WHERE (FIND_IN_SET(l.id, '$categoryIDList') 
              OR FIND_IN_SET(sc.id, '$subcategoryIDList'))
            AND t.training_id != '$training_id'
            AND t.status = 'approved'
            AND EXISTS (
                SELECT 1 
                FROM {$siteprefix}training_event_dates d
                WHERE d.training_id = t.training_id
                AND (
                    d.event_date > CURDATE() 
                    OR (d.event_date = CURDATE() AND d.end_time >= CURTIME())
                )
            )
          GROUP BY t.training_id
          LIMIT 4";

$result = mysqli_query($con, $query);
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $training_id = $row['training_id'];
        $title = $row['title'];
        $alt_title = $row['alt_title'];
        $description = $row['description'];
        $category = $row['category'];
        $subcategory = $row['subcategory'];
        $pricing = $row['pricing'];
        $price = $row['price'];
        $tags = $row['tags'];

        $user = $row['display_name'];
        $user_picture = $imagePath.$row['profile_picture'];
        $created_date = $row['created_at'];
        $status = $row['status'];
        $image_path = $imagePath.$row['picture'];
        $slug = $alt_title;
        $event_type = $row['event_type'] ?? '';
    

           // Fetch price variations for this report
    $priceSql = "SELECT price FROM {$siteprefix}training_tickets WHERE training_id = '$training_id'";
    $priceRes = mysqli_query($con, $priceSql);
    $prices = [];
    while ($priceRow = mysqli_fetch_assoc($priceRes)) {
        $prices[] = floatval($priceRow['price']);
    }

    // Determine price display
   if (count($prices) === 1) {
        $priceDisplay = $sitecurrency . number_format($prices[0], 2);
        $price = $prices[0];
    } if (count($prices) > 1) {
        $minPrice = min($prices);
        $maxPrice = max($prices);
        $priceDisplay = $sitecurrency . number_format($minPrice, 2) . ' - ' . $sitecurrency . number_format($maxPrice, 2);
        $price = $minPrice; // Use min price for sorting or other logic
    }

            $sql_resource_type = "SELECT name FROM {$siteprefix}event_types WHERE s = $event_type";
            $result_resource_type = mysqli_query($con, $sql_resource_type);

            while ($typeRow = mysqli_fetch_assoc($result_resource_type)) {
                $resourceTypeNames = $typeRow['name'];
            }
$rating_data = calculateRating($training_id, $con, $siteprefix);
    $average_rating = $rating_data['average_rating'];
    $review_count = $rating_data['review_count'];
        include "event-card.php"; // Include the product card template
        }
      
     
?>
       </div>
  <div class="text-center mt-1" data-aos="fade-up">
		  
		  <?php } else { echo '<div class="alert alert-warning" role="alert">
    No related products found. <a href="'.$siteurl.'marketplace.php" class="alert-link">View more reports in marketplace</a>
      </div>';
       }?>
        </div>
      </div>

    </section><!-- /Related Products Section -->
  <!-- Instructor Popup Modal -->
<div class="modal" id="instructorModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Instructor Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img id="instructorPhoto" src="" class="rounded-circle mb-3" width="80" height="80" />
        <h6 id="instructorName"></h6>
        <p id="instructorBio"></p>
      </div>
    </div>
  </div>
</div>

 <!-- Recent Reports Swiper Section -->
    <section id="best-sellers" class="best-sellers section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="section-title text-center mb-4">
      <h2>Recently Enrolled Trainings</h2>
      <p>Explore the latest training programs our learners are signing up for. Stay ahead with trending and in-demand courses!</p>
    </div>
    <div class="recent-reports-slider swiper init-swiper">
      <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "autoplay": {
            "delay": 4000,
            "disableOnInteraction": false
          },
          "grabCursor": true,
          "speed": 600,
          "slidesPerView": "auto",
          "spaceBetween": 20,
          "navigation": {
            "nextEl": ".recent-swiper-button-next",
            "prevEl": ".recent-swiper-button-prev"
          },
          "breakpoints": {
            "320": {
              "slidesPerView": 2,
              "spaceBetween": 10
            },
            "576": {
              "slidesPerView": 2,
              "spaceBetween": 15
            },
            "768": {
              "slidesPerView": 3,
              "spaceBetween": 20
            },
            "992": {
              "slidesPerView": 4,
              "spaceBetween": 20
            }
          }
        }
      </script>
      <div class="swiper-wrapper">
          <?php
$query = "SELECT DISTINCT 
            t.*, 
            ti.picture, 
            u.display_name, 
            tt.price, 
            u.profile_photo as profile_picture,
            l.category_name AS category,
            sc.category_name AS subcategory
        FROM {$siteprefix}orders o
        JOIN {$siteprefix}order_items oi ON o.order_id = oi.order_id
        JOIN {$siteprefix}training t ON t.training_id = oi.training_id
        LEFT JOIN {$siteprefix}training_images ti ON t.training_id = ti.training_id
        LEFT JOIN {$siteprefix}users u ON t.user = u.s
        LEFT JOIN {$siteprefix}categories l ON t.category = l.id
        LEFT JOIN {$siteprefix}training_tickets tt ON t.training_id = tt.training_id
        LEFT JOIN {$siteprefix}categories sc ON t.subcategory = sc.id
        WHERE o.status = 'paid' 
        AND t.status = 'approved'
        AND EXISTS (
            SELECT 1 
            FROM {$siteprefix}training_event_dates d
            WHERE d.training_id = t.training_id
            AND (
                d.event_date > CURDATE() 
                OR (d.event_date = CURDATE() AND d.end_time >= CURTIME())
            )
        )
        GROUP BY t.training_id
        ORDER BY o.date DESC 
        LIMIT 10";

$result = mysqli_query($con, $query);
if ($result) {
while ($row = mysqli_fetch_assoc($result)) {
        $training_id = $row['training_id'];
        $title = $row['title'];
        $alt_title = $row['alt_title'];
        $description = $row['description'];
        $category = $row['category'];
        $subcategory = $row['subcategory'];
        $pricing = $row['pricing'];
        $price = $row['price'];
        $tags = $row['tags'];
        $user = $row['display_name'];
        $user_picture = $imagePath.$row['profile_picture'];
        $created_date = $row['created_at'];
        $status = $row['status'];
        $image_path = $imagePath.$row['picture'];
        $slug = $alt_title;
        $event_type = $row['event_type'] ?? '';
    

           // Fetch price variations for this report
    $priceSql = "SELECT price FROM {$siteprefix}training_tickets WHERE training_id = '$training_id'";
    $priceRes = mysqli_query($con, $priceSql);
    $prices = [];
    while ($priceRow = mysqli_fetch_assoc($priceRes)) {
        $prices[] = floatval($priceRow['price']);
    }

    // Determine price display
   if (count($prices) === 1) {
        $priceDisplay = $sitecurrency . number_format($prices[0], 2);
        $price = $prices[0];
    } if (count($prices) > 1) {
        $minPrice = min($prices);
        $maxPrice = max($prices);
        $priceDisplay = $sitecurrency . number_format($minPrice, 2) . ' - ' . $sitecurrency . number_format($maxPrice, 2);
        $price = $minPrice; // Use min price for sorting or other logic
    }

            $sql_resource_type = "SELECT name FROM {$siteprefix}event_types WHERE s = $event_type";
            $result_resource_type = mysqli_query($con, $sql_resource_type);

            while ($typeRow = mysqli_fetch_assoc($result_resource_type)) {
                $resourceTypeNames = $typeRow['name'];
            }
$rating_data = calculateRating($training_id, $con, $siteprefix);
    $average_rating = $rating_data['average_rating'];
    $review_count = $rating_data['review_count'];
        // Each slide
            include "swiper-card.php"; // Use your existing product card template
          }
        }
        ?>
      </div>
      <div class="recent-swiper-button-next swiper-button-next"></div>
      <div class="recent-swiper-button-prev swiper-button-prev"></div>
    </div>
  </div>
</section>

<section id="recent-posts" class="recent-posts section">
  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Latest Articles</h2>
    <p></p>
  </div><!-- End Section Title -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">
      <?php
      // Get training categories from current event
      $trainingCategoryIds = array_filter(array_map('intval', explode(',', $category)));
      $foundArticles = false;

      if (!empty($trainingCategoryIds)) {
          $conditions = [];
          foreach ($trainingCategoryIds as $catId) {
              $conditions[] = "FIND_IN_SET($catId, fp.categories)";
          }
          $whereClause = implode(' OR ', $conditions);

          $sql = "SELECT fp.*, u.display_name 
                  FROM {$siteprefix}forum_posts fp 
                  LEFT JOIN {$siteprefix}users u ON fp.user_id = u.s 
                  WHERE ($whereClause)
                  ORDER BY fp.created_at DESC 
                  LIMIT 3";

          $result = mysqli_query($con, $sql);

          while ($row = mysqli_fetch_assoc($result)) {
              $foundArticles = true;
              $s = $row['s'];
              $title = htmlspecialchars($row['title']);
              $date = date('d M Y', strtotime($row['created_at']));
              $uploader = htmlspecialchars($row['display_name']);
              $alt_title = htmlspecialchars($row['slug']);
              $image_path = $imagePath . $row['featured_image'];

              // Fetch category names
              $catNames = [];
              $catIds = [];

              if (!empty($row['categories'])) {
                  $catIds = preg_split('/\s*,\s*/', trim($row['categories']));
                  $catIds = array_filter(array_map('intval', $catIds));
                  if (!empty($catIds)) {
                      $catIdList = implode(',', $catIds);
                      $catSql = "SELECT id, category_name FROM {$siteprefix}categories WHERE id IN ($catIdList)";
                      $catRes = mysqli_query($con, $catSql);
                      while ($catRow = mysqli_fetch_assoc($catRes)) {
                          $catNames[] = $catRow['category_name'];
                      }
                  }
              }

              include 'blog-card.php'; // Your card template
          }
      }

      if (!$foundArticles) {
          echo '<div class="col-12"><div class="alert alert-info text-center">No related article found.</div></div>';
      }
      ?>
    </div>
  </div>
</section><!-- /Recent Posts Section -->

 
    
           <!-- Report Product Modal -->
<div class="modal fade" id="reportProductModal" tabindex="-1" aria-labelledby="reportProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="reportForm" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="reportProductModalLabel">Event <?php echo htmlspecialchars($title); ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($training_id); ?>">
          <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
          <div class="mb-1">
            <label for="reason" class="form-label">Reason for Reporting</label>
            <select class="form-select" name="reason" id="reason" required>
               <option value="">Select Reason</option>
              <option value="Inappropriate Content">Inappropriate Content</option>
              <option value="Copyright Violation">Copyright Violation</option>
              <option value="Spam or Misleading">Spam or Misleading</option>
              <option value="Other">Other</option>
            </select>
          </div>
          <div class="mb-1" id="customReasonContainer" style="display: none;">
            <label for="custom_reason" class="form-label">Custom Reason</label>
            <textarea class="form-control" name="custom_reason" id="custom_reason" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="submit_report" class="btn btn-danger">Submit Report</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const reasonSelect = document.getElementById("reason");
        const customReasonContainer = document.getElementById("customReasonContainer");

        reasonSelect.addEventListener("change", function () {
            if (this.value !== "") {
                customReasonContainer.style.display = "block";
            } else {
                customReasonContainer.style.display = "none";
            }
        });
    });
</script>


<script>

document.getElementById('webShareBtn').addEventListener('click', function() {
  if (navigator.share) {
    navigator.share({
      title: "<?php echo addslashes($title); ?>",
      text: "<?php echo addslashes($title); ?>",
      url: "<?php echo $siteurl . 'events/' . $slug; ?>"
    });
  } else {
    alert('Sharing is not supported in this browser. Please use the social icons.');
  }
});


</script>






<script>
document.addEventListener("DOMContentLoaded", function () {
    // Get the base site URL from the hidden input field
    const siteurl = document.getElementById("siteurl").value;

    document.querySelectorAll(".instructor-click").forEach(function (el) {
        el.addEventListener("click", function () {
            const userId = this.dataset.userId;

            fetch(siteurl + "get_instructor.php?user_id=" + userId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById("instructorPhoto").src = data.photo;
                        document.getElementById("instructorName").textContent = data.name;
                        document.getElementById("instructorBio").textContent = data.bio;
                        let instructorModal = new bootstrap.Modal(document.getElementById("instructorModal"));
                        instructorModal.show();
                    } else {
                        alert("Instructor not found.");
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert("Failed to load instructor data.");
                });
        });
    });
});
</script>



<?php include "footer.php"; ?>