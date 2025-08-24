

<?php include "header.php"; 

// Get selected month from URL parameter
$selected_month = isset($_GET['month']) ? mysqli_real_escape_string($con, $_GET['month']) : '';
$selected_year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// Get current year and next year for dropdown
$current_year = date('Y');
$available_years = [$current_year, $current_year + 1];

// Month names array
$months = [
    '01' => 'January',
    '02' => 'February', 
    '03' => 'March',
    '04' => 'April',
    '05' => 'May',
    '06' => 'June',
    '07' => 'July',
    '08' => 'August',
    '09' => 'September',
    '10' => 'October',
    '11' => 'November',
    '12' => 'December'
];

// Get months that have events
$months_query = "SELECT DISTINCT MONTH(d.event_date) as month_num, YEAR(d.event_date) as year_num
                 FROM {$siteprefix}training_event_dates d
                 JOIN {$siteprefix}training t ON d.training_id = t.training_id
                 WHERE t.status = 'approved' 
                   AND d.event_date >= CURDATE()
                 ORDER BY year_num, month_num";
$months_result = mysqli_query($con, $months_query);
$available_months = [];
while ($month_row = mysqli_fetch_assoc($months_result)) {
    $month_key = sprintf('%02d', $month_row['month_num']);
    $year = $month_row['year_num'];
    if (!isset($available_months[$year])) {
        $available_months[$year] = [];
    }
    $available_months[$year][] = $month_key;
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

// Build WHERE conditions for month and year filtering
$where_conditions = ["t.status = 'approved'"];

if (!empty($selected_month) && !empty($selected_year)) {
    $where_conditions[] = "EXISTS (
        SELECT 1 FROM {$siteprefix}training_event_dates d2
        WHERE d2.training_id = t.training_id 
        AND MONTH(d2.event_date) = '$selected_month' 
        AND YEAR(d2.event_date) = '$selected_year'
        AND d2.event_date >= CURDATE()
    )";
} elseif (!empty($selected_year)) {
    $where_conditions[] = "EXISTS (
        SELECT 1 FROM {$siteprefix}training_event_dates d2
        WHERE d2.training_id = t.training_id 
        AND YEAR(d2.event_date) = '$selected_year'
        AND d2.event_date >= CURDATE()
    )";
}

$where_clause = implode(' AND ', $where_conditions);

$query = "SELECT t.*, 
                u.name AS display_name, 
                tt.price, 
                u.photo AS profile_picture, 
                l.category_name AS category, 
                sc.category_name AS subcategory, 
                ti.picture,
                MIN(d.event_date) as next_event_date
          FROM {$siteprefix}training t
          LEFT JOIN {$siteprefix}categories l ON t.category = l.id 
          LEFT JOIN {$siteprefix}instructors u ON t.instructors = u.s
          LEFT JOIN {$siteprefix}categories sc ON t.subcategory = sc.id 
          LEFT JOIN {$siteprefix}training_tickets tt ON t.training_id = tt.training_id
          LEFT JOIN {$siteprefix}training_images ti ON t.training_id = ti.training_id 
          LEFT JOIN {$siteprefix}training_event_dates d ON t.training_id = d.training_id AND d.event_date >= CURDATE()
          WHERE $where_clause
            AND EXISTS (
                SELECT 1 
                FROM {$siteprefix}training_event_dates d3
                WHERE d3.training_id = t.training_id
                  AND (
                      d3.event_date > CURDATE() 
                      OR (d3.event_date = CURDATE() AND d3.end_time >= CURTIME())
                  )
            )
          GROUP BY t.training_id 
          ORDER BY next_event_date ASC, $order_by 
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
.month-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.month-card:hover {
  transform: translateY(-3px);
}

.month-card.active .card {
  border: 2px solid #007bff !important;
  background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
  color: white !important;
}

.month-card.active .card .text-muted {
  color: rgba(255,255,255,0.8) !important;
}

.month-card.past .card {
  background-color: #f8f9fa;
  opacity: 0.6;
}

.month-card a {
  color: inherit;
}

