<?php

include "header.php";

// ✅ Step 1: Load main category by slug
if (isset($_GET['slugs'])) {
    $slug = mysqli_real_escape_string($con, $_GET['slugs']);
    $sql = "SELECT * FROM {$siteprefix}categories WHERE slug = '$slug' LIMIT 1";
    $sql2 = mysqli_query($con, $sql);

    if (!$sql2 || mysqli_num_rows($sql2) == 0) {
        header("Location: " . $siteurl . "index.php");
        exit();
    }

    $row = mysqli_fetch_assoc($sql2);
    $id = $row['id'];
    $category_name = $row['category_name'];
} else {
    header("Location: " . $siteurl . "index.php");
    exit();
}

// ✅ Step 2: Pagination
$limit = 16;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// ✅ Step 3: Sorting
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'relevance';
$order_by = "t.training_id DESC";
if ($sort === 'price_high') $order_by = "tt.price IS NULL, tt.price DESC";
if ($sort === 'price_low') $order_by = "tt.price IS NULL, tt.price ASC";

// ✅ Step 4: Multi-level subcategory chain
$subcategory_chain = isset($_GET['subcategory']) && $_GET['subcategory'] !== '' ? explode(',', $_GET['subcategory']) : [];

$subcategory_condition = '';
if (!empty($subcategory_chain)) {
    $last_slug = end($subcategory_chain);
    $last_slug_safe = mysqli_real_escape_string($con, $last_slug);
    $subcat_result = mysqli_query($con, "SELECT id FROM {$siteprefix}categories WHERE slug = '$last_slug_safe'");
    if ($subcat_row = mysqli_fetch_assoc($subcat_result)) {
        $subcat_id = $subcat_row['id'];
        $subcategory_condition = "AND FIND_IN_SET('$subcat_id', t.subcategory)";
    }
}

// ✅ Step 5: Main query
$query = "SELECT t.*, u.name AS display_name, tt.price, u.photo AS profile_picture, 
                 l.category_name AS category, sc.category_name AS subcategory, ti.picture 
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
                SELECT 1 FROM {$siteprefix}training_event_dates d
                WHERE d.training_id = t.training_id 
                  AND (d.event_date > CURDATE() OR (d.event_date = CURDATE() AND d.end_time >= CURTIME()))
            )
          GROUP BY t.training_id
          ORDER BY $order_by
          LIMIT $limit OFFSET $offset";

$result = mysqli_query($con, $query);
$report_count = mysqli_num_rows($result);

