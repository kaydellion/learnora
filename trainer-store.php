

<?php include "header.php"; 

if (isset($_GET['seller_id'])) {
    $seller_id = $_GET['seller_id'];
    
    // Fetch seller details
    $seller_query = "SELECT display_name, profile_photo, biography FROM ".$siteprefix."users WHERE s = '$seller_id'";
    $seller_result = mysqli_query($con, $seller_query);
    $seller_data = mysqli_fetch_assoc($seller_result);

    if (!$seller_data) {
        echo '<div class="container py-5"><div class="alert alert-danger">Seller not found.</div></div>';
        include "footer.php";
        exit;
    }

    $user = $seller_data['display_name'];
    $user_picture = $imagePath . $seller_data['profile_photo'];
    $seller_about = $seller_data['biography'];
// If company_name is not empty, use company_profile as seller_about


} else {
    header("Location: index.php");
    exit;
}

$limit = 16; // Number of reports per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Handle sorting
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'relevance';
$order_by = "t.training_id DESC"; // Default sorting by relevance
if ($sort === 'price_high') {
    $order_by = "tt.price DESC";
} elseif ($sort === 'price_low') {
    $order_by = "tt.price ASC";
}





// Fetch seller's products
$query =  "SELECT t.*, u.name as display_name,  tt.price, u.photo as profile_picture, l.category_name AS category, sc.category_name AS subcategory, ti.picture 
    FROM ".$siteprefix."training t
    LEFT JOIN ".$siteprefix."categories l ON t.category = l.id 
    LEFT JOIN ".$siteprefix."instructors u ON t.instructors = u.s
    LEFT JOIN ".$siteprefix."categories sc ON t.subcategory = sc.id 
    LEFT JOIN ".$siteprefix."training_tickets tt ON t.training_id= tt.training_id
    LEFT JOIN ".$siteprefix."training_images ti ON t.training_id = ti.training_id 
WHERE t.user = '$seller_id' 
  AND t.status = 'approved'
GROUP BY t.training_id
ORDER BY $order_by
LIMIT $limit OFFSET $offset";
$result = mysqli_query($con, $query);
$report_count = mysqli_num_rows($result);