.month-card:hover .card {
  box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.month-card .card {
  min-height: 80px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.month-card h6 {
  font-size: 0.9rem;
  margin-bottom: 0.25rem;
}

.month-card small {
  font-size: 0.75rem;
}
</style>

    <!-- Page Title Section -->
    <section id="page-title" class="page-title sections">
      <div class="container" data-aos="fade-up">
        <div class="text-center">
          <h1>Events by Month</h1>
          <p class="lead">Find training events and courses scheduled for specific months throughout the year</p>
        </div>
      </div>
    </section>

    <!-- Month Filter Section -->
    <section id="month-filter" class="month-filter sections">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        
        <!-- Month Cards for Current Year -->
        <div class="row mb-4">
          <div class="col-12">
            <h4 class="text-center mb-4"><?php echo $current_year; ?></h4>
          </div>
          <?php 
          $current_month = date('m');
          foreach ($months as $month_num => $month_name): 
            $has_events = isset($available_months[$current_year]) && in_array($month_num, $available_months[$current_year]);
            $is_selected = ($selected_month === $month_num && $selected_year == $current_year);
            $is_past = ($month_num < $current_month && $current_year == date('Y'));
          ?>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
              <div class="month-card h-100 <?php echo $is_selected ? 'active' : ''; ?> <?php echo $is_past ? 'past' : ''; ?>">
                <?php if ($has_events && !$is_past): ?>
                  <a href="?month=<?php echo $month_num; ?>&year=<?php echo $current_year; ?>" class="text-decoration-none">
                <?php endif; ?>
                  <div class="card border-0 shadow-sm h-100 <?php echo !$has_events || $is_past ? 'text-muted' : ''; ?>">
                    <div class="card-body text-center p-3">
                      <h6 class="card-title mb-1"><?php echo $month_name; ?></h6>
                      <small class="text-muted">
                        <?php if ($is_past): ?>
                          Past
                        <?php elseif ($has_events): ?>
                          Events Available
                        <?php else: ?>
                          No Events
                        <?php endif; ?>
                      </small>
                    </div>
                  </div>
                <?php if ($has_events && !$is_past): ?>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="filter-card bg-light p-4 rounded">
              <form method="GET" action="events-by-month.php" class="row g-3">
                <div class="col-md-4">
                  <label for="year" class="form-label">Year:</label>
                  <select name="year" id="year" class="form-select">
                    <option value="">All Years</option>
                    <?php foreach ($available_years as $year): ?>
                      <option value="<?php echo $year; ?>" 
                              <?php echo ($selected_year == $year) ? 'selected' : ''; ?>>
                        <?php echo $year; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="month" class="form-label">Month:</label>
                  <select name="month" id="month" class="form-select">
                    <option value="">All Months</option>
                    <?php foreach ($months as $month_num => $month_name): ?>
                      <option value="<?php echo $month_num; ?>" 
                              <?php echo ($selected_month === $month_num) ? 'selected' : ''; ?>>
                        <?php echo $month_name; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="filter" class="form-label">Sort by:</label>
                  <select name="filter" id="filter" class="form-select">
                    <option value="">Event Date</option>
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
                  <a href="events-by-month.php" class="btn btn-outline-secondary ms-2">Clear All</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Search Results Header Section -->
    <section id="search-results-header" class="search-results-header sections">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="search-results-header">
          <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
              <div class="results-count" data-aos="fade-right" data-aos-delay="200">
                
               <div class="active-filters">
                    
                      <div class="filter-tags"><?php 
                        $filter_text = "Found $report_count event(s)";
                        if (!empty($selected_month) && !empty($selected_year)) {
                          $month_name = $months[$selected_month];
                          $filter_text .= " in " . $month_name . " " . $selected_year;
                        } elseif (!empty($selected_year)) {
                          $filter_text .= " in " . $selected_year;
                        } elseif (!empty($selected_month)) {
                          $month_name = $months[$selected_month];
                          $filter_text .= " in " . $month_name;
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


    <section id="best-sellers" class="best-sellers sections">

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
    <section id="category-pagination" class="category-pagination sections">

      <div class="container">
        <nav class="d-flex justify-content-center" aria-label="Page navigation">
          <ul>
                <?php 
                // Build query string for pagination
                $query_params = [];
                if (!empty($selected_month)) $query_params['month'] = $selected_month;
                if (!empty($selected_year)) $query_params['year'] = $selected_year;
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