
<?php
include "header.php";

if (isset($_GET['training'])) {
    $training_id = $_GET['training'];
}

$event_dates = [];
$training_data_set = false;
$videoCounter = 1;


// Fetch training and event data
$query = "SELECT t.*, u.name AS display_name, tv.video_path, et.name AS event_types, tt.price, tt.ticket_name, tt.benefits, tt.seats,
                 u.photo AS profile_picture, l.category_name AS category, 
                 sc.category_name AS subcategory, ti.picture AS event_image, ti.s AS image_id,
                 tem.event_date, tem.start_time, tem.end_time, tem.s,tvl.file_path, tvl.video_url,tvl.s as video_id
          FROM {$siteprefix}training t 
          LEFT JOIN {$siteprefix}categories l ON t.category = l.id 
          LEFT JOIN {$siteprefix}instructors u ON t.instructors = u.s
          LEFT JOIN {$siteprefix}training_video_lessons tvl ON t.training_id = tvl.training_id
          LEFT JOIN {$siteprefix}categories sc ON t.subcategory = sc.id 
          LEFT JOIN {$siteprefix}training_tickets tt ON t.training_id = tt.training_id
          LEFT JOIN {$siteprefix}training_images ti ON t.training_id = ti.training_id 
          LEFT JOIN {$siteprefix}training_videos tv ON t.training_id = tv.training_id AND tv.video_type = 'promo'
          LEFT JOIN {$siteprefix}event_types et ON t.event_type = et.s
          LEFT JOIN {$siteprefix}training_event_dates tem ON t.training_id = tem.training_id
          WHERE t.training_id = '$training_id'";

$result = mysqli_query($con, $query);
if (!$result) {
    die('Query Failed: ' . mysqli_error($con));
}

