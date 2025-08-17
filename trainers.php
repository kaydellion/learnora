<?php include "header.php"; 

// Get filter parameters
$alphabetical_filter = isset($_GET['letter']) ? mysqli_real_escape_string($con, $_GET['letter']) : '';
$sort_by = isset($_GET['sort']) ? mysqli_real_escape_string($con, $_GET['sort']) : 'company_name';
$sort_order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';

// Build WHERE clause for alphabetical filtering
$where_conditions = ["u.trainer = '1'", "u.status = 'active'"];
if (!empty($alphabetical_filter)) {
    $where_conditions[] = "u.company_name LIKE '$alphabetical_filter%'";
}
$where_clause = implode(' AND ', $where_conditions);

// Validate sort column
$allowed_sorts = ['company_name', 'region', 'industry_sector'];
if (!in_array($sort_by, $allowed_sorts)) {
    $sort_by = 'company_name';
}

?>

<section class="trainers-section py-5">
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4 mb-3">Our Trainers</h1>
            <p class="lead text-muted">Explore our network of professional trainers and training organizations</p>
        </div>
    </div>

    <!-- Alphabetical Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Filter by First Letter</h5>
                    <div class="alphabet-filter d-flex flex-wrap gap-2">
                        <a href="trainers.php" class="btn btn-outline-primary btn-sm <?php echo empty($alphabetical_filter) ? 'active' : ''; ?>">All</a>
                        <?php for ($i = 65; $i <= 90; $i++): 
                            $letter = chr($i);
                            $is_active = ($alphabetical_filter === $letter);
                        ?>
                            <a href="?letter=<?php echo $letter; ?>&sort=<?php echo $sort_by; ?>&order=<?php echo strtolower($sort_order); ?>" 
                               class="btn btn-outline-primary btn-sm <?php echo $is_active ? 'active' : ''; ?>">
                                <?php echo $letter; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trainers Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">
                                        <a href="?letter=<?php echo $alphabetical_filter; ?>&sort=company_name&order=<?php echo ($sort_by === 'company_name' && $sort_order === 'ASC') ? 'desc' : 'asc'; ?>" 
                                           class="text-decoration-none text-dark">
                                            Company Name
                                            <?php if ($sort_by === 'company_name'): ?>
                                                <i class="bi bi-arrow-<?php echo $sort_order === 'ASC' ? 'up' : 'down'; ?>"></i>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a href="?letter=<?php echo $alphabetical_filter; ?>&sort=region&order=<?php echo ($sort_by === 'region' && $sort_order === 'ASC') ? 'desc' : 'asc'; ?>" 
                                           class="text-decoration-none text-dark">
                                            Region
                                            <?php if ($sort_by === 'region'): ?>
                                                <i class="bi bi-arrow-<?php echo $sort_order === 'ASC' ? 'up' : 'down'; ?>"></i>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a href="?letter=<?php echo $alphabetical_filter; ?>&sort=industry_sector&order=<?php echo ($sort_by === 'industry_sector' && $sort_order === 'ASC') ? 'desc' : 'asc'; ?>" 
                                           class="text-decoration-none text-dark">
                                            Industry Sector
                                            <?php if ($sort_by === 'industry_sector'): ?>
                                                <i class="bi bi-arrow-<?php echo $sort_order === 'ASC' ? 'up' : 'down'; ?>"></i>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th scope="col">Courses</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

<?php
$sellers_query = "SELECT 
                    u.s AS seller_id,
                    u.display_name AS seller_name,
                    u.profile_photo AS seller_photo,
                    u.biography AS seller_about,
                    u.company_name,
                    u.company_profile,
                    u.region,
                    u.industry_sector,
                    u.facebook AS seller_facebook,
                    u.twitter AS seller_twitter,
                    u.instagram AS seller_instagram,
                    u.linkedin AS seller_linkedin
                  FROM {$siteprefix}users u
                  WHERE $where_clause
                  ORDER BY u.$sort_by $sort_order";
$sellers_result = mysqli_query($con, $sellers_query);
?>

<?php if (mysqli_num_rows($sellers_result) > 0): ?>
 <?php while ($seller = mysqli_fetch_assoc($sellers_result)): 
      $seller_id = $seller['seller_id'];
      $seller_name = htmlspecialchars($seller['seller_name']);
      $company_name = htmlspecialchars($seller['company_name'] ?: 'N/A');
      $region = htmlspecialchars($seller['region'] ?: 'Not Specified');
      $industry_sector = htmlspecialchars($seller['industry_sector'] ?: 'General');
      $seller_photo = !empty($seller['seller_photo']) ? $imagePath . $seller['seller_photo'] : 'default-avatar.png';

      // Get seller resource count
      $count_query = mysqli_query($con, "SELECT COUNT(*) AS total FROM {$siteprefix}training WHERE user = '$seller_id' AND status = 'approved'");
      $count_data = mysqli_fetch_assoc($count_query);
      $resource_count = $count_data['total'];
    ?>

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo $seller_photo; ?>" 
                                                 class="rounded-circle me-3" 
                                                 alt="<?php echo $seller_name; ?>" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-0"><?php echo $company_name; ?></h6>
                                                <small class="text-muted"><?php echo $seller_name; ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark"><?php echo $region; ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary"><?php echo $industry_sector; ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success"><?php echo $resource_count; ?> courses</span>
                                    </td>
                                    <td>
                                        <a href="<?php echo $siteurl; ?>trainer-store?seller_id=<?php echo $seller_id; ?>" 
                                           class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye"></i> View Profile
                                        </a>
                                    </td>
                                </tr>

    <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info text-center">
                <h4>No Trainers Found</h4>
                <p>No active trainers found<?php if (!empty($alphabetical_filter)): ?> starting with "<?php echo $alphabetical_filter; ?>"<?php endif; ?>.</p>
                <?php if (!empty($alphabetical_filter)): ?>
                    <a href="trainers.php" class="btn btn-primary">View All Trainers</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

</div>
</section>

<style>
.alphabet-filter .btn {
    min-width: 40px;
}

.alphabet-filter .btn.active {
    background-color: #f36127;
    border-color: #f36127;
    color: white;
}

.table th a {
    font-weight: 600;
}

.table th a:hover {
    color: #f36127 !important;
}

.trainers-section {
    background-color: #f8f9fa;
}

.card {
    border-radius: 10px;
}

.table-responsive {
    border-radius: 8px;
}

@media (max-width: 768px) {
    .alphabet-filter {
        justify-content: center;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
}
</style>

<?php include "footer.php"; ?>