<?php include "header.php"; 

 checkActiveLog($active_log);
 if ($trainer != 1) {
  header("Location: index.php");
  exit;
}
 ?>

<style>
table img {
    width: 50px;
    height: 50px;
    object-fit: cover;
}
table img.img-small {
    width: 30px;
    height: 30px;
}
table td {
    vertical-align: middle;
}
table th {
    vertical-align: middle;
}
</style>
<div class="container-xxl mt-5 mb-5">
<p><a href="add-training.php" class="btn btn-primary">Add Training</a> </p>
              <!-- Hoverable Table rows -->
                <h5 class="card-header"> Manage Resources </h5>
                <div class="table-responsive text-nowrap">
                  <table class="table table-hover">
                  <thead>
                  <tr>
                  <th>S/N</th>
             
                  <th> Title</th>
                  <th>Category</th>
                  <th>Subcategory</th>
                  <th>Pricing</th>
                  <th>Price</th>
                  <th>Tags</th>
                  <th>Created Date</th>
                  <th>Status</th>
                  <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                <?php 
                     $query = "SELECT t.*, u.name as display_name,lu.display_name AS nameupload, tt.price, u.photo as profile_picture, l.category_name AS category, sc.category_name AS subcategory
    FROM ".$siteprefix."training t
    LEFT JOIN ".$siteprefix."categories l ON t.category = l.id 
    LEFT JOIN ".$siteprefix."instructors u ON t.instructors = u.s
    LEFT JOIN ".$siteprefix."users lu ON t.user = lu.s
    LEFT JOIN ".$siteprefix."categories sc ON t.subcategory = sc.id 
    LEFT JOIN ".$siteprefix."training_tickets tt ON t.training_id= tt.training_id
WHERE t.user = '$user_id' GROUP BY t.training_id";
                $result = mysqli_query($con, $query);
                if (!$result) {
                    die('Query Failed: ' . mysqli_error($con));
                }
                $result = mysqli_query($con, $query);
                if(mysqli_num_rows($result) == 0) {
                  echo '<tr><td colspan="14" class="text-center">No reports found. <a href="add-training.php">Add New</a></td></tr>';
                } else{
                $i = 1;
                while($row = mysqli_fetch_assoc($result)) {
                $training_id = $row['training_id'];
        $title = $row['title'];
        $report_row = $row['s'];
        $alt_title = $row['alt_title'];
        $description = $row['description'];
        $category = $row['category'];
        $subcategory = $row['subcategory'];
        $pricing = $row['pricing'];
        $price = $row['price'];
        $tags = $row['tags'];
        $uploaded_by = $row['nameupload'];
        $user = $row['display_name'];
        $user_picture = $imagePath.$row['profile_picture'];
        $created_date = $row['created_at'];
        $status = $row['status'];
                ?>
                  <tr>
                  <td><strong><?php echo $i; ?></strong></td>
                  <td><?php echo $category; ?></td>
                  <td><?php echo $subcategory; ?></td>
                  <td><?php echo $pricing; ?></td>
                  <td><?php echo $tags; ?></td>
                  <td><?php echo $created_date; ?></td>

                  <td><span class="badge bg-<?php echo getBadgeColor($status); ?> me-1"><?php echo $status; ?></span></td>
                  <td>
                   <a href="edit-training.php?training=<?php echo $training_id; ?>" class="btn btn-sm btn-warning me-1"><i class="bx bx-edit-alt me-1"></i> Edit Report</a>
                  <a  href="delete.php?action=delete&table=training&item=<?php echo $training_id; ?>&page=<?php echo $current_page; ?>" class="btn btn-sm btn-danger delete"><i class="bx bx-trash me-1"></i> Delete </a></td>
                  </tr>
                  <?php $i++; }} ?>
                  </tbody>
                  </table>
                </div>
                </div>
              <!--/ Hoverable Table rows -->

            </div>




<?php include "footer.php"; ?>
