<?php include "header.php"; ?>
<section>
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
                  WHERE u.trainer = '1' AND u.status = 'active'";
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
<?php include "footer.php";  ?>