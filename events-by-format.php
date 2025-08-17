

<?php include "header.php"; 

// Get selected format from URL parameter
$selected_delivery_format = isset($_GET['format']) ? mysqli_real_escape_string($con, $_GET['format']) : '';
$selected_category = isset($_GET['category']) ? mysqli_real_escape_string($con, $_GET['category']) : '';

// Get all unique delivery formats for the filter
$formats_query = "SELECT DISTINCT delivery_format FROM {$siteprefix}training 
                 WHERE delivery_format IS NOT NULL AND delivery_format != '' 
                 AND status = 'approved'
                 ORDER BY delivery_format ASC";
$formats_result = mysqli_query($con, $formats_query);
$available_formats = [];
while ($format_row = mysqli_fetch_assoc($formats_result)) {
    $available_formats[] = $format_row['delivery_format'];
}

// Get all categories for additional filtering
$categories_query = "SELECT DISTINCT id, category_name FROM {$siteprefix}categories 
                     WHERE category_name IS NOT NULL AND category_name != ''
                     ORDER BY category_name ASC";
$categories_result = mysqli_query($con, $categories_query);
$available_categories = [];
while ($category_row = mysqli_fetch_assoc($categories_result)) {
    $available_categories[] = $category_row;
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

// Build WHERE conditions for format and category filtering
$where_conditions = ["t.status = 'approved'"];

if (!empty($selected_delivery_format)) {
    $where_conditions[] = "t.delivery_format = '$selected_delivery_format'";
}

if (!empty($selected_category)) {
    $where_conditions[] = "(t.category = '$selected_category' OR FIND_IN_SET('$selected_category', t.category))";
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

<style>
.format-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.format-card:hover {
  transform: translateY(-5px);
}

.format-card.active .card {
  border: 2px solid #007bff !important;
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.format-card a {
  color: inherit;
}

.format-card:hover .card {
  box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.format-icon i {
  transition: color 0.3s ease;
}

.format-card:hover .format-icon i {
  transform: scale(1.1);
}
</style>

    <!-- Page Title Section -->
    <section id="page-title" class="page-title section">
      <div class="container" data-aos="fade-up">
        <div class="text-center">
          <h1>Events by Format</h1>
          <p class="lead">Find training events based on delivery method: Physical (In-person), Online (Webinar/Virtual), or Hybrid (Physical & Online)</p>
        </div>
      </div>
    </section>

    <!-- Format Filter Section -->
    <section id="format-filter" class="format-filter section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        
        <!-- Format Cards -->
        <div class="row mb-4">
          <div class="col-lg-4 mb-3">
            <div class="format-card h-100 <?php echo ($selected_delivery_format === 'physical') ? 'active' : ''; ?>">
              <a href="?format=physical" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body text-center p-4">
                    <div class="format-icon mb-3">
                      <i class="bi bi-building fs-1 text-primary"></i>
                    </div>
                    <h5 class="card-title">Physical (In-person)</h5>
                    <p class="card-text text-muted">Face-to-face training sessions at physical locations</p>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-4 mb-3">
            <div class="format-card h-100 <?php echo ($selected_delivery_format === 'online') ? 'active' : ''; ?>">
              <a href="?format=online" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body text-center p-4">
                    <div class="format-icon mb-3">
                      <i class="bi bi-laptop fs-1 text-success"></i>
                    </div>
                    <h5 class="card-title">Online (Webinar/Virtual)</h5>
                    <p class="card-text text-muted">Virtual training sessions accessible from anywhere</p>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-4 mb-3">
            <div class="format-card h-100 <?php echo ($selected_delivery_format === 'hybrid') ? 'active' : ''; ?>">
              <a href="?format=hybrid" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body text-center p-4">
                    <div class="format-icon mb-3">
                      <i class="bi bi-union fs-1 text-warning"></i>
                    </div>
                    <h5 class="card-title">Hybrid (Physical & Online)</h5>
                    <p class="card-text text-muted">Combined in-person and virtual training experience</p>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="filter-card bg-light p-4 rounded">
              <form method="GET" action="events-by-format.php" class="row g-3">
                <div class="col-md-6">
                  <label for="format" class="form-label">Delivery Format:</label>
                  <select name="format" id="format" class="form-select">
                    <option value="">All Formats</option>
                    <?php foreach ($available_formats as $format): ?>
                      <option value="<?php echo htmlspecialchars($format); ?>" 
                              <?php echo ($selected_delivery_format === $format) ? 'selected' : ''; ?>>
                        <?php echo ucfirst(htmlspecialchars($format)); ?>
                        <?php if ($format === 'physical'): ?> (In-person)<?php endif; ?>
                        <?php if ($format === 'online'): ?> (Webinar/Virtual)<?php endif; ?>
                        <?php if ($format === 'hybrid'): ?> (Physical & Online)<?php endif; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="category" class="form-label">Category (Optional):</label>
                  <select name="category" id="category" class="form-select">
                    <option value="">All Categories</option>
                    <?php foreach ($available_categories as $category): ?>
                      <option value="<?php echo htmlspecialchars($category['id']); ?>" 
                              <?php echo ($selected_category === $category['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['category_name']); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-12">
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
                  <a href="events-by-format.php" class="btn btn-outline-secondary ms-2">Clear All</a>
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
                        if (!empty($selected_delivery_format)) {
                          $format_display = ucfirst($selected_delivery_format);
                          if ($selected_delivery_format === 'physical') $format_display .= " (In-person)";
                          if ($selected_delivery_format === 'online') $format_display .= " (Webinar/Virtual)";
                          if ($selected_delivery_format === 'hybrid') $format_display .= " (Physical & Online)";
                          $filter_text .= " - " . $format_display;
                        }
                        if (!empty($selected_category)) {
                          $category_name = '';
                          foreach ($available_categories as $cat) {
                            if ($cat['id'] == $selected_category) {
                              $category_name = $cat['category_name'];
                              break;
                            }
                          }
                          $filter_text .= " in " . htmlspecialchars($category_name);
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
                if (!empty($selected_delivery_format)) $query_params['format'] = $selected_delivery_format;
                if (!empty($selected_category)) $query_params['category'] = $selected_category;
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