// Get total number of reports
$total_query = "SELECT COUNT(*) as total FROM ".$siteprefix."training WHERE status = 'approved' AND user='$seller_id'";
$total_result = mysqli_query($con, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_reports = $total_row['total'];
$total_pages = ceil($total_reports / $limit);
?>
<?php

// Fetch the number of followers
$followersQuery = "SELECT COUNT(*) AS total_followers FROM {$siteprefix}followers WHERE seller_id = '$seller_id'";
$followersResult = mysqli_query($con, $followersQuery);
$followersData = mysqli_fetch_assoc($followersResult);
$totalFollowers = $followersData['total_followers'] ?? 0;

// Fetch the number of followings
$followingsQuery = "SELECT COUNT(*) AS total_followings FROM {$siteprefix}followers WHERE user_id = '$seller_id'";
$followingsResult = mysqli_query($con, $followingsQuery);
$followingsData = mysqli_fetch_assoc($followingsResult);
$totalFollowings = $followingsData['total_followings'] ?? 0;




?>

   <!-- Search Results Header Section -->
    <section id="search-results-header" class="search-results-header section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
    <!-- Seller Information -->
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="d-flex align-items-center mb-3">
                <!-- Seller Image -->
                <img src="<?php echo $user_picture; ?>" alt="Seller Photo" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                <div>
                    <!-- Seller Name -->
                    <h3><?php echo $user; ?></h3>
                    <!-- About Us -->
                    <p class="mb-1 text-muted">
                    About the Seller: 
                    <span class="seller-bio-preview">
                        <?php 
                        $words = explode(' ', $seller_about);
                        echo implode(' ', array_slice($words, 0, 4)); // Display first 4 words
                        ?>
                    </span>
                    
                    <span class="seller-bio-full" style="display: none;">
                        <?php echo $seller_about; ?>
                    </span>
                    <?php if (str_word_count($seller_about) > 4) { ?>
        <button class="btn btn-link btn-sm p-0 read-mores-btn" style="text-decoration: none;">Read More</button>
    <?php } ?>
                
                </p>
                    <!-- Follow/Unfollow Button -->
                    </div></div>
					</div></div>

                      <?php
    // Check if the user is already following the seller
    $followQuery = "SELECT * FROM {$siteprefix}followers WHERE user_id = ? AND seller_id = ?";
    $stmt = $con->prepare($followQuery);
    $stmt->bind_param("ii", $user_id, $seller_id);
    $stmt->execute();
    $followResult = $stmt->get_result();
    $isFollowing = $followResult->num_rows > 0;
    ?>

        <div class="search-results-header">
          <div class="row align-items-center">
          
				
                     
    <?php
    // Check if the user is already following the seller
    $followQuery = "SELECT * FROM {$siteprefix}followers WHERE user_id = ? AND seller_id = ?";
    $stmt = $con->prepare($followQuery);
    $stmt->bind_param("ii", $user_id, $seller_id);
    $stmt->execute();
    $followResult = $stmt->get_result();
    $isFollowing = $followResult->num_rows > 0;
    ?>
  <!-- Follow and Sort Controls -->
   
   <div class="col-lg-12">
  <div class="d-flex align-items-center">
     <?php if ($active_log == 1): ?>
                    <!-- Follow Seller -->
                    <form method="POST" class="d-inline me-3">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <input type="hidden" name="seller_id" value="<?php echo $seller_id; ?>">
                        <input type="hidden" name="follow_seller_submit" value="1">

                        <?php if ($isFollowing): ?>
                            <div class="dropdown">
                                <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" id="followingDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Following
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="followingDropdown">
                                    <li>
                                        <button type="submit" name="action" value="unfollow" class="dropdown-item">
                                            Unfollow
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <button type="submit" name="action" value="follow" class="btn btn-outline-primary btn-sm">
                                Follow Seller
                            </button>
                            
                        <?php endif; ?>
                    </form>
                     <?php endif; ?>
                    <div class="d-flex align-items-center d-none d-md-flex">
                <span class="product-count me-2" style="background-color: orange; color: white; padding: 5px 10px; border-radius: 5px;">Followers: <?php echo $totalFollowers; ?></span>
                <span class="product-count me-2" style="background-color: orange; color: white; padding: 5px 10px; border-radius: 5px;">Followings: <?php echo $totalFollowings; ?></span>
                   </div>
                   
                    <!-- Sort Dropdown -->
                    <div class="d-flex align-items-center me-2">
                        
                        <select id="sort-select" class="form-select form-select-sm" onchange="sortReports(this.value)" style="width: auto;">
                            <option value="relevance" <?php if ($sort === 'relevance') echo 'selected'; ?>>Relevance</option>
                            <option value="price_high" <?php if ($sort === 'price_high') echo 'selected'; ?>>Price - High To Low</option>
                            <option value="price_low" <?php if ($sort === 'price_low') echo 'selected'; ?>>Price - Low To High</option>
                        </select>
                    </div>
                    <div class="product-count me-2" style="background-color: orange; color: white; padding: 5px 10px; border-radius: 5px;">
                        Found <?php echo $report_count; ?> event(s)
                        </div>

                </div>
                <div class="col-lg-12 mt-2 d-block d-md-none">
    <div class="d-flex align-items-center">
        <span class="product-count me-2" style="background-color: orange; color: white; padding: 5px 10px; border-radius: 5px;">Followers: <?php echo $totalFollowers; ?></span>
        <span class="product-count me-2" style="background-color: orange; color: white; padding: 5px 10px; border-radius: 5px;">Followings: <?php echo $totalFollowings; ?></span>
    </div>
</div>
        </div>
      </div>
		 </div>
    </section><!-- /Search Results Header Section -->

    
 <!-- Best Sellers Section -->
    <section id="best-sellers" class="best-sellers section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4">
          <!-- Product 1 -->
          <?php
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
        include "event-card.php"; // Include the product card template
        }
      
?>
       </div>
  <div class="text-center mt-5" data-aos="fade-up">
          <a href="<?php echo $siteurl; ?>marketplace" class="view-all-btn">View All Events <i class="bi bi-arrow-right"></i></a>

		  <?php } else {  debug('No reports not found.'); }?>
        </div>


        </div>

      </div>

    </section>

 <!-- Category Pagination Section -->
    <section id="category-pagination" class="category-pagination section">

      <div class="container">
        <nav class="d-flex justify-content-center" aria-label="Page navigation">
          <ul>
                <?php if ($page > 1): ?>
                   <li>
              <a href="?searchterm=<?php echo $filter; ?>&page=<?php echo $page - 1; ?>" aria-label="Previous page">
                <i class="bi bi-arrow-left"></i>
                <span class="d-none d-sm-inline">Previous</span>
              </a>
            </li>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
         <li> <a href="?seller_id=<?php echo $seller_id; ?>&page=<?php echo $i; ?>&sort=<?php echo $sort; ?>" class="btn btn-secondary <?php if ($i == $page) echo 'active'; ?>"><?php echo $i; ?></a>  </li>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
         <li>
              <a href="?seller_id=<?php echo $seller_id; ?>&page=<?php echo $page + 1; ?>&sort=<?php echo $sort; ?>" aria-label="Next page">
                <span class="d-none d-sm-inline">Next</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </li>
        
    <?php endif; ?>

          
          </ul>
        </nav>
      </div>

    </section><!-- /Category Pagination Section -->



    <script>
    function sortReports(sortValue) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('sort', sortValue);
        window.location.search = urlParams.toString();
    }