while ($row = mysqli_fetch_assoc($result)) {
    // Set training info once
    if (!$training_data_set) {
        $training_id = $row['training_id'];
        $video_file_path = $row['file_path'];
        $video_url = $row['video_url'];
        $title = $row['title'];
        $selected_instructor_id = $row['instructors'];
        $alt_title = $row['alt_title'];
        $description = $row['description'];
        $learning_objectives = $row['learning_objectives'];
        $category_id = $row['category'];
    $subcategory_id = $row['subcategory'];
    $selected_categories = explode(',', $category_id); // result: [1, 3]
    $selected_subcategories = explode(',', $subcategory_id); // result: [5, 6]
        $image_id = $row['image_id'];
       
        $loyalty = $row['loyalty'];
        $pricing = $row['pricing'];
        $attendee = $row['attendee'];
        $price = $row['price'];
        $tags = $row['tags'];
        $level = $row['level'];
        $certification = $row['certification'];
        $language = $row['Language'];
        $instructor_name = $row['display_name'];
        $instructor_picture = $imagePath . $row['profile_picture'];
        $target_audience = $row['target_audience'];
        $created_date = $row['created_at'];
        $status = $row['status'];
        $additional_notes = $row['additional_notes'];
        $course_requirrement = $row['course_requirrement'];
        $course_description = $row['course_description'];
        $image_paths = $imagePath . $row['event_image'];
        $quiz_method = $row['quiz_method'];
        $slug = $alt_title;
        $training_video = $imagePath . $row['video_path'];
        $selected_event_type = $row['event_type'];
        $format = $row['delivery_format'];
        $selected_resource_type = explode(',', $row['use_case'] ?? '');
        $physical_country = $row['physical_country'];
        $foreign_address = $row['foreign_address'];
        $physical_address = $row['physical_address'];
        $physical_state = $row['physical_state'];
        $physical_lga = $row['physical_lga'];
        $web_address = $row['web_address'];
        $hybrid_physical_address = $row['hybrid_physical_address'];
        $hybrid_web_address = $row['hybrid_web_address'];
        $hybrid_country = $row['hybrid_country'];
        $hybrid_foreign_address = $row['hybrid_foreign_address'];
        $hybrid_state = $row['hybrid_state'];
        $hybrid_lga = $row['hybrid_lga'];
        $training_data_set = true;
    }

    // Add event dates
    if (!empty($row['event_date']) && !empty($row['start_time']) && !empty($row['end_time'])) {
        $event_dates[] = [
            'event_date' => $row['event_date'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            's' => $row['s']
        ];
    }


}

if (!$training_data_set) {
    echo 'Event not found.';
    exit;
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="mb-0">Add New Training Listings</h4>
        </div>
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data">

            <h6>Event Details</h6>
            <div class="mb-3">
              <label class="form-label">Title</label>
              <input type="text" class="form-control" name="title" value="<?php echo $title; ?>" >
            </div>
            
                            <input type="hidden" id="training-id" name="training-id" class="form-control" value="<?php echo $training_id; ?>" readonly required>
                <div class="image-preview">
                          <img class="preview-image" src="<?php echo $siteurl . $image_paths ?>" alt="Training Image">
                           <button type="button" class="delete-btn delete-image" data-image-id="<?php echo $image_id; ?>">X</button>
                            </div>
            <div class="mb-3">
              <label class="form-label">Cover Image</label>
              <input type="file" class="form-control" name="cover_images" accept="image/*">
            </div>

               <div class="mb-3">
                        <label class="form-label" for="course-id">Training ID</label>
                        <input type="text" id="course-id" name="id" class="form-control" value="<?php echo $training_id; ?>" readonly required>
                    </div>
                       <h6>Course Content Details</h6>
            <div class="mb-3">
              <label class="form-label">Course Description</label>
              <textarea class="form-control editor" name="course_description" rows="4"><?php echo $course_description; ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea class="form-control editor"  name="description" ><?php echo $description; ?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Learning Objectives / Outcomes</label>
              <textarea class="form-control editor" name="learning_objectives" rows="3" placeholder="List what the learner will be able to do after completing the course."><?php echo $learning_objectives; ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Target Audience</label>
              <input type="hidden" class="form-control" name="target_audience" placeholder='E.g. "Beginners in Python", "Entrepreneurs", etc.' value="<?php echo $target_audience; ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Course Requirements / Prerequisites</label>
              <textarea class="form-control editor" name="prerequisites" rows="2" placeholder="Any knowledge, tools, or skills needed before starting."><?php echo $course_requirrement; ?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Who Should Attend</label>
              <input type="text" class="form-control" name="who_should_attend" placeholder="E.g. Beginners, Entrepreneurs, etc." value="<?php echo $attendee; ?>">
            </div>
          <div class="mb-3">
  <label class="form-label">Event Dates & Times</label>
 <div id="dateTimeRepeater">
  <?php foreach ($event_dates as $ev) { ?>
    <div class="row mb-2 dateTimeRow">
      <input type="hidden" name="event_ids[]" value="<?= $ev['s'] ?>">
      <div class="col">
        <input type="date" class="form-control" name="event_dates[]" value="<?= $ev['event_date'] ?>" required>
      </div>
      <div class="col">
        <input type="time" class="form-control" name="event_start_times[]" value="<?= $ev['start_time'] ?>" required>
      </div>
      <div class="col">
        <input type="time" class="form-control" name="event_end_times[]" value="<?= $ev['end_time'] ?>" required>
      </div>
      <div class="col-auto">
        <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.dateTimeRow').remove()">-</button>
      </div>
    </div>
  <?php } ?>
</div>

<button type="button" class="btn btn-success btn-sm mt-2" onclick="addDateTimeRow()">
  <i class="bx bx-plus me-1"></i> Add
</button>

</div>


     <h6>Area of Specialization</h6>
<div class="mb-3">
   <select class="form-select select-multiple w-100" name="category[]" id="category-select" multiple required>
  <?php
  $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL";
  $sql2 = mysqli_query($con, $sql);
  while ($row = mysqli_fetch_array($sql2)) {
    $selected = in_array($row['id'], $selected_categories) ? 'selected' : '';
    echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['category_name'] . '</option>';
  }
  ?>
</select>
</div>

<div class="mb-3" id="subcategory-container" style="display:block;">
  <select class="form-select select-multiple w-100" name="subcategory[]" id="subcategory-select" multiple required>
    <!-- Subcategories will be filled via JS -->
  </select>
</div>

<div class="mb-3">
              <label class="form-label">Language</label>
              <input type="text" class="form-control" name="language" value="<?php echo $language; ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Certification Offered?</label>
              <select class="form-control" name="certification">
                <option value="yes" <?php echo ($certification == 'yes') ? 'selected' : ''; ?>>Yes</option>
                <option value="no" <?php echo ($certification == 'no') ? 'selected' : ''; ?>>No</option>
              </select>
            </div>
                 <input type="hidden" name="user" value="<?php echo $user_id; ?>">
            <div class="mb-3">
              <label class="form-label">Level</label>
              <select class="form-control" name="level" required>
                <option value="">Select Level</option>
                <option value="beginner" <?php echo ($level == 'beginner') ? 'selected' : ''; ?>>Beginner</option>
                <option value="intermediate" <?php echo ($level == 'intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                <option value="advanced" <?php echo ($level == 'advanced') ? 'selected' : ''; ?>>Advanced</option>
              </select>
            </div>

             <h6>Delivery Format</h6>
<div class="mb-3">
  <select class="form-control" name="delivery_format" id="deliveryFormat" onchange="toggleDeliveryFields()" required>
    <option value="">Select Format</option>
    <option value="physical" <?= $format == 'physical' ? 'selected' : '' ?>>Physical (In-person)</option>
    <option value="online" <?= $format == 'online' ? 'selected' : '' ?>>Online (Webinar/Virtual)</option>
    <option value="hybrid" <?= $format == 'hybrid' ? 'selected' : '' ?>>Hybrid (Physical & Online)</option>
  </select>
</div>

<!-- Physical Address Fields -->
<div class="mb-3" id="physicalFields" style="display:none;">
  <label class="form-label">Nigeria or Foreign</label>
  <select class="form-control" id="physicalLocationType" name="physicalLocationType" onchange="togglePhysicalLocationFields()">
    <option value="">Select</option>
    <option value="nigeria" <?= !empty($physical_state) ? 'selected' : '' ?>>Nigeria</option>
    <option value="foreign" <?= !empty($foreign_address) ? 'selected' : '' ?>>Foreign</option>
  </select>

  <div id="nigeriaPhysicalFields" style="display:none;">
    <label class="form-label mt-2">Nigerian Address</label>
    <select id="state" name="state" class="form-control" required>
      <option value="">-Select State-</option>
      <option value="<?= $physical_state ?>" selected><?= $physical_state ?></option>
    </select>
    <select class="form-control" id="lga" required name="lga">
      <option value="">-Select LGA-</option>
      <option value="<?= $physical_lga ?>" selected><?= $physical_lga ?></option>
    </select>
    <input type="text" class="form-control mb-2" name="nigeria_address" placeholder="Address" value="<?= htmlspecialchars($physical_address) ?>">
    <input type="text" class="form-control mb-2" name="country" value="<?= $physical_country ?>" readonly>
  </div>

  <div id="foreignPhysicalFields" style="display:none;">
    <label class="form-label mt-2">Foreign Address</label>
    <input type="text" class="form-control mb-2" name="foreign_address" value="<?= htmlspecialchars($foreign_address) ?>">
  </div>
</div>

<!-- Online Address Field -->
<div class="mb-3" id="onlineFields" style="display:none;">
  <label class="form-label">Web Address (Zoom, YouTube, etc.)</label>
  <input type="url" class="form-control" name="web_address" value="<?= htmlspecialchars($web_address) ?>">
</div>

<!-- Hybrid Address Fields -->
<div class="mb-3" id="hybridFields" style="display:none;">
  <label class="form-label">Physical Address</label>
  <input type="text" class="form-control mb-2" name="hybrid_physical_address" value="<?= htmlspecialchars($hybrid_physical_address) ?>">
  <label class="form-label">Web Address</label>
  <input type="url" class="form-control mb-2" name="hybrid_web_address" value="<?= htmlspecialchars($hybrid_web_address) ?>">

  <label class="form-label">Nigeria or Foreign</label>
  <select class="form-control" id="hybridLocationType" name="hybridLocationType" onchange="toggleHybridLocationFields()">
    <option value="">Select</option>
    <option value="nigeria" <?= !empty($hybrid_country) ? 'selected' : '' ?>>Nigeria</option>
    <option value="foreign" <?= !empty($hybrid_foreign_address) ? 'selected' : '' ?>>Foreign</option>
  </select>

  <div id="nigeriaHybridFields" style="display:none;">
    <select id="hybrid_state" name="hybrid_state" class="form-control" required>
      <option value="">-Select State-</option>
      <option value="<?= $hybrid_state ?>" selected><?= $hybrid_state ?></option>
    </select>
    <select class="form-control" id="hybrid_lga" required name="hybrid_lga">
      <option value="">-Select LGA-</option>
      <option value="<?= $hybrid_lga ?>" selected><?= $hybrid_lga ?></option>
    </select>
    <input type="text" class="form-control mb-2" name="hybrid_country" value="<?= $hybrid_country ?>" readonly>
  </div>

  <div id="foreignHybridFields" style="display:none;">
    <input type="text" class="form-control mb-2" name="hybrid_foreign_address" placeholder="Foreign Address" value="<?= htmlspecialchars($hybrid_foreign_address) ?>">
  </div>
</div>

      <?php
$lessonQuery = mysqli_query($con, "SELECT * FROM {$siteprefix}training_video_lessons WHERE training_id = '$training_id'");
$embedValue = ''; // to store the embed url for pre-filling
?>

<div class="mt-3">
  <strong>Uploaded Lessons:</strong>
  <ul class="list-group">
    <?php while ($lesson = mysqli_fetch_assoc($lessonQuery)):
      $lessonId = $lesson['s'];
      $filePath = $lesson['file_path'];
      $embedUrl = $lesson['video_url'];

      // Set value for embed input (latest)
      if (!empty($embedUrl)) $embedValue = $embedUrl;
    ?>
      <li class="list-group-item d-flex justify-content-between align-items-center" id="lesson_<?php echo $lessonId; ?>">
        <div>
          <?php if (!empty($filePath)): ?>
            📁 <a href="<?php echo $admindocumentPath . $filePath; ?>" target="_blank">View Uploaded Video</a>
          <?php elseif (!empty($embedUrl)): ?>
            🔗 <a href="<?php echo $embedUrl; ?>" target="_blank">View Embedded URL</a>
          <?php endif; ?>
        </div>
        <button type="button" class="btn btn-sm btn-danger delete-video-lesson" data-video-id="<?php echo $lessonId; ?>">
          Delete
        </button>
      </li>
    <?php endwhile; ?>
  </ul>
</div>

<!-- Video Upload & Embed Fields -->
<div class="mb-3 mt-3">
  <label class="form-label">Video Lessons (Upload or Embed URL)</label>
  <input type="file" class="form-control mb-2" name="video_lessons[]" multiple accept="video/*">

  <input type="url" class="form-control" name="video_embed_url" placeholder="Or paste video URL" value="<?php echo $embedValue; ?>">
</div>


<?php
$textQuery = mysqli_query($con, "SELECT * FROM {$siteprefix}training_text_modules WHERE training_id = '$training_id'");
if ($textQuery && mysqli_num_rows($textQuery) > 0): ?>
  <div class="mt-3">
    <strong>Uploaded Text Modules:</strong>
    <ul class="list-group">
      <?php while ($text = mysqli_fetch_assoc($textQuery)):
        $textId = $text['id'];
        $textPath = $text['file_path'];
      ?>
        <li class="list-group-item d-flex justify-content-between align-items-center" id="text_<?php echo $textId; ?>">
          <a href="<?php echo $admindocumentPath . $textPath; ?>" target="_blank">📄 <?php echo basename($textPath); ?></a>
          <button type="button" class="btn btn-sm btn-danger delete-text-module" data-id="<?php echo $textId; ?>">Delete</button>
        </li>
      <?php endwhile; ?>
    </ul>
  </div>
<?php endif; ?>

            <div class="mb-3">
              <label class="form-label">Text Modules / PDFs / Readings (Upload)</label>
              <input type="file" class="form-control" name="text_modules[]" multiple accept=".pdf,.txt,.doc,.docx">
            </div>
           <select class="form-control" name="pricing" id="pricingSelect" onchange="togglePricingFields()" required>
  <option value="">Select Pricing</option>
  <option value="donation" <?php echo ($pricing === 'donation') ? 'selected' : ''; ?>>Donation</option>
  <option value="free" <?php echo ($pricing === 'free') ? 'selected' : ''; ?>>Free</option>
  <option value="paid" <?php echo ($pricing === 'paid') ? 'selected' : ''; ?>>Paid</option>
</select>


<!-- Donation Info -->
<div class="mb-3" id="donationFields" style="display:none;">
  <p>This event allows attendees to pay any amount they choose as a donation.</p>
</div>

<!-- Free Info -->
<div class="mb-3" id="freeFields" style="display:none;">
  <p>This event is free for all attendees.</p>
</div>


<!-- Paid Ticket Fields -->
<div class="mb-3" id="paidFields" style="display:none;">
  <?php
  $tickets = [];
  if ($pricing === 'paid') {
      $ticketQuery = mysqli_query($con, "SELECT s, ticket_name, benefits, price, seats FROM {$siteprefix}training_tickets WHERE training_id = '$training_id'");
      while ($row = mysqli_fetch_assoc($ticketQuery)) {
          $tickets[] = $row;
      }
  }
  ?>

  <?php if (!empty($tickets)): ?>
    <?php foreach ($tickets as $ticket): ?>
      <label class="form-label">Ticket Name</label>
      <input type="hidden" name="ticket_ids[]" value="<?php echo htmlspecialchars($ticket['s']); ?>">
      <input type="text" class="form-control mb-2" name="ticket_name[]" value="<?php echo htmlspecialchars($ticket['ticket_name']); ?>" placeholder="e.g. General Admission">

      <label class="form-label">Benefits</label>
      <input type="text" class="form-control mb-2" name="ticket_benefits[]" value="<?php echo htmlspecialchars($ticket['benefits']); ?>" placeholder="e.g. Certificate, Lunch, Materials">

      <label class="form-label">Price</label>
      <input type="number" class="form-control mb-2" name="ticket_price[]" min="0" step="0.01" value="<?php echo htmlspecialchars($ticket['price']); ?>" placeholder="e.g. 5000">

      <label class="form-label">Number of Seats Available</label>
      <input type="number" class="form-control mb-3" name="ticket_seats[]" min="1" value="<?php echo htmlspecialchars($ticket['seats']); ?>" placeholder="e.g. 100">
    <?php endforeach; ?>
  <?php else: ?>
    <!-- Default empty fields if no tickets exist -->
    <label class="form-label">Ticket Name</label>
    <input type="text" class="form-control mb-2" name="ticket_name[]" placeholder="e.g. General Admission">

    <label class="form-label">Benefits</label>
    <input type="text" class="form-control mb-2" name="ticket_benefits[]" placeholder="e.g. Certificate, Lunch, Materials">

    <label class="form-label">Price</label>
    <input type="number" class="form-control mb-2" name="ticket_price[]" min="0" step="0.01" placeholder="e.g. 5000">

    <label class="form-label">Number of Seats Available</label>
    <input type="number" class="form-control mb-3" name="ticket_seats[]" min="1" placeholder="e.g. 100">
  <?php endif; ?>

  <!-- Container for JS-added tickets -->
  <div class="mb-3" id="ticketWrapper"></div>

  <!-- Add Another Ticket Button -->
  <button type="button" id="addTicketBtn" class="btn btn-secondary">Add Another Ticket</button>
</div>

<ul class="list-group mb-4">
  <h5>Promo Videos</h5>
  <?php
  $sql5 = "SELECT * FROM " . $siteprefix . "training_videos WHERE training_id = '$training_id' AND video_type = 'promo'";
  $sql6 = mysqli_query($con, $sql5);
  if (!$sql6) {
    die("Query failed: " . mysqli_error($con));
  }
  while ($row = mysqli_fetch_array($sql6)) {
    $videoId = $row['s'];
    $filePath = $row['video_path'];

  ?>
    <li class="list-group-item d-flex justify-content-between align-items-center" id="lesson_<?php echo $videoId; ?>">
      <div>
        <?php if (!empty($filePath)): ?>
          📁 <a href="<?php echo $siteurl . 'documents/' . $filePath; ?>" target="_blank">View Uploaded Video</a>
       
        <?php endif; ?>
      </div>
      <button type="button" class="btn btn-sm btn-danger delete-video-promo" data-video-id="<?php echo $videoId; ?>">
        Delete
      </button>
    </li>
  <?php } ?>
</ul>


<div class="mb-3">
  <label class="form-label">Promo Video (Optional)</label>
  <input type="file" class="form-control" name="promo_video" accept="video/*">
</div>

<ul class="list-group mb-4">
  <h5>Trailer Videos</h5>
  <?php
  $sql3 = "SELECT * FROM " . $siteprefix . "training_videos WHERE training_id = '$training_id' AND video_type = 'trailer'";
  $sql4 = mysqli_query($con, $sql3);
  if (!$sql4) {
    die("Query failed: " . mysqli_error($con));
  }
  while ($row = mysqli_fetch_array($sql4)) {
    $videoId = $row['s'];
    $filePath = $row['video_path'];
  
  ?>
    <li class="list-group-item d-flex justify-content-between align-items-center" id="lesson_<?php echo $videoId; ?>">
      <div>
        <?php if (!empty($filePath)): ?>
          📁 <a href="<?php echo $siteurl . 'documents/' . $filePath; ?>" target="_blank">View Uploaded Video</a>
       
        <?php endif; ?>
      </div>
      <button type="button" class="btn btn-sm btn-danger delete-video-trailer" data-video-id="<?php echo $videoId; ?>">
        Delete
      </button>
    </li>
  <?php } ?>
</ul>

 <div class="mb-3">
              <label class="form-label">Course Trailer/Intro Video (Optional)</label>
              <input type="file" class="form-control" name="trailer_video" accept="video/*">
            </div>
        <?php
// Fetch event types from the database
$eventTypes = [];
$eventTypeQuery = mysqli_query($con, "SELECT s, name FROM {$siteprefix}event_types");
while ($row = mysqli_fetch_assoc($eventTypeQuery)) {
    $eventTypes[] = $row;
}
?>

<div class="mb-3">
  <label class="form-label">Type of Training & Events</label>
  <select class="form-control" name="event_type" required>
    <option value="">Select Type</option>
    <?php foreach ($eventTypes as $type): ?>
      <option value="<?php echo htmlspecialchars($type['s']); ?>"
        <?php echo ($type['s'] == $selected_event_type) ? 'selected' : ''; ?>>
        <?php echo htmlspecialchars($type['name']); ?>
      </option>
    <?php endforeach; ?>
  </select>
</div>

 <?php
    // Fetch instructors from the database
    $instructors = [];
    $instructorQuery = mysqli_query($con, "SELECT s, name, photo FROM {$siteprefix}instructors");
    while ($row = mysqli_fetch_assoc($instructorQuery)) {
        $instructors[] = $row;
    }
    ?>
            <h6>Instructor Information</h6>
    <div class="mb-3">
      <label class="form-label">Select Instructor</label>

           <select class="form-control" name="instructor"id="instructorSelect" onchange="displayInstructorInfo()" required>
  <option value="">-- Select Instructor --</option>
  <?php foreach ($instructors as $inst): ?>
    <option value="<?php echo htmlspecialchars($inst['s']); ?>"
      data-name="<?php echo htmlspecialchars($inst['name']); ?>"
      data-photo="<?php echo $adminimagePath.$inst['photo']; ?>"
      <?php echo ($selected_instructor_id === $inst['s']) ? 'selected' : ''; ?>>
      <?php echo htmlspecialchars($inst['name']); ?>
    </option>
  <?php endforeach; ?>
  <option value="add_new">+ Add New Instructor</option>
</select>
  </div>
         
<!-- Display selected instructor info -->
<div class="mb-3" id="instructorInfo" style="display:none;">
  <img id="instructorPhoto" src="" alt="Instructor Photo" style="width:50px;height:50px;border-radius:50%;object-fit:cover;">
  <span id="instructorName" style="margin-left:10px;font-weight:bold;"></span>
</div>
<!-- Add New Instructor Fields (hidden by default) -->
<div class="mb-3" id="addInstructorFields" style="display:none;">
  <label class="form-label">Instructor Name</label>
  <input type="text" class="form-control mb-2" name="new_instructor_name" placeholder="Enter instructor name">
 <!---  <label class="form-label">Instructor Email</label> --->
  <input type="hidden" class="form-control mb-2" name="new_instructor_email" placeholder="Enter instructor email">
  <label class="form-label">Instructor Bio</label>
  <textarea class="form-control mb-2 editor" name="new_instructor_bio" placeholder="Enter instructor bio"></textarea>
  <label class="form-label">Instructor Photo</label>
  <input type="file" class="form-control" name="new_instructor_photo" accept="image/*">
      <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
</div>

<div class="mb-3">
  <label class="form-label">Additional Instructions or Notes</label>
  <textarea class="form-control editor" name="additional_notes" rows="3"><?php echo $additional_notes; ?></textarea>
</div>


<div class="mb-3">
  <label class="form-label">Tags</label>
  <input type="text" class="form-control" name="tags" placeholder="E.g. finance, business, marketing" value="<?php echo $tags; ?>">
</div>

    <?php if ($user_type === 'admin'): ?>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="loyalty" name="loyalty" <?php echo ($loyalty) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="loyalty">List under our Loyalty Program</label>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="mb-3">
                          <label class="form-label" for="status-type">Approval Status</label>
                          <select id="status-type" name="status" class="form-control" required <?= getReadonlyAttribute() ?>>
                            <option value="pending" <?php echo ($status == 'pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="approved" <?php echo ($status == 'approved') ? 'selected' : ''; ?>>Approved</option>
                          </select>
                        </div>
                        
            <div class="mb-3">
              <button type="submit" name="edit_event" class="btn btn-primary">Edit Event / Course</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



                    <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        toggleQuizOption("<?= $quiz_type ?>");
                    });
                    </script>

          
                        <script>
                        document.querySelector('select[name="category"]').addEventListener('change', function() {
                          let parentId = this.value;
                          let subSelect = document.getElementById('subcategory-container');
                          let subcategorySelect = document.getElementById('subcategory-select');
                          
                          fetch(`get_subcategories.php?parent_id=${parentId}`)
                            .then(response => response.json())
                            .then(data => {
                              console.log('Received data:', data);
                              if (data.length > 0) {
                                subcategorySelect.innerHTML = '<option selected>- Select Subcategory -</option>';
                                data.forEach(cat => {
                                  console.log('Processing category:', cat);
                                  subcategorySelect.innerHTML += `<option value="${cat.s}">${cat.title}</option>`;
                                });
                                subSelect.style.display = 'block';
                              } else {
                                console.log('No subcategories found');
                                subSelect.style.display = 'none';
                              }
                            })
                            .catch(error => {
                              console.error('Error fetching subcategories:', error);
                            });
                        });
                        </script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var select = document.getElementById('instructorSelect');
  if (select && select.value !== '') {
    displayInstructorInfo(); // Trigger display logic for pre-selected instructor
  }
});
</script>



                        <script>
  document.addEventListener("DOMContentLoaded", function () {
    toggleDeliveryFields();
    togglePhysicalLocationFields();
    toggleHybridLocationFields();
  });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  togglePricingFields();
});
</script>


