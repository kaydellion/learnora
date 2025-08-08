
<?php 

include "header.php"; 

if (isset($_GET['slugs'])) {
    $raw_slug = $_GET['slugs'];
  
    $category_names = $raw_slug; // convert to lowercase for ma


    // Prepare SQL: match using LOWER to handle case insensitivity
    $sql = "SELECT * FROM " . $siteprefix . "categories WHERE slug = '$category_names'";
    $sql2 = mysqli_query($con, $sql);

    if (!$sql2) {
        die("Query failed: " . mysqli_error($con));
    }

    $count = 0;
    while ($row = mysqli_fetch_array($sql2)) {
        $id = $row['id'];
        $category_name = $row['category_name'];
        // You can use other fields here too if needed
    }
} else {
    header("Location: " . $siteurl . "index.php");
    exit();
}
$limit = 16; // Number of reports per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Handle sorting
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'relevance';
$order_by = "t.training_id DESC"; // Default sorting by relevance
if ($sort === 'price_high') {
    $order_by = "tt.price DESC";
} elseif ($sort === 'price_low') {
    $order_by = "tt.price ASC";
}

// Subcategory filtering
$subcategory_filter = isset($_GET['subcategory']) ? $_GET['subcategory'] : '';
$subcategory_condition = '';

if (!empty($subcategory_filter) && $subcategory_filter !== 'all') {
    $subcategory_slug = mysqli_real_escape_string($con, $subcategory_filter);
    $subcat_result = mysqli_query($con, "SELECT id FROM {$siteprefix}categories WHERE slug = '$subcategory_slug'");
    if ($subcat_row = mysqli_fetch_assoc($subcat_result)) {
        $subcat_id = $subcat_row['id'];
        $subcategory_condition = "AND FIND_IN_SET('$subcat_id', t.subcategory)";
    }
}

$query = "SELECT t.*, 
                u.name AS display_name, 
                tt.price, 
                u.photo AS profile_picture, 
                l.category_name AS category, 
                sc.category_name AS subcategory, 
                ti.picture 
          FROM {$siteprefix}training t
          LEFT JOIN {$siteprefix}categories l ON t.category = l.id 
          LEFT JOIN {$siteprefix}instructors u ON t.instructors = u.s
          LEFT JOIN {$siteprefix}categories sc ON t.subcategory = sc.id 
          LEFT JOIN {$siteprefix}training_tickets tt ON t.training_id = tt.training_id
          LEFT JOIN {$siteprefix}training_images ti ON t.training_id = ti.training_id
          WHERE t.status = 'approved'  
            AND FIND_IN_SET('$id', t.category) 
            $subcategory_condition
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
          ORDER BY $order_by 
          LIMIT $limit OFFSET $offset";

$result = mysqli_query($con, $query);
$report_count = mysqli_num_rows($result);


// Get total number of reports

$total_query = "SELECT COUNT(DISTINCT t.training_id) AS total 
                FROM {$siteprefix}training t 
                LEFT JOIN {$siteprefix}categories sc ON t.subcategory = sc.id 
                WHERE t.status = 'approved'  
                  AND FIND_IN_SET('$id', t.category) 
                  $subcategory_condition
                  AND EXISTS (
                      SELECT 1 
                      FROM {$siteprefix}training_event_dates d
                      WHERE d.training_id = t.training_id
                      AND (
                          d.event_date > CURDATE() 
                          OR (d.event_date = CURDATE() AND d.end_time >= CURTIME())
                      )
                  )";

