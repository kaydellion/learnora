<?php include "header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">

  <!-- Hoverable Table rows -->
  <div class="card">
    <h5 class="card-header">Manage In-House Proposal</h5>
    <div class="table-responsive text-nowrap">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Trainer Name</th>
            <th>Event</th>
             <th>Name</th>
             <th>Position</th>
             <th>Company</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          <?php
    $query = "
    SELECT tin.*, u.first_name, u.last_name, u.email_address, t.user
    FROM {$siteprefix}inhouse_proposals tin
    INNER JOIN {$siteprefix}training t ON tin.training_id = t.training_id
    INNER JOIN {$siteprefix}users u ON t.user = u.s";

    
          $result = mysqli_query($con, $query);
          if (!$result) {
              die('Query Failed: ' . mysqli_error($con));
          }
          $i = 1;
          while ($row = mysqli_fetch_assoc($result)) {
  // Assign each field to individual variables
    $s = $row['s'];
    $training_id = $row['training_id'];
    $seminar_title = $row['seminar_title'];
    $days = $row['days'];
    $participants = $row['participants'];
    $name = $row['name'];
    $position = $row['position'];
    $company = $row['company'];
    $address = $row['address'];
    $city = $row['city'];
    $country = $row['country'];
    $email = $row['email'];
    $phone = $row['phone'];
    $mobile = $row['mobile'];
    $comment = $row['comment'];
    $created_at = $row['created_at'];

    // Trainer's user details
    $trainer_user_id = $row['user'];
    $trainer_first_name = $row['first_name'];
    $trainer_last_name = $row['last_name'];
          ?>
            <tr>
              <td><strong><?php echo $i; ?></strong></td>
              <td><?php echo $trainer_first_name . ' ' . $trainer_last_name; ?></td>
              <td><?php echo $seminar_title; ?></td>
                <td><?php echo $name; ?></td>
                  <td><?php echo $position; ?></td>
                  <td><?php echo $company; ?></td>

              <td>
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#viewReportModal<?php echo $s; ?>">
                  View
                </button>
                <?php  if($user_type !== 'admin'){ ?>
               <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#sendMailModal<?php echo $s; ?>">
  Send Mail
</button>
<?php } ?>

              </td>
            </tr>
            
          <!-- Send Mail Modal -->
<div class="modal fade" id="sendMailModal<?php echo $s; ?>" tabindex="-1" role="dialog" aria-labelledby="sendMailModalLabel<?php echo $s; ?>" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="sendMailModalLabel<?php echo $s; ?>">Send Email to Trainer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <input type="text" name="trainer_email" readonly value="<?php echo htmlspecialchars($row['email_address']); ?>">
          <input type="text" name="trainer_name" readonly value="<?php echo htmlspecialchars($trainer_first_name . ' ' . $trainer_last_name); ?>">

          <div class="form-group">
            <label>Subject</label>
            <input type="text" name="subject" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Message</label>
            <textarea name="message" class="form-control editor"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="inform_trainer">Send Email</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>

    </div>
  </div>
</div>

          <!-- Modal -->
<div class="modal fade" id="viewReportModal<?php echo $s; ?>" tabindex="-1" role="dialog" aria-labelledby="viewReportModalLabel<?php echo $s; ?>" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title" id="viewReportModalLabel<?php echo $s; ?>"><?php echo htmlspecialchars($name); ?> - In-house Proposal Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <p><strong>Seminar Title:</strong> <?php echo $seminar_title; ?></p>
        <p><strong>Training ID:</strong> <?php echo $training_id; ?></p>
        <p><strong>Days:</strong> <?php echo $days; ?></p>
        <p><strong>Participants:</strong> <?php echo $participants; ?></p>
        <p><strong>Name:</strong> <?php echo $name; ?></p>
        <p><strong>Position:</strong> <?php echo $position; ?></p>
        <p><strong>Company:</strong> <?php echo $company; ?></p>
        <p><strong>Address:</strong> <?php echo $address; ?></p>
        <p><strong>City:</strong> <?php echo $city; ?></p>
        <p><strong>Country:</strong> <?php echo $country; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Phone:</strong> <?php echo $phone; ?></p>
        <p><strong>Mobile:</strong> <?php echo $mobile; ?></p>
        <p><strong>Comment:</strong> <?php echo $comment; ?></p>
        <p><strong>Created At:</strong> <?php echo $created_at; ?></p>

        <hr>
        <h5>Trainer Info</h5>
        <p><strong>Trainer Name:</strong> <?php echo htmlspecialchars($trainer_first_name . ' ' . $trainer_last_name); ?></p>
        <p><strong>Trainer User ID:</strong> <?php echo htmlspecialchars($trainer_user_id); ?></p>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    
    </div>
  </div>
</div>

          <?php 
          
            $i++; 
          } ?>
        </tbody>

      </table>
      
<!-- Modal -->
<div class="modal fade" id="viewReportModal<?php echo $row['s']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewReportModalLabel<?php echo $row['s']; ?>" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title" id="viewReportModalLabel<?php echo $row['s']; ?>">In-house Proposal Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <p><strong>Seminar Title:</strong> <?php echo htmlspecialchars($seminar_title); ?></p>
        <p><strong>Training ID:</strong> <?php echo htmlspecialchars($training_id); ?></p>
        <p><strong>Days:</strong> <?php echo htmlspecialchars($days); ?></p>
        <p><strong>Participants:</strong> <?php echo htmlspecialchars($participants); ?></p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Position:</strong> <?php echo htmlspecialchars($position); ?></p>
        <p><strong>Company:</strong> <?php echo htmlspecialchars($company); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
        <p><strong>City:</strong> <?php echo htmlspecialchars($city); ?></p>
        <p><strong>Country:</strong> <?php echo htmlspecialchars($country); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
        <p><strong>Mobile:</strong> <?php echo htmlspecialchars($mobile); ?></p>
        <p><strong>Comment:</strong> <?php echo nl2br(htmlspecialchars($comment)); ?></p>
        <p><strong>Created At:</strong> <?php echo htmlspecialchars($created_at); ?></p>

        <hr>
        <h5>Trainer Info</h5>
        <p><strong>Trainer Name:</strong> <?php echo htmlspecialchars($trainer_first_name . ' ' . $trainer_last_name); ?></p>
        <p><strong>Trainer User ID:</strong> <?php echo htmlspecialchars($trainer_user); ?></p>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    
    </div>
  </div>
</div>
    </div>
  </div>

</div>

<?php include "footer.php"; ?>
