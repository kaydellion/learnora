

<?php include "header.php"; 

// Get selected state from URL parameter
$selected_state = isset($_GET['state']) ? mysqli_real_escape_string($con, $_GET['state']) : '';
$selected_delivery_format = isset($_GET['format']) ? mysqli_real_escape_string($con, $_GET['format']) : '';

// Get all unique states for the filter dropdown
$states_query = "SELECT DISTINCT physical_state FROM {$siteprefix}training 
                 WHERE physical_state IS NOT NULL AND physical_state != '' 
                 AND status = 'approved'
                 ORDER BY physical_state ASC";
$states_result = mysqli_query($con, $states_query);
$available_states = [];
while ($state_row = mysqli_fetch_assoc($states_result)) {
    $available_states[] = $state_row['physical_state'];
}

$limit = 16; // Number of events per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

$order_by = "t.training_id DESC"; // Default order
switch ($filter) {
    case 'low to high':
        $order_by = "tt.price ASC";
        break;
    case 'high to low':
        $order_by = "tt.price DESC";
        break;
    case 'newest':
        $order_by = "t.created_at DESC";
        break;
    case 'oldest':
        $order_by = "t.created_at ASC";
        break;
    case 'a-z':
        $order_by = "t.title ASC";
        break;
    case 'z-a':
        $order_by = "t.title DESC";
        break;
}

// Build WHERE conditions for state and format filtering
$where_conditions = ["t.status = 'approved'"];

if (!empty($selected_state)) {
    $where_conditions[] = "(t.physical_state = '$selected_state' OR t.hybrid_state = '$selected_state')";
}

if (!empty($selected_delivery_format)) {
    $where_conditions[] = "t.delivery_format = '$selected_delivery_format'";
}

$where_clause = implode(' AND ', $where_conditions);

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
          WHERE $where_clause
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
//if (!$result) {die('Error in SQL query: ' . mysqli_error($con));}
$report_count = mysqli_num_rows($result);


// Get total number of events with the same filters
$total_query = "
    SELECT COUNT(*) AS total 
    FROM {$siteprefix}training t
    WHERE $where_clause
      AND EXISTS (
          SELECT 1 
          FROM {$siteprefix}training_event_dates d
          WHERE d.training_id = t.training_id
            AND (
                d.event_date > CURDATE() 
                OR (d.event_date = CURDATE() AND d.end_time >= CURTIME())
            )
      )
";
$total_result = mysqli_query($con, $total_query);

if (!$total_result) {
    die('Error in total query: ' . mysqli_error($con));
}
$total_row = mysqli_fetch_assoc($total_result);
$total_reports = $total_row['total'];
$total_pages = ceil($total_reports / $limit);
?>

    <!-- Page Title Section -->
    <section id="page-title" class="page-title section">
      <div class="container" data-aos="fade-up">
        <div class="text-center">
          <h1>Events by State</h1>
          <p class="lead">Find training events and courses available in different states across Nigeria</p>
        </div>
      </div>
    </section>

    <!-- State Filter Section -->
    <section id="state-filter" class="state-filter section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="filter-card bg-light p-4 rounded">
              <form method="GET" action="events-by-state.php" class="row g-3">
                <div class="col-md-4">
                  <label for="state" class="form-label">Filter by State:</label>
                  <select name="state" id="state" class="form-select">
                    <option value="">All States</option>
                    <?php foreach ($available_states as $state): ?>
                      <option value="<?php echo htmlspecialchars($state); ?>" 
                              <?php echo ($selected_state === $state) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($state); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="format" class="form-label">Delivery Format:</label>
                  <select name="format" id="format" class="form-select">
                    <option value="">All Formats</option>
                    <option value="physical" <?php echo ($selected_delivery_format === 'physical') ? 'selected' : ''; ?>>Physical</option>
                    <option value="online" <?php echo ($selected_delivery_format === 'online') ? 'selected' : ''; ?>>Online</option>
                    <option value="hybrid" <?php echo ($selected_delivery_format === 'hybrid') ? 'selected' : ''; ?>>Hybrid</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="filter" class="form-label">Sort by:</label>
                  <select name="filter" id="filter" class="form-select">
                    <option value="">Default</option>
                    <option value="low to high" <?php echo ($filter === 'low to high') ? 'selected' : ''; ?>>Price (low to high)</option>
                    <option value="high to low" <?php echo ($filter === 'high to low') ? 'selected' : ''; ?>>Price (high to low)</option>
                    <option value="newest" <?php echo ($filter === 'newest') ? 'selected' : ''; ?>>Newest</option>
                    <option value="oldest" <?php echo ($filter === 'oldest') ? 'selected' : ''; ?>>Oldest</option>
                    <option value="a-z" <?php echo ($filter === 'a-z') ? 'selected' : ''; ?>>Title A-Z</option>
                    <option value="z-a" <?php echo ($filter === 'z-a') ? 'selected' : ''; ?>>Title Z-A</option>
                  </select>
                </div>
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-primary">Apply Filters</button>
                  <a href="events-by-state.php" class="btn btn-outline-secondary ms-2">Clear All</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Search Results Header Section -->
    <section id="search-results-header" class="search-results-header section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="search-results-header">
          <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
              <div class="results-count" data-aos="fade-right" data-aos-delay="200">
                
               <div class="active-filters">
                    
                      <div class="filter-tags"><?php 
                        $filter_text = "Found $report_count event(s)";
                        if (!empty($selected_state)) {
                          $filter_text .= " in " . htmlspecialchars($selected_state);
                        }
                        if (!empty($selected_delivery_format)) {
                          $filter_text .= " (" . ucfirst($selected_delivery_format) . " format)";
                        }
                        ?>
                        <button class="clear-all-btn"><?php echo $filter_text; ?></button>
                      </div>
                    </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section><!-- /Search Results Header Section -->


    <section id="best-sellers" class="best-sellers section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4">
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
                    echo '<div class="col-12 text-center"><p class="alert alert-info">No events found for the selected criteria.</p></div>';
                }
                ?>
         

        </div>

      </div>

    </section><!-- /Search Product List Section -->
 <!-- Category Pagination Section -->
    <section id="category-pagination" class="category-pagination section">

      <div class="container">
        <nav class="d-flex justify-content-center" aria-label="Page navigation">
          <ul>
                <?php 
                // Build query string for pagination
                $query_params = [];
                if (!empty($selected_state)) $query_params['state'] = $selected_state;
                if (!empty($selected_delivery_format)) $query_params['format'] = $selected_delivery_format;
                if (!empty($filter)) $query_params['filter'] = $filter;
                
                $base_query = !empty($query_params) ? '&' . http_build_query($query_params) : '';
                ?>
                
                <?php if ($page > 1): ?>
                   <li>
              <a href="?page=<?php echo $page - 1; ?><?php echo $base_query; ?>" aria-label="Previous page">
                <i class="bi bi-arrow-left"></i>
                <span class="d-none d-sm-inline">Previous</span>
              </a>
            </li>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
         <li> <a href="?page=<?php echo $i; ?><?php echo $base_query; ?>" class="btn btn-secondary <?php if ($i == $page) echo 'active'; ?>"><?php echo $i; ?></a>  </li>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
         <li>
              <a href="?page=<?php echo $page + 1; ?><?php echo $base_query; ?>" aria-label="Next page">
                <span class="d-none d-sm-inline">Next</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </li>
        
    <?php endif; ?>

          
          </ul>
        </nav>
      </div>

    </section><!-- /Category Pagination Section -->
</main>














<?php include "footer.php"; ?>