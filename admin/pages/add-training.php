
<?php include "header.php"; ?>
<style>
.modal {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.5);
  z-index: 999;
}

.modal-content {
  background: #fff;
  margin: 10% auto;
  padding: 20px;
  width: 90%;
  max-width: 600px;
  border-radius: 10px;
  position: relative;
}

.close {
  position: absolute;
  right: 20px;
  top: 10px;
  font-size: 24px;
  cursor: pointer;
}
</style>
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
              <input type="text" class="form-control" name="title" required>
            </div>
              <div class="mb-3">
                          <label class="form-label" for="course-id">Training ID</label>
                            <input type="text" id="course-id" name="id" class="form-control" value="TH<?php echo sprintf('%06d', rand(1, 999999)); ?>" readonly required>
                        </div>
            <div class="mb-3">
              <label class="form-label">Cover Image</label>
              <input type="file" class="form-control" name="cover_images" accept="image/*"  required>
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea class="form-control editor" name="description"></textarea>
            </div>
           
              <input type="hidden" class="form-control" name="who_should_attend" placeholder="E.g. Beginners, Entrepreneurs, etc.">
       
            <div class="mb-3">
              <label class="form-label">Event Dates & Times</label>
              <div id="dateTimeRepeater">
                <div class="row mb-2 dateTimeRow">
                  <div class="col">
                    <input type="date" class="form-control" name="event_dates[]" required>
                  </div>
                  <div class="col">
                    <input type="time" class="form-control" name="event_start_times[]" required>
                  </div>
                  <div class="col">
                    <input type="time" class="form-control" name="event_end_times[]" required>
                  </div>
                  <div class="col-auto">
                    <button type="button" class="btn btn-success btn-sm" onclick="addDateTimeRow()"><i class="bx bx-plus me-1"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Language</label>
              <input type="text" class="form-control" name="language" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Certification Offered?</label>
              <select class="form-control" name="certification">
                <option value="yes">Yes</option>
                <option value="no">No</option>
              </select>
            </div>
                 <input type="hidden" name="user" value="<?php echo $user_id; ?>">
            <div class="mb-3">
              <label class="form-label">Level</label>
              <select class="form-control" name="level" required>
                <option value="">Select Level</option>
                <option value="beginner">Beginner</option>
                <option value="intermediate">Intermediate</option>
                <option value="advanced">Advanced</option>
              </select>
            </div>


             <?php
          // Fetch event types from the database
          $eventTypes = [];
          $eventTypeQuery = mysqli_query($con, "SELECT s, name FROM {$siteprefix}event_types");
          while ($row = mysqli_fetch_assoc($eventTypeQuery)) {
              $eventTypes[] = $row;
          }
          ?>
          <!-- ...existing code... -->

          <div class="mb-3">
            <label class="form-label">Type of Training & Events</label>
            <select class="form-control" name="event_type" required>
              <option value="">Select Type</option>
              <?php foreach ($eventTypes as $type): ?>
                <option value="<?php echo htmlspecialchars($type['s']); ?>">
                  <?php echo htmlspecialchars($type['name']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
  <label class="form-label">Pricing</label>
  <select class="form-control" name="pricing" id="pricingSelect" onchange="togglePricingFields()" required>
    <option value="">Select Pricing</option>
    <option value="donation">Donation</option>
    <option value="free">Free</option>
    <option value="paid">Paid</option>
  </select>
</div>

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
  <label class="form-label">Ticket Name</label>
  <input type="text" class="form-control mb-2" name="ticket_name[]" placeholder="e.g. General Admission">
  <label class="form-label">Benefits</label>
  <input type="text" class="form-control mb-2 editor" name="ticket_benefits[]" placeholder="e.g. Certificate, Lunch, Materials">
  <label class="form-label">Price</label>
  <input type="number" class="form-control mb-2" name="ticket_price[]" min="0" step="0.01" placeholder="e.g. 5000">
  <label class="form-label">Number of Seats Available</label>
  <input type="number" class="form-control" name="ticket_seats[]" min="1" placeholder="e.g. 100">

  <div class="mb-3" id="ticketWrapper">

              </div>
  <!-- Add Another Ticket Button -->
<button type="button" id="addTicketBtn" class="btn btn-secondary">Add Another Ticket</button>
</div>

                         <div class="mb-3">
                          <label>Category </label>
                        <select class="form-select select-multiple w-100" name="category[]" id="category-select" multiple required>
                          <option  disabled>- Select Category -</option>
                          <?php
                    $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL ";
                     $sql2 = mysqli_query($con, $sql);
                     while ($row = mysqli_fetch_array($sql2)) {
                     echo '<option value="' . $row['id'] . '">' . $row['category_name'] . '</option>'; }?>
                        </select>
                        </div>

                        <div class="mb-3" id="subcategory-container" style="display:none;">
                            <label>SubCategory </label>
                          <select  class="form-select select-multiple" name="subcategory[]" id="subcategory-select" multiple required>
                            <option  disabled>- Select Subcategory -</option>
                          </select>
                        </div>

    

            <h6>Course Content Details</h6>
       <div class="mb-3">
              <label class="form-label">Who Should Attend & Target Audience</label>
              <textarea class="form-control editor" name="target_audience" placeholder='E.g. "Beginners in Python", "Entrepreneurs", etc.'></textarea>
            </div>
        
              <textarea hidden class="form-control" name="course_description" rows="4"></textarea>
            
            <div class="mb-3">
              <label class="form-label">Learning Objectives / Outcomes</label>
              <textarea class="form-control editor" name="learning_objectives" rows="3" placeholder="List what the learner will be able to do after completing the course."></textarea>
            </div>
          
            <div class="mb-3">
              <label class="form-label">Course Requirements / Prerequisites</label>
              <textarea class="form-control editor" name="prerequisites" rows="2" placeholder="Any knowledge, tools, or skills needed before starting."></textarea>
            </div>

                        <div class="mb-3">
                          <label>Delivery Format </label>
              <select class="form-control" name="delivery_format" id="deliveryFormat" onchange="toggleDeliveryFields()" required>
                <option value="">Select Format</option>
                <option value="physical">Physical (In-person)</option>
                <option value="online">Online (Webinar/Virtual)</option>
                <option value="hybrid">Hybrid (Physical & Online)</option>
                   <option value="video">Video</option>
                <option value="text">Text</option>
                
              </select>
            </div> 
            <!-- Physical Address Fields -->
            <div class="mb-3" id="physicalFields" style="display:none;">
              <label class="form-label">Nigeria or Foreign</label>
              <select class="form-control" id="physicalLocationType" name="physicalLocationType" onchange="togglePhysicalLocationFields()">
                <option value="">Select</option>
                <option value="nigeria">Nigeria</option>
                <option value="foreign">Foreign</option>
              </select>
              <div id="nigeriaPhysicalFields" style="display:none;">
                <label class="form-label mt-2">Nigerian Address</label>
                <select id="state" name="state" class="form-control" >
              <option value="">-Select State-</option>
            </select>
                <select class="form-control" id="lga"  name="lga">
            <option value="">-Select LGA-</option>
          </select>
                <input type="text" class="form-control mb-2" name="nigeria_address" placeholder="Address">
               
  
                <input type="text" class="form-control mb-2" name="country" value="Nigeria" readonly>
              </div>
              <div id="foreignPhysicalFields" style="display:none;">
                <label class="form-label mt-2">Foreign Address</label>
                <input type="text" class="form-control mb-2" name="foreign_address">
              </div>
            </div>
            <!-- Online Address Field -->
            <div class="mb-3" id="onlineFields" style="display:none;">
              <label class="form-label">Web Address (Zoom, YouTube, etc.)</label>
              <input type="url" class="form-control" name="web_address">
            </div>
            <!-- Hybrid Address Fields -->
            <div class="mb-3" id="hybridFields" style="display:none;">
              <label class="form-label">Physical Address</label>
              <input type="text" class="form-control mb-2" name="hybrid_physical_address">
              <label class="form-label">Web Address</label>
              <input type="url" class="form-control mb-2" name="hybrid_web_address">
              <label class="form-label">Nigeria or Foreign</label>
              <select class="form-control" id="hybridLocationType" name="hybridLocationType" onchange="toggleHybridLocationFields()">
                <option value="">Select</option>
                <option value="nigeria">Nigeria</option>
                <option value="foreign">Foreign</option>
              </select>
              <div id="nigeriaHybridFields" style="display:none;">
                    <select id="hybrid_state"  name="hybrid_state" class="form-control">
              <option value="">-Select State-</option>
            </select>
                <select class="form-control" id="hybrid_lga" name="hybrid_lga">
            <option value="">-Select LGA-</option>
          </select>
                <input type="text" class="form-control mb-2" name="hybrid_country" value="Nigeria" readonly>
              </div>
              <div id="foreignHybridFields" style="display:none;">
                <input type="text" class="form-control mb-2" name="hybrid_foreign_address" placeholder="Foreign Address">
              </div>
            </div>

            <!-- Video Fields -->
<div id="videoFields" style="display:none;">
  <label>Total Number of Videos:</label>
  <input type="number" class="form-control" name="total_videos" min="1">

  <div id="videoModules">
    <!-- Template -->
    <div class="video-module mb-3">
      <h5>Module <span class="module-number">1</span></h5>
      <label>Lesson / Module Title:</label>
      <input type="text" class="form-control" name="video_module_title[]">

      <label>Description/Notes:</label>
      <textarea class="form-control editor" name="video_module_desc[]"></textarea>

      <label>Total Duration:</label>
      <input type="text" class="form-control" name="video_duration[]">

      <label>Upload/Link Video Files:</label>
      <input type="file" name="video_file[]" class="form-control mb-2" accept="video/*">
      <input type="url" class="form-control mt-2" placeholder="Or paste link" name="video_link[]">

      <label>Video Quality</label><br>
      <label><input type="checkbox" name="video_quality[0][]" value="720p"> 720p</label>
      <label><input type="checkbox" name="video_quality[0][]" value="1080p"> 1080p</label>
      <label><input type="checkbox" name="video_quality[0][]" value="4K"> 4K</label>

      <br>
      <label>Include Subtitles?</label><br>
      <label><input type="checkbox" name="video_subtitles[0]" value="Yes"> Yes</label>
      <label><input type="checkbox" name="video_subtitles[0]" value="No"> No</label>
    </div>
  </div>

  <button type="button" class="btn btn-secondary mt-3" onclick="addVideoModule()">ADD MORE</button>
</div>

<!-- Text Fields -->
<div id="textFields" style="display:none;">
  <label>Number of Lessons/Modules:</label>
  <input type="number" class="form-control" name="total_lessons" min="1">

  <div id="textModules">
    <!-- Template -->
    <div class="text-module mb-3">
      <h5>Module <span class="module-number">1</span></h5>
      <label>Lesson / Module Title:</label>
      <input type="text" class="form-control" name="text_module_title[]">

      <label>Description/Notes:</label>
      <textarea class="form-control editor" name="text_module_desc[]"></textarea>

      <label>Estimated Reading Time:</label>
      <input type="text" class="form-control" name="text_reading_time[]">

      <label>Upload Text Content (PDF/Text):</label>
      <input type="file" name="text_file[]">
    </div>
  </div>

  <button type="button" class="btn btn-secondary mt-3" onclick="addTextModule()">ADD MORE</button>
</div>


            <h6>Course Content Uploads</h6>
            <div class="mb-3">
              <label class="form-label">Video Lessons (Upload or Embed URL)</label>
              <input type="file" class="form-control mb-2" name="video_lessons[]" multiple accept="video/*">
              <input type="url" class="form-control" name="video_embed_url" placeholder="Or paste video URL">
            </div>
            <div class="mb-3">
              <label class="form-label">Text Modules / PDFs / Readings (Upload)</label>
              <input type="file" class="form-control" name="text_modules[]" multiple accept=".pdf,.txt,.doc,.docx">
            </div>
            <div class="mb-3">
              <div>
              <label class="form-label">Quizzes & Assignments</label>
          </div>
         <label>Choose how to provide quiz/assignment content:</label>
          <select onchange="toggleQuizOption(this.value)" name="quiz_method" class="form-control mb-3">
            <option value="">-- Select Option --</option>
            <option value="text">Text Entry</option>
            <option value="upload">Upload Files</option>
            <option value="form">Use Form Builder</option>
          </select>

        <!-- Option 1: Text Entry -->
        <div id="quizText" style="display:none;">
          <label>Text Entry:</label>
          <textarea name="quiz_text" placeholder="e.g., Write a short essay on the impact of AI on job markets..." class="form-control editor"></textarea>
        </div>

        <!-- Option 2: File Upload -->
      <div id="quizUpload" style="display:none;">
        <label>Upload Quiz or Assignment Files:</label>
        <input type="file" name="quiz_files[]" multiple  class="form-control">
        <small>You can upload multiple files (PDF, Word, Text).</small>
      </div>
<div id="quizFormButton" style="display:none;">
  <label>Use the Form Builder to Add Structured Questions:</label><br>
  <button type="button" onclick="openQuizModal()" class="btn btn-success"><i class="bx bx-plus me-1"></i>Add Quiz/Assignment Questions</button>
</div>

      <div id="quizModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close" onclick="closeQuizModal()">&times;</span>
    <h3>🧠 Add Quiz Questions</h3>
    
<div id="quizBuilderModal">
  <div class="mb-3">
    <label>Instructions:</label>
    <textarea name="quiz_instructions" placeholder="Quiz Instructions" class="form-control mb-2 editor"></textarea>
  </div>

  <!-- Template to clone -->
  <div class="question-block">
    <div class="mb-3">
      <label>Question:</label>
      <textarea name="questions[]" class="form-control mb-2 editor" placeholder="Question"></textarea>
    </div>
    <div class="mb-3">
      <input type="text" name="option_a[]" placeholder="Option A">
      <input type="text" name="option_b[]" placeholder="Option B">
      <input type="text" name="option_c[]" placeholder="Option C">
      <input type="text" name="option_d[]" placeholder="Option D">
    </div>
    <div class="mb-3">
      <label>Correct Answer:</label>
      <select name="correct_answer[]" class="form-select mb-3">
        <option value="a">A</option>
        <option value="b">B</option>
        <option value="c">C</option>
        <option value="d">D</option>
      </select>
    </div>
    
    <hr>
  </div>
</div>


    <button type="button" onclick="addQuizQuestionModal()" class="btn btn-secondary"><i class="bx bx-plus me-1"></i>Add Another Question</button>
    <br><br>
    <button type="button" onclick="closeQuizModal()" class="btn btn-primary">✅ Done</button>
  </div>
</div>
            </div>
            <div class="mb-3">
              <label class="form-label">Course Trailer/Intro Video (Optional)</label>
              <input type="file" class="form-control" name="trailer_video" accept="video/*">
            </div>

         

                            <?php
    // Fetch instructors from the database
    $instructors = [];
    $instructorQuery = mysqli_query($con, "SELECT s, name, photo FROM {$siteprefix}instructors");
    while ($row = mysqli_fetch_assoc($instructorQuery)) {
        $instructors[] = $row;
    }
    ?>
    <!-- ...existing code... -->

    <h6>Instructor Information</h6>
    <div class="mb-3">
      <label class="form-label">Select Instructor</label>
      <select class="form-control" name="instructor" id="instructorSelect" onchange="displayInstructorInfo()" required>
        <option value="">-- Select Instructor --</option>
        <?php foreach ($instructors as $inst): ?>
          <option value="<?php echo htmlspecialchars($inst['s']); ?>"
            data-name="<?php echo htmlspecialchars($inst['name']); ?>"
            data-photo="<?php echo $siteurl.$inst['photo']; ?>">
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
  <label class="form-label">Promo Video (Optional)</label>
  <input type="file" class="form-control" name="promo_video" accept="video/*">
</div>

<div class="mb-3">
  <label class="form-label">Additional Instructions or Notes</label>
  <textarea class="form-control editor" name="additional_notes" rows="3"></textarea>
</div>


<div class="mb-3">
  <label class="form-label">Tags</label>
  <input type="text" class="form-control" name="tags" placeholder="E.g. finance, business, marketing">
</div>


 <?php if($user_type === 'admin'): ?>
                        <div class="mb-3">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="loyalty" name="loyalty">
                            <label class="form-check-label" for="loyalty">List under our Loyalty Program</label>
                          </div>
                        </div>
                        <?php endif; ?>
                      
            <div class="mb-3">
                          <label class="form-label" for="status-type">Approval Status</label>
                          <select id="status-type" name="status" class="form-control" required <?= getReadonlyAttribute() ?>>
                            <option value="pending" selected>Pending</option>
                            <option value="approved">Approved</option>
                          </select>
                        </div>
                        
            <div class="mb-3">
              <button type="submit" name="add_event" class="btn btn-primary">Add Event / Course</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>




          
                <script>
  var $j = jQuery.noConflict();

  $j(document).ready(function () {
    $j('.select-multiple').select2();

    $j('#category-select').on('change', function () {
      const selectedCategories = Array.from(this.selectedOptions).map(opt => opt.value);
      const $subSelect = $j('#subcategory-select');
      const $subContainer = $j('#subcategory-container');

      // Clear subcategory options
      $subSelect.html('');

      if (selectedCategories.length === 0) {
        $subContainer.hide();
        return;
      }

      // Fetch subcategories for each selected category
      Promise.all(
        selectedCategories.map(categoryId =>
          fetch(`get_subcategories.php?parent_id=${categoryId}`)
            .then(response => response.json())
            .catch(error => {
              console.error('Error fetching subcategories for category', categoryId, error);
              return [];
            })
        )
      ).then(allResults => {
        let found = false;

        // Flatten all subcategories into one array
        allResults.flat().forEach(cat => {
          if ($subSelect.find(`option[value="${cat.s}"]`).length === 0) {
            $subSelect.append(new Option(cat.title, cat.s));
            found = true;
          }
        });

        if (found) {
          $subContainer.show();

          // Re-initialize select2 after modifying the options
          if ($subSelect.hasClass('select2-hidden-accessible')) {
            $subSelect.select2('destroy');
          }
          $subSelect.select2();
        } else {
          $subContainer.hide();
        }
      });
    });
  });
</script>

            <?php include "footer.php"; ?>