$total_result = mysqli_query($con, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_reports = $total_row['total'];
$total_pages = ceil($total_reports / $limit);

?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0"><?php echo $category_name; ?></h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Category</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

        <div class="container" data-aos="fade-up">
       <div class="row mb-3">
        <div class="col-lg-12">

          <!-- Category Header Section -->
          <section id="category-header" class="category-header section">

            <div class="container" data-aos="fade-up">

              <!-- Filter and Sort Options -->
              <div class="filter-container mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="row g-3">
                            <div class="col-7 col-md-3 col-lg-3">
             <?php if ($active_log != "0"): ?>
                <form method="POST" class="d-inline">
                    <?php
                    $followCategoryQuery = "SELECT * FROM ".$siteprefix."followers WHERE user_id = '$user_id' AND category_id = '$id'";
                    $followCategoryResult = mysqli_query($con, $followCategoryQuery);
                    $isFollowingCategory = mysqli_num_rows($followCategoryResult) > 0;
                    ?>
                    <?php if ($isFollowingCategory): ?>
                      <div class="filter-item">
                      <label class="form-label">Unfollow Now:</label><br>
                        <button type="submit" name="actioning" value="unfollow_category" class="btn btn-outline-danger ">
                            unfollow Category
                        </button>
                    </div>
                    <?php else: ?>
                      <div class="filter-item">
                      <label class="form-label">follow Now:</label><br>
                        <button type="submit" name="actioning" value="follow_category" class="btn btn-outline-primary">
                            Follow Category
                        </button>
                    </div>
                    <?php endif; ?>
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <input type="hidden" name="category_id" value="<?php echo $id; ?>">
                    <input type="hidden" name="subcategory_id" value="">
                    <input type="hidden" name="follow_category_submit" value="1">
                </form>
            <?php endif; ?>
            </div>
                  <div class="col-6 col-md-5 col-lg-5">
				    <div class="filter-item">
                      <label for="priceRange" class="form-label">filter By Subcategory</label>
         <select id="subcategory-select" class="form-select" onchange="filterBySubcategory(this.value)">
        <option value="">-- Select Subcategory --</option>
        <option value="all" <?= (!isset($_GET['subcategory']) || $_GET['subcategory'] === 'all') ? 'selected' : '' ?>>Show All</option>
        <?php
        $subcat_query = "SELECT DISTINCT slug, category_name AS subcategory 
                         FROM {$siteprefix}categories 
                         WHERE parent_id = $id";
        $subcat_result = mysqli_query($con, $subcat_query);
        while ($subcat_row = mysqli_fetch_assoc($subcat_result)) {
            $subcategorySlug = $subcat_row['slug'];
            $selected = (isset($_GET['subcategory']) && $_GET['subcategory'] === $subcategorySlug) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($subcategorySlug) . '" ' . $selected . '>' . htmlspecialchars($subcat_row['subcategory']) . '</option>';
        }
        ?>
      </select>
                  </div>
				    </div>

                      <div class="col-6 col-md-4 col-lg-4">
                    <div class="filter-item">
                      <label for="sortBy" class="form-label">Sort By</label>
                      <select id="sort-select" class="form-select" onchange="sortReports(this.value)">
                        <option value="" <?php if ($sort === '') echo 'selected'; ?> disabled>- Sort By -</option>
                <option value="relevance" <?php if ($sort === 'relevance') echo 'selected'; ?>>Relevance</option>
                <option value="price_high" <?php if ($sort === 'price_high') echo 'selected'; ?>>Price - High To Low</option>
                <option value="price_low" <?php if ($sort === 'price_low') echo 'selected'; ?>>Price - Low To High</option>
            </select>
                    </div>
                  </div>
                   </div>

                             <div class="row mt-3">
                  <div class="col-12" data-aos="fade-up" data-aos-delay="200">
                    <div class="active-filters">
                    
                      <div class="filter-tags">
                       
                        <button class="clear-all-btn">Found <?php echo $report_count; ?> event(s)</button>
                      </div>
                    </div>
                  </div>
                </div>
                 </div>

            </div>

          </section><!-- /Category Header Section -->

            <!-- Category Product List Section -->
          <section id="category-product-list" class="best-sellers section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

              <div class="row gy-4">
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
} else {
    echo "<p>No events found.</p>";
}
?>
            </div>

                 </div>

      

          </section><!-- /Category Product List Section -->


                  <!-- Category Pagination Section -->
          <section id="category-pagination" class="category-pagination section">

            <div class="container">
              <nav class="d-flex justify-content-center" aria-label="Page navigation">
                <ul>
                      <?php if ($page > 1): ?>
                      <li>
                    <a href="?id=<?php echo $id; ?>&page=<?php echo $page - 1; ?>&sort=<?php echo $sort; ?>" aria-label="Previous page">
                      <i class="bi bi-arrow-left"></i>
                      <span class="d-none d-sm-inline">Previous</span>
                    </a>
                  </li>
                <?php endif; ?>
               

                
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                     <li> <a href="?id=<?php echo $id; ?>&page=<?php echo $i; ?>&sort=<?php echo $sort; ?>" class="btn btn-secondary <?php if ($i == $page) echo 'active'; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>

                 <?php if ($page < $total_pages): ?>
                   <li> <a href="?id=<?php echo $id; ?>&page=<?php echo $page + 1; ?>&sort=<?php echo $sort; ?>" class="btn btn-primary"><span class="d-none d-sm-inline">Next</span>
                      <i class="bi bi-arrow-right"></i></a></li>
                <?php endif; ?>
                  
                </ul>
              </nav>
            </div>

          </section><!-- /Category Pagination Section -->
		     </div>
			    </div>
				 </div>