<script>
var $j = jQuery.noConflict();

const selectedSubcategoryIds = <?= json_encode($selected_subcategories ?? []) ?>;
const selectedCategoryIds = <?= json_encode($selected_categories ?? []) ?>;

function fetchSubcategoriesForEdit(categoryIds) {
  const $subSelect = $j('#subcategory-select');
  const $subContainer = $j('#subcategory-container');
  $subSelect.html('');

  if (!categoryIds.length) {
    $subContainer.hide();
    return;
  }

  Promise.all(categoryIds.map(id =>
    fetch(`get_subcategories.php?parent_id=${id}`)
      .then(res => res.json())
      .catch(() => [])
  )).then(allResults => {
    let found = false;

    allResults.flat().forEach(cat => {
      if ($subSelect.find(`option[value="${cat.s}"]`).length === 0) {
        const isSelected = selectedSubcategoryIds.includes(cat.s.toString()) ? 'selected' : '';
        $subSelect.append(`<option value="${cat.s}" ${isSelected}>${cat.title}</option>`);
        found = true;
      }
    });

    if (found) {
      $subContainer.show();
      if ($subSelect.hasClass('select2-hidden-accessible')) {
        $subSelect.select2('destroy');
      }
      $subSelect.select2();
    } else {
      $subContainer.hide();
    }
  });
}

$j(document).ready(function () {
  $j('.select-multiple').select2();

  fetchSubcategoriesForEdit(selectedCategoryIds);

  $j('#category-select').on('change', function () {
    const selected = $j(this).val() || [];
    fetchSubcategoriesForEdit(selected);
  });
});
</script>


            <?php include "footer.php"; ?>