// ✅ Step 6: Total for pagination
$total_query = "SELECT COUNT(DISTINCT t.training_id) AS total 
                FROM {$siteprefix}training t
                WHERE t.status = 'approved'
                  AND FIND_IN_SET('$id', t.category) 
                  $subcategory_condition
                  AND EXISTS (
                      SELECT 1 FROM {$siteprefix}training_event_dates d
                      WHERE d.training_id = t.training_id 
                        AND (d.event_date > CURDATE() OR (d.event_date = CURDATE() AND d.end_time >= CURTIME()))
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
    <!-- Filters -->
    <div class="row mb-3">
      <div class="col-lg-12">
        <!-- Category Header Section -->
          <section id="category-header" class="category-header section">
		    <div class="container" data-aos="fade-up">

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
              <!-- Subcategory Dropdown Chain -->
 
  <!-- Tier 1: Main Category (already selected by slug) -->
  <!-- Tier 2: Subcategory -->
  <div class="col-lg-3 col-12">
    <div class="filter-item">
      <label class="form-label">Subcategory</label>
      <select class="form-select" id="subcategory-select" onchange="updateCategoryFilters()">
        <option value="">-- Select Subcategory --</option>
        <?php
        $subcat_query = "SELECT slug, category_name FROM {$siteprefix}categories WHERE parent_id = '$id'";
        $subcat_result = mysqli_query($con, $subcat_query);
        while ($subcat_row = mysqli_fetch_assoc($subcat_result)) {
          $selected = (isset($subcategory_chain[0]) && $subcategory_chain[0] === $subcat_row['slug']) ? 'selected' : '';
          echo '<option value="' . htmlspecialchars($subcat_row['slug']) . '" ' . $selected . '>' . htmlspecialchars($subcat_row['category_name']) . '</option>';
        }
        ?>
      </select>
    </div>
  </div>
  <!-- Tier 3: Sub-subcategory -->
  <div class="col-lg-3 col-12">
    <div class="filter-item">
      <label class="form-label">Sub-subcategory</label>
      <select class="form-select" id="subsubcategory-select" onchange="updateCategoryFilters()">
        <option value="">-- Select Sub-subcategory --</option>
        <?php
        $subcat_id = '';
        if (isset($subcategory_chain[0])) {
          $slug_safe = mysqli_real_escape_string($con, $subcategory_chain[0]);
          $res = mysqli_query($con, "SELECT id FROM {$siteprefix}categories WHERE slug = '$slug_safe'");
          if ($row = mysqli_fetch_assoc($res)) $subcat_id = $row['id'];
        }
        if ($subcat_id) {
          $subsubcat_query = "SELECT slug, category_name FROM {$siteprefix}categories WHERE parent_id = '$subcat_id'";
          $subsubcat_result = mysqli_query($con, $subsubcat_query);
          while ($subsubcat_row = mysqli_fetch_assoc($subsubcat_result)) {
            $selected = (isset($subcategory_chain[1]) && $subcategory_chain[1] === $subsubcat_row['slug']) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($subsubcat_row['slug']) . '" ' . $selected . '>' . htmlspecialchars($subsubcat_row['category_name']) . '</option>';
          }
        }
        ?>
      </select>
    </div>
  </div>
  <!-- Tier 4: Sub-sub-subcategory -->
  <div class="col-lg-3 col-12">
    <div class="filter-item">
      <label class="form-label">Sub-sub-subcategory</label>
      <select class="form-select" id="subsubsubcategory-select" onchange="updateCategoryFilters()">
        <option value="">-- Select Sub-sub-subcategory --</option>
        <?php
        $subsubcat_id = '';
        if (isset($subcategory_chain[1])) {
          $slug_safe = mysqli_real_escape_string($con, $subcategory_chain[1]);
          $res = mysqli_query($con, "SELECT id FROM {$siteprefix}categories WHERE slug = '$slug_safe'");
          if ($row = mysqli_fetch_assoc($res)) $subsubcat_id = $row['id'];
        }
        if ($subsubcat_id) {
          $subsubsubcat_query = "SELECT slug, category_name FROM {$siteprefix}categories WHERE parent_id = '$subsubcat_id'";
          $subsubsubcat_result = mysqli_query($con, $subsubsubcat_query);
          while ($subsubsubcat_row = mysqli_fetch_assoc($subsubsubcat_result)) {
            $selected = (isset($subcategory_chain[2]) && $subcategory_chain[2] === $subsubsubcat_row['slug']) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($subsubsubcat_row['slug']) . '" ' . $selected . '>' . htmlspecialchars($subsubsubcat_row['category_name']) . '</option>';
          }
        }
        ?>
      </select>
    </div>
  </div>


              <!-- Sort Dropdown -->
              <div class="col-12 col-md-4">
                <div class="filter-item">
                <label for="sortBy" class="form-label">Sort By</label>
                </div>
                <select id="sort-select" class="form-select" onchange="sortReports(this.value)">
                  <option value="relevance" <?php if ($sort === 'relevance') echo 'selected'; ?>>Relevance</option>
                  <option value="price_high" <?php if ($sort === 'price_high') echo 'selected'; ?>>Price - High To Low</option>
                  <option value="price_low" <?php if ($sort === 'price_low') echo 'selected'; ?>>Price - Low To High</option>
                </select>
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
       <!-- Pagination -->
       <!-- Pagination -->
        <section id="category-pagination" class="category-pagination section">
          <div class="container">
            <nav class="d-flex justify-content-center" aria-label="Page navigation">
              <ul>
                <?php if ($page > 1): ?>
                  <li>
                    <a href="?slug=<?php echo $slug; ?>&page=<?php echo $page-1; ?>&sort=<?php echo $sort; ?>&subcategory=<?php echo implode(',', $subcategory_chain); ?>">
                      <i class="bi bi-arrow-left"></i> Previous
                    </a>
                  </li>
                <?php endif; ?>
                <?php for ($i=1; $i<=$total_pages; $i++): ?>
                  <li>
                    <a href="?slug=<?php echo $slug; ?>&page=<?php echo $i; ?>&sort=<?php echo $sort; ?>&subcategory=<?php echo implode(',', $subcategory_chain); ?>" class="<?php if ($i==$page) echo 'active'; ?>">
                      <?php echo $i; ?>
                    </a>
                  </li>
                <?php endfor; ?>
                <?php if ($page < $total_pages): ?>
                  <li>
                    <a href="?slug=<?php echo $slug; ?>&page=<?php echo $page+1; ?>&sort=<?php echo $sort; ?>&subcategory=<?php echo implode(',', $subcategory_chain); ?>">
                      Next <i class="bi bi-arrow-right"></i>
                    </a>
                  </li>
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
    <img src="<?php echo $siteurl.$seller_photo; ?>" class="card-img-top" alt="<?php echo $seller_name; ?>" style="object-fit: cover; height: 200px;">

    <div class="card-body d-flex flex-column">
      <h5 class="card-title  justify-content-between align-items-center">
        <span class="text-truncate" style="max-width: 70%;"><?php echo $seller_name; ?></span><br>
        <span class="badge bg-success text-white"><?php echo $resource_count; ?> resources</span>
      </h5>
     <br>
        
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
// ✅ Sorting
function sortReports(sortValue) {
  const urlParams = new URLSearchParams(window.location.search);
  urlParams.set('sort', sortValue);
  window.location.search = urlParams.toString();
}

// ✅ Multi-level subcategory loader
function updateCategoryFilters() {
  const subcat = document.getElementById('subcategory-select').value;
  const subsubcat = document.getElementById('subsubcategory-select').value;
  const subsubsubcat = document.getElementById('subsubsubcategory-select').value;
  const chain = [];
  if (subcat) chain.push(subcat);
  if (subsubcat) chain.push(subsubcat);
  if (subsubsubcat) chain.push(subsubsubcat);

  const urlParams = new URLSearchParams(window.location.search);
  urlParams.set('subcategory', chain.join(','));
  window.location.search = urlParams.toString();
}
</script>

          <?php include "footer.php"; ?>