<section>
   <div class="container section-title" data-aos="fade-up">
        <h2>Approved Trainers</h2>
        <p class="text-muted">Meet our approved trainers who are ready to help you learn and grow.</p>
                 </div>
<div class="container">
    <div class="row">
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
LIMIT 4;";
$sellers_result = mysqli_query($con, $sellers_query);
?>
<?php if (mysqli_num_rows($sellers_result) > 0): ?>
 <?php while ($seller = mysqli_fetch_assoc($sellers_result)): 
      $seller_id = $seller['seller_id'];
      $seller_name = htmlspecialchars($seller['seller_name']);
      $seller_about_raw =$seller['seller_about'];
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

<div class="col-6 col-md-4 col-lg-3 mb-4">
  <div class="card h-100 shadow-sm border-0">
    <img src="<?php echo $seller_photo; ?>" class="card-img-top" alt="<?php echo $seller_name; ?>" style="object-fit: cover; height: 200px;">

    <div class="card-body d-flex flex-column">
      <h5 class="card-title d-flex justify-content-between align-items-center">
        <span class="text-truncate" style="max-width: 70%;"><?php echo $seller_name; ?></span>
        <span class="badge bg-success text-white"><?php echo $resource_count; ?> resources</span>
      </h5>

      <p class="card-text text-muted" style="font-size: 0.9rem;"><?php echo htmlspecialchars($seller_about); ?></p>

      <div class="mt-auto mb-3">
        <?php if (!empty($seller_facebook)) { ?>
          <a href="<?php echo $seller_facebook; ?>" target="_blank" class="me-2">
            <i class="bi bi-facebook fa-lg text-primary"></i>
          </a>
        <?php } ?>
        <?php if (!empty($seller_twitter)) { ?>
          <a href="<?php echo $seller_twitter; ?>" target="_blank" class="me-2">
            <i class="fab fa-twitter fa-lg text-info"></i>
          </a>
        <?php } ?>
        <?php if (!empty($seller_instagram)) { ?>
          <a href="<?php echo $seller_instagram; ?>" target="_blank" class="me-2">
            <i class="fab fa-instagram fa-lg text-danger"></i>
          </a>
        <?php } ?>
        <?php if (!empty($seller_linkedin)) { ?>
          <a href="<?php echo $seller_linkedin; ?>" target="_blank" class="me-2">
            <i class="fab fa-linkedin fa-lg text-primary"></i>
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
  <p>No active sellers found.</p>
<?php endif; ?>
 </div>
  </div>
</section>

</main>


<script>
function sortReports(sortValue) {
  const urlParams = new URLSearchParams(window.location.search);
  urlParams.set('sort', sortValue);
  window.location.search = urlParams.toString();
}

function filterBySubcategory(subcategory) {
  const urlParams = new URLSearchParams(window.location.search);
  if (subcategory === "all") {
    urlParams.delete('subcategory');
  } else {
    urlParams.set('subcategory', subcategory);
  }
  window.location.search = urlParams.toString();
}
</script>

          <?php include "footer.php"; ?>