</script>
<section>
<div class="container">
    <div class="row">
         <div class="section-title text-center mb-4">
    <h4> You can also check out this seller</h4>
</div>
<?php
$sellers_query = "SELECT 
                    u.s AS seller_id,
                    u.display_name AS seller_name,
                    u.profile_photo AS seller_photo,
                    u.biography AS seller_about,
                    u.company_name,
                    u.company_profile,
                    u.facebook AS seller_facebook,
                    u.twitter AS seller_twitter,
                    u.instagram AS seller_instagram,
                    u.linkedin AS seller_linkedin
                  FROM {$siteprefix}users u
                  WHERE u.trainer = '1' AND u.status = 'active' ORDER BY RAND()
                  LIMIT 3";
$sellers_result = mysqli_query($con, $sellers_query);
?>
<?php if (mysqli_num_rows($sellers_result) > 0): ?>
 <?php while ($seller = mysqli_fetch_assoc($sellers_result)): 
      $seller_id = $seller['seller_id'];
      $seller_name = htmlspecialchars($seller['seller_name']);
      $seller_about_raw = $seller['seller_about'];
      $about_words = explode(' ', strip_tags($seller_about_raw));
      $seller_about = implode(' ', array_slice($about_words, 0, 8)) . (count($about_words) > 8 ? '...' : '');
      $seller_photo = !empty($seller['seller_photo']) ? $imagePath . $seller['seller_photo'] : 'default-avatar.png';

      // Social Links
    $seller_facebook = $seller['seller_facebook'];
$seller_twitter = $seller['seller_twitter'];
$seller_instagram = $seller['seller_instagram'];
$seller_linkedin = $seller['seller_linkedin'];

      // Get seller resource count
      $count_query = mysqli_query($con, "SELECT COUNT(*) AS total FROM {$siteprefix}training WHERE user = '$seller_id' AND status = 'approved'");
      $count_data = mysqli_fetch_assoc($count_query);
      $resource_count = $count_data['total'];
    ?>
      <div class="col-6 col-md-4 mb-4 gx-3">
        <div class="card h-100 shadow-sm">
          <img src="<?php echo $seller_photo; ?>" class="card-img-top" alt="<?php echo $seller_name; ?>" style="object-fit: cover; height: 200px;">
          <div class="card-body">
            <h5 class="card-title d-flex justify-content-between align-items-center">
              <?php echo $seller_name; ?>
              <span class="badge bg-success"><?php echo $resource_count; ?> resources</span>
            </h5>
            <p class="card-text"><?php echo htmlspecialchars($seller_about); ?></p>

            <!-- Social Media Icons -->
            <div class="">
                 <?php if (!empty($seller_facebook)) { ?>
            <a href="https://www.facebook.com/<?php echo str_replace(' ', '-', $seller_facebook); ?>" target="_blank" class="text-decoration-none me-3">
                <i class="fab fa-facebook text-primary" style="font-size: 1.5rem;"></i>
            </a>
        <?php } ?>
        <?php if (!empty($seller_twitter)) { ?>
            <a href="https://twitter.com/<?php echo str_replace(' ', '-', $seller_twitter); ?>" target="_blank" class="text-decoration-none me-3">
                <i class="fab fa-twitter text-info" style="font-size: 1.5rem;"></i>
            </a>
        <?php } ?>
        <?php if (!empty($seller_instagram)) { ?>
            <a href="https://www.instagram.com/<?php echo str_replace(' ', '-', $seller_instagram); ?>" target="_blank" class="text-decoration-none me-3">
                <i class="fab fa-instagram text-danger" style="font-size: 1.5rem;"></i>
            </a>
        <?php } ?>
        <?php if (!empty($seller_linkedin)) { ?>
            <a href="https://www.linkedin.com/in/<?php echo str_replace(' ', '-', $seller_linkedin); ?>" target="_blank" class="text-decoration-none me-3">
                <i class="fab fa-linkedin text-primary" style="font-size: 1.5rem;"></i>
            </a>
        <?php } ?>
            </div>

            <a href="<?php echo $siteurl; ?>trainer-store?seller_id=<?php echo $seller_id; ?>" class="btn btn-primary btn-sm w-100">View Profile</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
<?php else: ?>
  <p>No active trainers found.</p>
<?php endif; ?>
 </div>
  </div>
</section>




    <?php include "footer.php"; ?>
