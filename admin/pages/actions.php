<?php


// Query to count total users
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM ".$siteprefix."users WHERE type != 'admin'"; 
$totalUsersResult = mysqli_query($con, $totalUsersQuery);
$totalUsers = mysqli_fetch_assoc($totalUsersResult)['total_users'];

// Query to calculate total profit
$totalProfitQuery = "SELECT SUM(amount) AS total_profit FROM ".$siteprefix."profits";
$totalProfitResult = mysqli_query($con, $totalProfitQuery);
$totalProfit = mysqli_fetch_assoc($totalProfitResult)['total_profit'];

// Query to count total reports
$totalReportsQuery = "SELECT COUNT(*) AS total_reports FROM ".$siteprefix."training";
$totalReportsResult = mysqli_query($con, $totalReportsQuery);
$totalReports = mysqli_fetch_assoc($totalReportsResult)['total_reports'];

// Query to count total sales (paid orders)
$totalSalesQuery = "SELECT COUNT(order_id) AS total_sales FROM ".$siteprefix."orders WHERE status = 'paid'";
$totalSalesResult = mysqli_query($con, $totalSalesQuery);
$totalSales = mysqli_fetch_assoc($totalSalesResult)['total_sales'];

// Query to fetch pending reports count
$pendingReportsQuery = "SELECT COUNT(*) AS count FROM " . $siteprefix . "training WHERE status = 'pending'";
$pendingReportsResult = mysqli_query($con, $pendingReportsQuery);
$pendingReportsCount = mysqli_fetch_assoc($pendingReportsResult)['count'];

// Query to fetch pending payments count
$pendingPaymentsQuery = "SELECT COUNT(*) AS count FROM " . $siteprefix . "manual_payments WHERE status = 'pending'";
$pendingPaymentsResult = mysqli_query($con, $pendingPaymentsQuery);
$pendingPaymentsCount = mysqli_fetch_assoc($pendingPaymentsResult)['count'];

// Query to fetch pending payments count
$approvedPaymentsQuery = "SELECT COUNT(*) AS count FROM " . $siteprefix . "manual_payments WHERE status = 'approved'";
$approvedPaymentsResult = mysqli_query($con, $approvedPaymentsQuery);
$clearedOrdersCount = mysqli_fetch_assoc($approvedPaymentsResult)['count'];

// Query to fetch pending payments count
$pendingPaymentsQuery = "SELECT COUNT(*) AS count FROM " . $siteprefix . "manual_payments WHERE status = 'pending'";
$pendingPaymentsResult = mysqli_query($con, $pendingPaymentsQuery);
$pendingPaymentsCount = mysqli_fetch_assoc($pendingPaymentsResult)['count'];

// Query to fetch pending payments count
$approvedPaymentsQuery = "SELECT COUNT(*) AS count FROM " . $siteprefix . "manual_payments WHERE status = 'approved'";
$approvedPaymentsResult = mysqli_query($con, $approvedPaymentsQuery);
$clearedOrdersCount = mysqli_fetch_assoc($approvedPaymentsResult)['count'];


// Query to fetch pending withdrawals count
$pendingWithdrawalsQuery = "SELECT COUNT(*) AS count FROM " . $siteprefix . "withdrawal WHERE status = 'pending'";
$pendingWithdrawalsResult = mysqli_query($con, $pendingWithdrawalsQuery);
$pendingWithdrawalsCount = mysqli_fetch_assoc($pendingWithdrawalsResult)['count'];

// Query to fetch pending disputes count
$pendingDisputesQuery = "SELECT COUNT(*) AS count FROM " . $siteprefix . "disputes WHERE status = 'pending'";
$pendingDisputesResult = mysqli_query($con, $pendingDisputesQuery);
$pendingDisputesCount = mysqli_fetch_assoc($pendingDisputesResult)['count'];

$sql = "SELECT * FROM  ".$siteprefix."alerts WHERE status='0' ORDER BY s DESC LIMIT 5";
$sql2 = mysqli_query($con,$sql);
$notification_count = mysqli_num_rows($sql2);

//read message

if (isset($_GET['action']) && $_GET['action'] == 'read-message') {
    $sql = "UPDATE ".$siteprefix."alerts SET status='1' WHERE status='0'";
    $sql2 = mysqli_query($con,$sql);
    $message="All notifications marked as read.";
    showToast($message);
    header("refresh:2; url=notifications.php");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_event'])) {

        // Directories for uploads
    $uploadDir = '../../uploads/';
    $fileuploadDir = '../../documents/';
  
    $message = "";
    $physical_address = $physical_state = $physical_lga = $physical_country = $foreign_address = '';
    $web_address = '';
    $hybrid_physical_address = $hybrid_web_address = $hybrid_state = $hybrid_lga = $hybrid_country = $hybrid_foreign_address = '';
    $status = $_POST['status'];
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
   // Main category (Tier 1)
    $category = !empty($_POST['category']) ? implode(',', $_POST['category']) : '';

    // Collect subcategories (Tiers 2+)
    $allSubs = [];

    if (!empty($_POST['subcategory'])) {
        $allSubs = array_merge($allSubs, $_POST['subcategory']);
    }
    if (!empty($_POST['subsubcategory'])) {
        $allSubs = array_merge($allSubs, $_POST['subsubcategory']);
    }
    if (!empty($_POST['subsubsubcategory'])) {
        $allSubs = array_merge($allSubs, $_POST['subsubsubcategory']);
    }

    $allSubs = array_unique($allSubs);
    $subcategory = implode(',', $allSubs);

    $event_type = mysqli_real_escape_string($con, $_POST['event_type']);
    $attendee = mysqli_real_escape_string($con, $_POST['who_should_attend']);
    $loyalty = isset($_POST['loyalty']) ? 1 : 0;
    $user = mysqli_real_escape_string($con, $_POST['user']);
    $training_id = mysqli_real_escape_string($con, $_POST['training-id']);
    $language = mysqli_real_escape_string($con, $_POST['language']);
    $certification = mysqli_real_escape_string($con, $_POST['certification']);
    $course_description = mysqli_real_escape_string($con, $_POST['course_description']);
    $level = mysqli_real_escape_string($con, $_POST['level']);
     $tags = mysqli_real_escape_string($con, $_POST['tags']);
    $learning_objectives = mysqli_real_escape_string($con, $_POST['learning_objectives']);
    $target_audience = mysqli_real_escape_string($con, $_POST['target_audience']);
    $prerequisites = mysqli_real_escape_string($con, $_POST['prerequisites']);
    $additional_notes = mysqli_real_escape_string($con, $_POST['additional_notes']);
    $delivery_format = mysqli_real_escape_string($con, $_POST['delivery_format']);
    $video_embed_url = mysqli_real_escape_string($con, $_POST['video_embed_url']);
    $pricing = mysqli_real_escape_string($con, $_POST['pricing']);

    
    // Check the current status of the report in the database
    $currentStatusQuery = "SELECT status FROM ".$siteprefix."training WHERE training_id = '$training_id'";
    $currentStatusResult = mysqli_query($con, $currentStatusQuery);
    $currentStatusRow = mysqli_fetch_assoc($currentStatusResult);
    $currentStatus = $currentStatusRow['status'];

    // Only proceed if the current status is not 'approved' and the new status is 'approved'
    if ($currentStatus !== 'approved' && $status === 'approved' ) {

        // Fetch seller_id from the users table
$sellerQuery = "SELECT * FROM ".$siteprefix."users WHERE s = '$user_id'";
$sellerResult = mysqli_query($con, $sellerQuery);

if ($sellerResult && mysqli_num_rows($sellerResult) > 0) {
    $sellerRow = mysqli_fetch_assoc($sellerResult);
    $seller_id = $sellerRow['trainer'];

    // Check if the seller_id is 1
    if ($seller_id > 0) {
        // Proceed with the rest of the logic
        $sellerEmail = $sellerRow['email_address'];
        $sellerName = $sellerRow['display_name'];

        // Prepare the email
$emailSubject = "🎉 Your event Is Now Live on Learnora!";

$emailMessage = "
    <p>Dear Contributor,</p>

    <p>We’re thrilled to inform you that your event titled <strong>\"$title\"</strong> has been successfully reviewed and is now live on the <strong>Financial Models Store</strong> marketplace!</p>

   <p>You can view your document here:  <a href='{$siteurl}trainer-store.php?seller_id=$user_id' target='_blank'>$title</a></p>

    <p>To maximize visibility and boost your initial sales, we recommend promoting your events across the following platforms:</p>

    <ul>
        <li><strong>LinkedIn:</strong> Create a LinkedIn Pulse article (not just a post) to introduce your event. Tag friends, peers, and communities in the comments to drive engagement and reach.</li>
        <li><strong>Product Hunt:</strong> Launch your event as a product. Tag <em>Learnora</em> as a collaborator to amplify exposure.</li>
        <li><strong>Reddit, Nairaland, Quora, and Medium:</strong> Engage with niche communities by sharing your event and participating in discussions around financial modeling and academic resources.</li>
    </ul>

    <p>Promoting your model through these channels can significantly enhance your event’s reach, improve SEO, and drive sustainable long-term traction.</p>

    <p>Thank you for being a valued member of the Learnora community!</p>

    <p>Warm regards,<br>
    The Learnora Team</p>
";


        // Send the email
        sendEmail($sellerEmail, $sellerName, $siteName, $siteMail, $emailMessage, $emailSubject);
    }
}
        // Check if the user_id matches the seller_id in the followers table
        $followersQuery = "SELECT user_id FROM ".$siteprefix."followers WHERE seller_id = '$user_id'";
        $followersResult = mysqli_query($con, $followersQuery);

        if (mysqli_num_rows($followersResult) > 0) {
            // Fetch the seller's name
            $sellerQuery = "SELECT display_name FROM ".$siteprefix."users WHERE s = '$user_id'";
            $sellerResult = mysqli_query($con, $sellerQuery);
            $sellerRow = mysqli_fetch_assoc($sellerResult);
            $sellerName = $sellerRow['display_name'];

            // Notify all followers
            while ($follower = mysqli_fetch_assoc($followersResult)) {
                $followerId = $follower['user_id'];

                // Fetch follower details
                $followerDetailsQuery = "SELECT email_address, display_name FROM ".$siteprefix."users WHERE s = '$followerId'";
                $followerDetailsResult = mysqli_query($con, $followerDetailsQuery);
                $followerDetails = mysqli_fetch_assoc($followerDetailsResult);

                $followerEmail = $followerDetails['email_address'];
                $followerName = $followerDetails['display_name'];

                // Prepare the email
                $emailSubject = "New event Posted by $sellerName";
                $emailMessage = "
                    <p>We are excited to inform you that $sellerName has just posted a new event titled <strong>$title</strong>.</p>
                        <p>You can check it out here: 
    <a href=\"{$siteurl}trainer-store.php?seller_id={$user_id}\">{$sellerName}</a>
    </p>
                    <p>Thank you for following $sellerName!</p>";

                // Send the email
                sendEmail($followerEmail, $followerName, $siteName, $siteMail, $emailMessage, $emailSubject);

                // Notify user
                insertAlert($con, $followerId, "New event titled $title has been posted by $sellerName", $currentdatetime, 0);
            }
        }

  

// Query to get users following the category
$categories = explode(',', $category); // Convert comma-separated string back to array

foreach ($categories as $catId) {
    $catId = trim($catId);

    // Query to get users following this category
    $categoryFollowersQuery = "SELECT user_id FROM " . $siteprefix . "followers WHERE category_id = '$catId'";
    $categoryFollowersResult = mysqli_query($con, $categoryFollowersQuery);

    if ($categoryFollowersResult && mysqli_num_rows($categoryFollowersResult) > 0) {
        // Fetch category name for the email
        $categoryQuery = "SELECT * FROM " . $siteprefix . "categories WHERE id = '$catId'";
        $categoryResult = mysqli_query($con, $categoryQuery);
        $categoryRow = mysqli_fetch_assoc($categoryResult);
        $categoryName = $categoryRow['category_name'];
        $slugs = $categoryRow['slug'];

        // Notify all users following this category
        while ($follower = mysqli_fetch_assoc($categoryFollowersResult)) {
            $followerId = $follower['user_id'];

            // Fetch follower details
            $followerDetailsQuery = "SELECT email_address, display_name FROM " . $siteprefix . "users WHERE s = '$followerId'";
            $followerDetailsResult = mysqli_query($con, $followerDetailsQuery);
            $followerDetails = mysqli_fetch_assoc($followerDetailsResult);

            $followerEmail = $followerDetails['email_address'];
            $followerName = $followerDetails['display_name'];

            // Prepare the email
            $emailSubject = "New event in $categoryName";
        $emailMessage = "
    <p>We are excited to inform you that a new eventl titled <strong>{$title}</strong> has been added to the <strong>{$categoryName}</strong> category.</p>
    <p>You can check it out here: <a href=\"{$siteurl}category/{$slugs}\" target=\"_blank\">{$categoryName}</a></p>
    <p>Thank you for following the <strong>{$categoryName}</strong> category!</p>
";


            // Send the email
            sendEmail($followerEmail, $followerName, $siteName, $siteMail, $emailMessage, $emailSubject);

            // Notify user
            insertAlert($con, $followerId, "New event titled $title under category $categoryName has been posted", $currentdatetime, 0);
        }
    }
    }

    }
    if ($delivery_format === 'video' && !empty($_POST['video_module_title_existing'])) {
    foreach ($_POST['video_module_title_existing'] as $moduleId => $title) {
        $desc      = $_POST['video_module_desc_existing'][$moduleId] ?? '';
        $duration  = $_POST['video_duration_existing'][$moduleId] ?? '';
        $videoLink = $_POST['video_link_existing'][$moduleId] ?? '';
        $qualities = isset($_POST['video_quality_existing'][$moduleId]) ? implode(',', $_POST['video_quality_existing'][$moduleId]) : '';
        $subtitles = $_POST['video_subtitles_existing'][$moduleId] ?? '';

        $filePath = '';

        // Check if a new file was uploaded
        if (!empty($_FILES['video_file_existing']['name'][$moduleId])) {
            // Restructure file array for handleFileUpload()
            $tmpFileKey = 'single_video_update';
            $_FILES[$tmpFileKey] = [
                'name'     => $_FILES['video_file_existing']['name'][$moduleId],
                'type'     => $_FILES['video_file_existing']['type'][$moduleId],
                'tmp_name' => $_FILES['video_file_existing']['tmp_name'][$moduleId],
                'error'    => $_FILES['video_file_existing']['error'][$moduleId],
                'size'     => $_FILES['video_file_existing']['size'][$moduleId]
            ];

            // Upload file
            $fileName = handleFileUpload($tmpFileKey, $fileuploadDir);
            if ($fileName && strpos($fileName, 'Failed') === false && strpos($fileName, 'error') === false) {
                $filePath = $fileuploadDir . $fileName;

                // Remove old file
                $oldFileQuery = $con->prepare("SELECT file_path FROM {$siteprefix}training_video_modules WHERE id = ?");
                $oldFileQuery->bind_param("i", $moduleId);
                $oldFileQuery->execute();
                $oldFileResult = $oldFileQuery->get_result()->fetch_assoc();
                if (!empty($oldFileResult['file_path']) && file_exists($oldFileResult['file_path'])) {
                    unlink($oldFileResult['file_path']);
                }
                $oldFileQuery->close();
            }
        }

        // Build update query dynamically
        if ($filePath) {
            $stmt = $con->prepare("
                UPDATE {$siteprefix}training_video_modules 
                SET title = ?, description = ?, duration = ?, file_path = ?, video_link = ?, video_quality = ?, subtitles = ?, updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->bind_param("sssssssi", $title, $desc, $duration, $filePath, $videoLink, $qualities, $subtitles, $moduleId);
        } else {
            $stmt = $con->prepare("
                UPDATE {$siteprefix}training_video_modules 
                SET title = ?, description = ?, duration = ?, video_link = ?, video_quality = ?, subtitles = ?, updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->bind_param("ssssssi", $title, $desc, $duration, $videoLink, $qualities, $subtitles, $moduleId);
        }

        $stmt->execute();
        $stmt->close();
    }
}

if (!empty($_POST['text_module_title_existing'])) {
    foreach ($_POST['text_module_title_existing'] as $moduleId => $title) {
        $desc       = $_POST['text_module_desc_existing'][$moduleId] ?? '';
        $reading    = $_POST['text_reading_time_existing'][$moduleId] ?? '';
        $filePath   = '';

        if (!empty($_FILES['text_file_existing']['name'][$moduleId])) {
            $tmpFileKey = 'single_text_upload';
            $_FILES[$tmpFileKey] = [
                'name'     => $_FILES['text_file_existing']['name'][$moduleId],
                'type'     => $_FILES['text_file_existing']['type'][$moduleId],
                'tmp_name' => $_FILES['text_file_existing']['tmp_name'][$moduleId],
                'error'    => $_FILES['text_file_existing']['error'][$moduleId],
                'size'     => $_FILES['text_file_existing']['size'][$moduleId]
            ];

            $fileName = handleFileUpload($tmpFileKey, $fileuploadDir);
            if ($fileName && strpos($fileName, 'Failed') === false) {
                $filePath = $fileuploadDir . $fileName;
            }
        }

        if (!empty($filePath)) {
            $stmt = $con->prepare("
                UPDATE {$siteprefix}training_texts_modules
                SET title=?, description=?, reading_time=?, file_path=?, updated_at=NOW()
                WHERE id=?
            ");
            $stmt->bind_param("ssssi", $title, $desc, $reading, $filePath, $moduleId);
        } else {
            $stmt = $con->prepare("
                UPDATE {$siteprefix}training_texts_modules
                SET title=?, description=?, reading_time=?, updated_at=NOW()
                WHERE id=?
            ");
            $stmt->bind_param("sssi", $title, $desc, $reading, $moduleId);
        }
        $stmt->execute();
        $stmt->close();
    }
}


// Handle image uploads

    $fileKeys = 'images';
    if (empty($_FILES[$fileKeys]['name'][0])) {
       // Array of default images
     //  $defaultImages = ['default1.jpg', 'default2.jpg', 'default3.jpg', 'default4.jpg', 'default5.jpg'];
        // Pick a random default image
     //  $randomImage = $defaultImages[array_rand($defaultImages)];
     //   $reportImages = [$randomImage];
        $reportImages = [];
    }else{
    $reportImages = handleMultipleFileUpload($fileKeys, $uploadDir);
     }

     $uploadedFiles = [];
    foreach ($reportImages as $image) {
        $stmt = $con->prepare("INSERT INTO  ".$siteprefix."training_images (training_id, picture, updated_at) VALUES (?, ?, current_timestamp())");
        $stmt->bind_param("ss", $training_id, $image);
        if ($stmt->execute()) {
            $uploadedFiles[] = $image;
        } else {
            $message.="Error: " . $stmt->error;
            $hasError = true;
        }
        $stmt->close();
    }



$submitted_ids = [];

if (!empty($_POST['event_dates'])) {
    foreach ($_POST['event_dates'] as $i => $date) {
        $event_date = mysqli_real_escape_string($con, $_POST['event_dates'][$i]);
        $start_time = mysqli_real_escape_string($con, $_POST['event_start_times'][$i]);
        $end_time = mysqli_real_escape_string($con, $_POST['event_end_times'][$i]);

        $event_id = isset($_POST['event_ids'][$i]) ? intval($_POST['event_ids'][$i]) : 0;

        if ($event_id > 0) {
            // Update existing record
            mysqli_query(
                $con,
                "UPDATE {$siteprefix}training_event_dates 
                 SET event_date = '$event_date', start_time = '$start_time', end_time = '$end_time'
                 WHERE s = '$event_id' AND training_id = '$training_id'"
            );
            $submitted_ids[] = $event_id;
        } else {
            // Insert new record
            mysqli_query(
                $con,
                "INSERT INTO {$siteprefix}training_event_dates (training_id, event_date, start_time, end_time)
                 VALUES ('$training_id', '$event_date', '$start_time', '$end_time')"
            );
            $submitted_ids[] = mysqli_insert_id($con); // Optional if you need it later
        }
    }

    // Delete records not included in the form
    if (!empty($submitted_ids)) {
        $ids_to_keep = implode(',', array_map('intval', $submitted_ids));
        mysqli_query(
            $con,
            "DELETE FROM {$siteprefix}training_event_dates 
             WHERE training_id = '$training_id' AND s NOT IN ($ids_to_keep)"
        );
    } else {
        // No submitted IDs at all? Delete all for this training
        mysqli_query(
            $con,
            "DELETE FROM {$siteprefix}training_event_dates 
             WHERE training_id = '$training_id'"
        );
    }
}
if (isset($_POST['video_embed_url']) && !empty($_POST['video_embed_url'])) {
    $trailer_video_path = mysqli_real_escape_string($con, $_POST['video_embed_url']);
  

    $update_sql = "
        UPDATE {$siteprefix}training_video_lessons 
        SET file_path = '', 
            video_url = '$trailer_video_path', 
            updated_at = NOW() 
        WHERE training_id = '$training_id'
    ";

    mysqli_query($con, $update_sql) or die("Update failed: " . mysqli_error($con));
}


    if (!empty($_FILES['video_lessons']['name'])) {
        $fileKey = 'video_lessons';
        $videoFiles = handleMultipleFileUpload($fileKey, $fileuploadDir);

    foreach ($videoFiles as $file) {
        $stmt = $con->prepare(
            "INSERT INTO {$siteprefix}training_video_lessons (training_id, file_path, video_url, updated_at) VALUES (?, ?, '', NOW())"
        );
        $stmt->bind_param("ss", $training_id, $file);
        if (!$stmt->execute()) {
            $message .= "Error inserting file: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }
    }

    if (!empty($_FILES['text_modules']['name'][0])) {
    $fileKey = 'text_modules';
    $textFiles = handleMultipleFileUpload($fileKey, $fileuploadDir);

    foreach ($textFiles as $file) {
        $stmt = $con->prepare(
            "INSERT INTO {$siteprefix}training_text_modules (training_id, file_path, updated_at) VALUES (?, ?, NOW())"
        );
        $stmt->bind_param("ss", $training_id, $file);
        if (!$stmt->execute()) {
            $message .= "Error inserting text module: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }
}

if (isset($_POST['pricing']) && $_POST['pricing'] === 'paid') {
    $ticket_ids      = $_POST['ticket_ids']      ?? [];
    $ticket_names    = $_POST['ticket_name']     ?? [];
    $ticket_benefits = $_POST['ticket_benefits'] ?? [];
    $ticket_prices   = $_POST['ticket_price']    ?? [];
    $ticket_seats    = $_POST['ticket_seats']    ?? [];

    foreach ($ticket_names as $index => $name) {
        $ticket_id = isset($ticket_ids[$index]) ? intval($ticket_ids[$index]) : 0;
        $name      = mysqli_real_escape_string($con, $name ?? '');
        $benefits  = mysqli_real_escape_string($con, $ticket_benefits[$index] ?? '');
        $price     = floatval($ticket_prices[$index] ?? 0);
        $seats     = intval($ticket_seats[$index] ?? 0);

        if ($ticket_id > 0) {
            // Update existing ticket
            mysqli_query($con, "UPDATE {$siteprefix}training_tickets 
                SET ticket_name = '$name',
                    benefits = '$benefits',
                    price = '$price',
                    seats = '$seats',
                    seatremain = '$seats'
                WHERE s = '$ticket_id' 
                  AND training_id = '$training_id'");
        } else {
            // Insert new ticket
            mysqli_query($con, "INSERT INTO {$siteprefix}training_tickets 
                (training_id, ticket_name, benefits, price, seats, seatremain) 
                VALUES ('$training_id', '$name', '$benefits', '$price', '$seats', '$seats')");
        }
    }
}


// Handle Promo Video
$promo_video = $_FILES['promo_video']['name'];
if (!empty($promo_video)) {
    $fileKey = 'promo_video';
    $fileName = uniqid() . '_' . basename($promo_video);
    $logopromo_video = handleFileUpload($fileKey, $uploadDir);

    // Check if promo video exists for this training_id
    $checkPromo = mysqli_query($con, "SELECT s FROM {$siteprefix}training_videos WHERE training_id = '$training_id' AND video_type = 'promo'");
    
    if (mysqli_num_rows($checkPromo) > 0) {
        // Update existing promo
        mysqli_query($con, "UPDATE {$siteprefix}training_videos SET video_path = '$logopromo_video', updated_at = NOW() WHERE training_id = '$training_id' AND video_type = 'promo'");
    } else {
        // Insert new promo
        mysqli_query($con, "INSERT INTO {$siteprefix}training_videos (training_id, video_type, video_path, updated_at) VALUES ('$training_id', 'promo', '$logopromo_video', NOW())");
    }
}

// Handle Trailer Video
$trailer_video = $_FILES['trailer_video']['name'];
if (!empty($trailer_video)) {
    $fileKey = 'trailer_video';
    $fileName = uniqid() . '_' . basename($trailer_video);
    $logotrailer_video = handleFileUpload($fileKey, $fileuploadDir);

    // Check if trailer video exists for this training_id
    $checkTrailer = mysqli_query($con, "SELECT s FROM {$siteprefix}training_videos WHERE training_id = '$training_id' AND video_type = 'trailer'");
    
    if (mysqli_num_rows($checkTrailer) > 0) {
        // Update existing trailer
        mysqli_query($con, "UPDATE {$siteprefix}training_videos SET video_path = '$logotrailer_video', updated_at = NOW() WHERE training_id = '$training_id' AND video_type = 'trailer'");
    } else {
        // Insert new trailer
        mysqli_query($con, "INSERT INTO {$siteprefix}training_videos (training_id, video_type, video_path, updated_at) VALUES ('$training_id', 'trailer', '$logotrailer_video', NOW())");
    }
}

  // Handle Instructor
$instructor_id = $_POST['instructor'];

if ($instructor_id === 'add_new') {
    $new_name = mysqli_real_escape_string($con, $_POST['new_instructor_name']);
    $new_bio = mysqli_real_escape_string($con, $_POST['new_instructor_bio']);
    $new_email = mysqli_real_escape_string($con, $_POST['new_instructor_email']);
    $adduser = mysqli_real_escape_string($con, $_POST['user_id']);
    $instructor_photo = ''; // initialize photo filename
    $photo_path = '';       // full path for saving file

    if (!empty($_FILES['new_instructor_photo']['name'])) {
        $originalName = basename($_FILES['new_instructor_photo']['name']);
        $uniqueFileName = uniqid() . '_' . $originalName;
        $photo_path = $uploadDir . $uniqueFileName;

        if (move_uploaded_file($_FILES['new_instructor_photo']['tmp_name'], $photo_path)) {
            $instructor_photo = $uniqueFileName;
        }
    }

    mysqli_query($con, "INSERT INTO {$siteprefix}instructors (name, email_address, bio, photo, user) 
                        VALUES ('$new_name', '$new_email', '$new_bio', '$instructor_photo','$adduser')");

    $instructor_id = mysqli_insert_id($con);
}

  
//delivery format handling
    if ($delivery_format === 'physical') {
    if ($_POST['physicalLocationType'] === 'nigeria') {
        $physical_address = mysqli_real_escape_string($con, $_POST['nigeria_address']);
        $physical_state = mysqli_real_escape_string($con, $_POST['state']);
        $physical_lga = mysqli_real_escape_string($con, $_POST['lga']);
        $physical_country = 'Nigeria';
    } elseif ($_POST['physicalLocationType'] === 'foreign') {
        $foreign_address = mysqli_real_escape_string($con, $_POST['foreign_address']);
    }

    } elseif ($delivery_format === 'online') {
    $web_address = mysqli_real_escape_string($con, $_POST['web_address']);
} elseif ($delivery_format === 'hybrid') {
    $hybrid_physical_address = mysqli_real_escape_string($con, $_POST['hybrid_physical_address']);
    $hybrid_web_address = mysqli_real_escape_string($con, $_POST['hybrid_web_address']);
    if ($_POST['hybridLocationType'] === 'nigeria') {
        $hybrid_state = mysqli_real_escape_string($con, $_POST['hybrid_state']);
        $hybrid_lga = mysqli_real_escape_string($con, $_POST['hybrid_lga']);
        $hybrid_country = 'Nigeria';
    } elseif ($_POST['hybridLocationType'] === 'foreign') {
        $hybrid_foreign_address = mysqli_real_escape_string($con, $_POST['hybrid_foreign_address']);
    }
}


// UPDATE existing training
    $updateTraining = mysqli_query($con, "
        UPDATE {$siteprefix}training SET
            title = '$title',
            description = '$description',
            attendee = '$attendee',
            Language = '$language',
            certification = '$certification',
            level = '$level',
            delivery_format = '$delivery_format',
            physical_address = '$physical_address',
            physical_state = '$physical_state',
            physical_lga = '$physical_lga',
            physical_country = '$physical_country',
            foreign_address = '$foreign_address',
            web_address = '$web_address',
            hybrid_physical_address = '$hybrid_physical_address',
            hybrid_web_address = '$hybrid_web_address',
            hybrid_state = '$hybrid_state',
            hybrid_lga = '$hybrid_lga',
            hybrid_country = '$hybrid_country',
            hybrid_foreign_address = '$hybrid_foreign_address',
            course_description = '$course_description',
            learning_objectives = '$learning_objectives',
            target_audience = '$target_audience',
            course_requirrement = '$prerequisites',
            event_type = '$event_type',
            pricing = '$pricing',
            category = '$category',
            subcategory = '$subcategory',
            instructors = '$instructor_id',
            additional_notes = '$additional_notes',
            tags = '$tags',
            status = '$status',
            loyalty = '$loyalty',
            user = '$user'
        WHERE training_id = '$training_id'");
if ($updateTraining) {
    $statusAction = "Success!";
    $statusMessage = "Training updated successfully.";
    showSuccessModal2($statusAction, $statusMessage);

    header("refresh:2; url=training.php"); // ✅ Change to the desired redirect page

} else {
    $statusAction = "Error!";
    $statusMessage = "Failed to update training. Please try again.";
    showErrorModal2($statusAction, $statusMessage);

    header("refresh:2; url=training.php"); // ✅ Optional: change this to a retry page
  
}

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_event'])) {

        // Directories for uploads
    $uploadDir = '../../uploads/';
    $fileuploadDir = '../../documents/';
   
    $message = "";
    $physical_address = $physical_state = $physical_lga = $physical_country = $foreign_address = '';
    $web_address = '';
    $hybrid_physical_address = $hybrid_web_address = $hybrid_state = $hybrid_lga = $hybrid_country = $hybrid_foreign_address = '';
    $status = $_POST['status'];
    $trainingId = mysqli_real_escape_string($con, $_POST['id']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    // Main category (Tier 1)
        $category = !empty($_POST['category']) ? implode(',', $_POST['category']) : '';

        // Collect subcategories (Tiers 2+)
        $allSubs = [];

        if (!empty($_POST['subcategory'])) {
            $allSubs = array_merge($allSubs, $_POST['subcategory']);
        }
        if (!empty($_POST['subsubcategory'])) {
            $allSubs = array_merge($allSubs, $_POST['subsubcategory']);
        }
        if (!empty($_POST['subsubsubcategory'])) {
            $allSubs = array_merge($allSubs, $_POST['subsubsubcategory']);
        }

        $allSubs = array_unique($allSubs); // remove duplicates
        $subcategory = implode(',', $allSubs);
    $event_type = mysqli_real_escape_string($con, $_POST['event_type']);
    $attendee = mysqli_real_escape_string($con, $_POST['who_should_attend']);
    $loyalty = isset($_POST['loyalty']) ? 1 : 0;
    $user = mysqli_real_escape_string($con, $_POST['user']);
    $training_id = mysqli_real_escape_string($con, $_POST['id']);
    $language = mysqli_real_escape_string($con, $_POST['language']);
    $certification = mysqli_real_escape_string($con, $_POST['certification']);
    $course_description = mysqli_real_escape_string($con, $_POST['course_description']);
    $level = mysqli_real_escape_string($con, $_POST['level']);
     $tags = mysqli_real_escape_string($con, $_POST['tags']);
    $learning_objectives = mysqli_real_escape_string($con, $_POST['learning_objectives']);
    $target_audience = mysqli_real_escape_string($con, $_POST['target_audience']);
    $prerequisites = mysqli_real_escape_string($con, $_POST['prerequisites']);
    $additional_notes = mysqli_real_escape_string($con, $_POST['additional_notes']);
    $delivery_format = mysqli_real_escape_string($con, $_POST['delivery_format']);
    $video_embed_url = mysqli_real_escape_string($con, $_POST['video_embed_url']);
    $pricing = mysqli_real_escape_string($con, $_POST['pricing']);
       // 4. Handle Quiz/Assignment
     $quiz_method = $_POST['quiz_method'];

    if(isset($_POST['video_embed_url']) && !empty($_POST['video_embed_url'])) {
    $trailer_video_path = mysqli_real_escape_string($con, $_POST['video_embed_url']);
    $stmt = $con->prepare(
    "INSERT INTO {$siteprefix}training_video_lessons (training_id, file_path, video_url, updated_at) VALUES (?, ?, ?, NOW())"
);
$empty = '';
$stmt->bind_param("sss", $training_id, $empty, $trailer_video_path);
        if (!$stmt->execute()) {
            $message .= "Error inserting file: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }

    // Replace spaces with hyphens and convert to lowercase
$baseSlug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $title), '-'));

// Start with the cleaned slug
$alt_title = $baseSlug;
$counter = 1;

// Ensure the alt_title is unique
while (true) {
    $query = "SELECT COUNT(*) AS count FROM " . $siteprefix . "training WHERE alt_title = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $alt_title);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] == 0) {
        break; // alt_title is unique
    }

    // Append counter to baseSlug if not unique
    $alt_title = $baseSlug . '-' . $counter;
    $counter++;
}

if ($status === 'approved') {
    // Query to get users following the category
$categories = explode(',', $category); // Convert comma-separated string back to array

foreach ($categories as $catId) {
    $catId = trim($catId);

    // Query to get users following this category
    $categoryFollowersQuery = "SELECT user_id FROM " . $siteprefix . "followers WHERE category_id = '$catId'";
    $categoryFollowersResult = mysqli_query($con, $categoryFollowersQuery);

    if ($categoryFollowersResult && mysqli_num_rows($categoryFollowersResult) > 0) {
        // Fetch category name for the email
        $categoryQuery = "SELECT * FROM " . $siteprefix . "categories WHERE id = '$catId'";
        $categoryResult = mysqli_query($con, $categoryQuery);
        $categoryRow = mysqli_fetch_assoc($categoryResult);
        $categoryName = $categoryRow['category_name'];
        $slugs = $categoryRow['slug'];

        // Notify all users following this category
        while ($follower = mysqli_fetch_assoc($categoryFollowersResult)) {
            $followerId = $follower['user_id'];

            // Fetch follower details
            $followerDetailsQuery = "SELECT email_address, display_name FROM " . $siteprefix . "users WHERE s = '$followerId'";
            $followerDetailsResult = mysqli_query($con, $followerDetailsQuery);
            $followerDetails = mysqli_fetch_assoc($followerDetailsResult);

            $followerEmail = $followerDetails['email_address'];
            $followerName = $followerDetails['display_name'];

            // Prepare the email
            $emailSubject = "New event in $categoryName";
        $emailMessage = "
    <p>We are excited to inform you that a new eventl titled <strong>{$title}</strong> has been added to the <strong>{$categoryName}</strong> category.</p>
    <p>You can check it out here: <a href=\"{$siteurl}category/{$slugs}\" target=\"_blank\">{$categoryName}</a></p>
    <p>Thank you for following the <strong>{$categoryName}</strong> category!</p>
";


            // Send the email
            sendEmail($followerEmail, $followerName, $siteName, $siteMail, $emailMessage, $emailSubject);

            // Notify user
            insertAlert($con, $followerId, "New resource titled $title under category $categoryName has been posted", $currentdatetime, 0);
        }
    }
}

}

    $promo_video = $_FILES['promo_video']['name'];
    if (!empty($promo_video)) { 
        $fileKey = 'promo_video';
        $fileName = uniqid() . '_' . basename($promo_video);
        $logopromo_video = handleFileUpload($fileKey, $uploadDir);
        $insertQuery=mysqli_query($con, "INSERT INTO {$siteprefix}training_videos (training_id, video_type, video_path, updated_at) VALUES ('$training_id', 'promo', '$logopromo_video', NOW())");
    } 
    $trailer_video = $_FILES['trailer_video']['name'];
    if (!empty($trailer_video)) {
        $fileKey = 'trailer_video';
        $fileName = uniqid() . '_' . basename($trailer_video);
        $logotrailer_video = handleFileUpload($fileKey, $fileuploadDir);
        $insertQuery=mysqli_query($con, "INSERT INTO {$siteprefix}training_videos (training_id, video_type, video_path, updated_at) VALUES ('$training_id', 'trailer', '$logotrailer_video', NOW())");
    } 

    if (!empty($_FILES['video_lessons']['name'])) {
        $fileKey = 'video_lessons';
        $videoFiles = handleMultipleFileUpload($fileKey, $fileuploadDir);

    foreach ($videoFiles as $file) {
        $stmt = $con->prepare(
            "INSERT INTO {$siteprefix}training_video_lessons (training_id, file_path, video_url, updated_at) VALUES (?, ?, '', NOW())"
        );
        $stmt->bind_param("ss", $training_id, $file);
        if (!$stmt->execute()) {
            $message .= "Error inserting file: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }
    }

    if (!empty($_FILES['text_modules']['name'][0])) {
    $fileKey = 'text_modules';
    $textFiles = handleMultipleFileUpload($fileKey, $fileuploadDir);

    foreach ($textFiles as $file) {
        $stmt = $con->prepare(
            "INSERT INTO {$siteprefix}training_text_modules (training_id, file_path, updated_at) VALUES (?, ?, NOW())"
        );
        $stmt->bind_param("ss", $training_id, $file);
        if (!$stmt->execute()) {
            $message .= "Error inserting text module: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }
}

  

if ($quiz_method === 'text') {
    $text_content = mysqli_real_escape_string($con, $_POST['quiz_text']);
   mysqli_query(
    $con,
    "INSERT INTO {$siteprefix}training_quizzes (training_id, type, file_path, text_path, instructions, updated_at) VALUES ('$training_id', 'text', '', '$text_content', '', NOW())"
);
} elseif ($quiz_method === 'upload' && !empty($_FILES['quiz_files']['name'][0])) {
    $fileKey = 'quiz_files';
    $quizfiles = handleMultipleFileUpload($fileKey, $fileuploadDir);

    foreach ($quizfiles as $file) {
        $stmt = $con->prepare(
            "INSERT INTO {$siteprefix}training_quizzes (training_id, type, file_path, text_path, instructions, updated_at) VALUES (?, 'upload', ?, '', '', NOW())"
        );
        $stmt->bind_param("ss", $training_id, $file);
        if (!$stmt->execute()) {
            $message .= "Error inserting file: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }
}

elseif ($quiz_method === 'form' && !empty($_POST['questions'])) {
    $quiz_instructions = isset($_POST['quiz_instructions']) 
        ? mysqli_real_escape_string($con, $_POST['quiz_instructions']) 
        : '';

    // Insert the quiz meta row
    $stmt = $con->prepare(
        "INSERT INTO {$siteprefix}training_quizzes (training_id, type, file_path, text_path, instructions, updated_at) VALUES (?, 'form', '', '', ?, NOW())"
    );
    $stmt->bind_param("ss", $training_id, $quiz_instructions);
    $stmt->execute();
    $quiz_id = $stmt->insert_id;
    $stmt->close();

    // Insert each question/answer into training_quiz_questions
    foreach ($_POST['questions'] as $i => $question) {
        $q = mysqli_real_escape_string($con, $question ?? '');
        $a = mysqli_real_escape_string($con, $_POST['option_a'][$i] ?? '');
        $b = mysqli_real_escape_string($con, $_POST['option_b'][$i] ?? '');
        $c = mysqli_real_escape_string($con, $_POST['option_c'][$i] ?? '');
        $d = mysqli_real_escape_string($con, $_POST['option_d'][$i] ?? '');
        $correct = mysqli_real_escape_string($con, $_POST['correct_answer'][$i] ?? '');

        mysqli_query(
            $con,
            "INSERT INTO {$siteprefix}training_quiz_questions (quiz_id, question, option_a, option_b, option_c, option_d, correct_answer)
             VALUES ('$quiz_id', '$q', '$a', '$b', '$c', '$d', '$correct')"
        );
    }
}

if ($delivery_format === 'video' || $delivery_format === 'video_text') {
    foreach ($_POST['video_module_title'] as $index => $titless) {
        $desc        = $_POST['video_module_desc'][$index] ?? '';
        $duration    = $_POST['video_duration'][$index] ?? '';
        $videoLink   = $_POST['video_link'][$index] ?? '';
        $qualities   = isset($_POST['video_quality'][$index]) ? implode(',', $_POST['video_quality'][$index]) : '';
        $subtitles   = $_POST['video_subtitles'][$index] ?? '';

        $filePath = '';
        if (!empty($_FILES['video_file']['name'][$index])) {
            $tmpFileKey = 'single_video_upload';
            $_FILES[$tmpFileKey] = [
                'name'     => $_FILES['video_file']['name'][$index],
                'type'     => $_FILES['video_file']['type'][$index],
                'tmp_name' => $_FILES['video_file']['tmp_name'][$index],
                'error'    => $_FILES['video_file']['error'][$index],
                'size'     => $_FILES['video_file']['size'][$index]
            ];

            $fileName = handleFileUpload($tmpFileKey, $fileuploadDir);
            if ($fileName && strpos($fileName, 'Failed') === false && strpos($fileName, 'error') === false) {
                $filePath = $fileName;
            }
        }

        $stmt = $con->prepare("
            INSERT INTO {$siteprefix}training_video_modules
            (training_id, module_number, title, description, duration, file_path, video_link, video_quality, subtitles, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        $module_number = $index + 1;
        $stmt->bind_param("sisssssss", $training_id, $module_number, $titless, $desc, $duration, $filePath, $videoLink, $qualities, $subtitles);
        $stmt->execute();
        $stmt->close();
    }
}

if ($delivery_format === 'text' || $delivery_format === 'video_text') {
    foreach ($_POST['text_module_title'] as $index => $tit) {
        $desc        = $_POST['text_module_desc'][$index] ?? '';
        $readingTime = $_POST['text_reading_time'][$index] ?? '';

        $filePath = '';
        if (!empty($_FILES['text_file']['name'][$index])) {
            $tmpFileKey = 'single_text_upload';
            $_FILES[$tmpFileKey] = [
                'name'     => $_FILES['text_file']['name'][$index],
                'type'     => $_FILES['text_file']['type'][$index],
                'tmp_name' => $_FILES['text_file']['tmp_name'][$index],
                'error'    => $_FILES['text_file']['error'][$index],
                'size'     => $_FILES['text_file']['size'][$index]
            ];

            $fileName = handleFileUpload($tmpFileKey, $fileuploadDir);
            if ($fileName && strpos($fileName, 'Failed') === false && strpos($fileName, 'error') === false) {
                $filePath = $fileName;
            }
        }

        $stmt = $con->prepare("
            INSERT INTO {$siteprefix}training_texts_modules
            (training_id, module_number, title, description, reading_time, file_path, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        $module_number = $index + 1;
        $stmt->bind_param("sissss", $training_id, $module_number, $tit, $desc, $readingTime, $filePath);
        $stmt->execute();
        $stmt->close();
    }
}


        if ($_POST['pricing'] === 'paid') {
       $ticket_names = $_POST['ticket_name'];
$ticket_benefits = $_POST['ticket_benefits'];
$ticket_prices = $_POST['ticket_price'];
$ticket_seats = $_POST['ticket_seats'];

foreach ($ticket_names as $index => $name) {
    $name = mysqli_real_escape_string($con, $name);
    $benefits = mysqli_real_escape_string($con, $ticket_benefits[$index]);
    $price = floatval($ticket_prices[$index]);
    $seats = intval($ticket_seats[$index]);

    // Insert into database
    mysqli_query($con, "INSERT INTO " . $siteprefix . "training_tickets 
        (training_id, ticket_name, benefits, price, seats, seatremain)
        VALUES ('$training_id', '$name', '$benefits', '$price', '$seats', '$seats')");
}

    }

        //  Handle Instructor
  // Handle Instructor
$instructor_id = $_POST['instructor'];

if ($instructor_id === 'add_new') {
    $new_name = mysqli_real_escape_string($con, $_POST['new_instructor_name']);
    $new_bio = mysqli_real_escape_string($con, $_POST['new_instructor_bio']);
    $new_email = mysqli_real_escape_string($con, $_POST['new_instructor_email']);
    $adduser = mysqli_real_escape_string($con, $_POST['user_id']);
    $instructor_photo = ''; // initialize photo filename
    $photo_path = '';       // full path for saving file

    if (!empty($_FILES['new_instructor_photo']['name'])) {
        $originalName = basename($_FILES['new_instructor_photo']['name']);
        $uniqueFileName = uniqid() . '_' . $originalName;
        $photo_path = $uploadDir . $uniqueFileName;

        if (move_uploaded_file($_FILES['new_instructor_photo']['tmp_name'], $photo_path)) {
            $instructor_photo = $uniqueFileName;
        }
    }

    mysqli_query($con, "INSERT INTO {$siteprefix}instructors (name, email_address, bio, photo, user) 
                        VALUES ('$new_name', '$new_email', '$new_bio', '$instructor_photo','$adduser')");

    $instructor_id = mysqli_insert_id($con);
}


  
//delivery format handling
    if ($delivery_format === 'physical') {
    if ($_POST['physicalLocationType'] === 'nigeria') {
        $physical_address = mysqli_real_escape_string($con, $_POST['nigeria_address']);
        $physical_state = mysqli_real_escape_string($con, $_POST['state']);
        $physical_lga = mysqli_real_escape_string($con, $_POST['lga']);
        $physical_country = 'Nigeria';
    } elseif ($_POST['physicalLocationType'] === 'foreign') {
        $foreign_address = mysqli_real_escape_string($con, $_POST['foreign_address']);
    }

    } elseif ($delivery_format === 'online') {
    $web_address = mysqli_real_escape_string($con, $_POST['web_address']);
} elseif ($delivery_format === 'hybrid') {
    $hybrid_physical_address = mysqli_real_escape_string($con, $_POST['hybrid_physical_address']);
    $hybrid_web_address = mysqli_real_escape_string($con, $_POST['hybrid_web_address']);
    if ($_POST['hybridLocationType'] === 'nigeria') {
        $hybrid_state = mysqli_real_escape_string($con, $_POST['hybrid_state']);
        $hybrid_lga = mysqli_real_escape_string($con, $_POST['hybrid_lga']);
        $hybrid_country = 'Nigeria';
    } elseif ($_POST['hybridLocationType'] === 'foreign') {
        $hybrid_foreign_address = mysqli_real_escape_string($con, $_POST['hybrid_foreign_address']);
    }
}
    // Insert event dates & times
    if (!empty($_POST['event_dates'])) {
        foreach ($_POST['event_dates'] as $i => $date) {
            $event_date = mysqli_real_escape_string($con, $date);
            $start_time = mysqli_real_escape_string($con, $_POST['event_start_times'][$i]);
            $end_time = mysqli_real_escape_string($con, $_POST['event_end_times'][$i]);
            mysqli_query(
                $con,
                "INSERT INTO " . $siteprefix . "training_event_dates (training_id, event_date, start_time, end_time)
                VALUES ('$training_id', '$event_date', '$start_time', '$end_time')"
            );
        }
    }

  $fileKeys = 'images';
  // Handle image uploads
    if (empty($_FILES[$fileKeys]['name'][0])) {
        // Use default images if no images are uploaded
        $defaultImages = ['default1.jpg', 'default2.jpg', 'default3.jpg', 'default4.jpg', 'default5.jpg'];
        $randomImage = $defaultImages[array_rand($defaultImages)];
        $reportImages = [$randomImage];
    }else{

    // Insert images into the database
    $reportImages = handleMultipleFileUpload($fileKeys, $uploadDir);
    }

    $uploadedFiles = [];
    foreach ($reportImages as $image) {
        $stmt = $con->prepare("INSERT INTO " . $siteprefix . "training_images (training_id, picture, updated_at) VALUES (?, ?, current_timestamp())");
        $stmt->bind_param("ss", $training_id, $image);
        if ($stmt->execute()) {
            $uploadedFiles[] = $image;
        } else {
            $message .= "Error inserting image: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }

 

    $insertTraining = mysqli_query($con, "INSERT INTO {$siteprefix}training (
        training_id, title, description, attendee, Language, certification, level, delivery_format,
        physical_address, physical_state, physical_lga, physical_country, foreign_address, web_address,
        hybrid_physical_address, hybrid_web_address, hybrid_state, hybrid_lga, hybrid_country, hybrid_foreign_address,
        course_description, learning_objectives, target_audience, course_requirrement, event_type,
        pricing, category, subcategory, instructors, additional_notes, tags, quiz_method, created_at,alt_title,status,loyalty,user
    ) VALUES (
        '$training_id', '$title', '$description', '$attendee', '$language', '$certification', '$level', '$delivery_format',
        '$physical_address', '$physical_state', '$physical_lga', '$physical_country', '$foreign_address', '$web_address',
        '$hybrid_physical_address', '$hybrid_web_address', '$hybrid_state', '$hybrid_lga', '$hybrid_country', '$hybrid_foreign_address',
        '$course_description', '$learning_objectives', '$target_audience', '$prerequisites','$event_type',
        '$pricing', '$category', '$subcategory', '$instructor_id', '$additional_notes', '$tags', '$quiz_method', NOW(), '$alt_title', '$status', '$loyalty', '$user'
    )");

if ($insertTraining) {
     $message .= "Training added successfully!";
            showSuccessModal('Processed', $message);
            header("refresh:2; url=add-training.php");
} else {
    $message .= "Error adding report: " . mysqli_error($con);
            showErrorModal('Update Failed', $message);
            header("refresh:2;");
}


}


// add plan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addPlan'])) {
    // Sanitize inputs
    $planName = mysqli_real_escape_string($con, $_POST['planName']);
    $planPrice = mysqli_real_escape_string($con, $_POST['planPrice']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $discount = mysqli_real_escape_string($con, $_POST['discount']);
    $downloads = mysqli_real_escape_string($con, $_POST['downloads']);
    $durationCount = mysqli_real_escape_string($con, $_POST['durationCount']);
    $planDuration = mysqli_real_escape_string($con, $_POST['planDuration']);
    $planStatus = mysqli_real_escape_string($con, $_POST['planStatus']);
    $benefits = isset($_POST['benefits']) ? mysqli_real_escape_string($con, implode(", ", $_POST['benefits'])) : '';

    // File upload settings
    $uploadDir = '../../uploads/';
    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
    $fileKey = 'planImage';
    $uploadedImage = '';
    $message = "";

    if (!empty($_FILES[$fileKey]['name'])) {
        $fileType = mime_content_type($_FILES[$fileKey]['tmp_name']);
        if (in_array($fileType, $allowedImageTypes)) {
            $fileBaseName = basename($_FILES[$fileKey]['name']);
            $fileBaseName = preg_replace("/[^a-zA-Z0-9\._-]/", "", $fileBaseName);
            $fileName = uniqid() . '_' . $fileBaseName;
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $filePath)) {
                $uploadedImage = $fileName;
            } else {
                $message .= "Error uploading image.<br>";
            }
        } else {
            $message .= "Invalid file type (Only JPG, PNG, GIF, WEBP allowed).<br>";
        }
    }

    // Fallback image if none uploaded
    if (empty($uploadedImage)) {
        $defaultImages = ['default1.jpg', 'default2.jpg', 'default3.jpg'];
        $uploadedImage = array_rand(array_flip($defaultImages));
    }

    // Build the SQL query
    $sql = "INSERT INTO " . $siteprefix . "subscription_plans 
            (name, price, description, discount, downloads, duration, no_of_duration, status, benefits, image, created_at) 
            VALUES (
                '$planName', 
                '$planPrice', 
                '$description', 
                '$discount', 
                '$downloads', 
                '$planDuration', 
                '$durationCount', 
                '$planStatus', 
                '$benefits', 
                '$uploadedImage', 
                current_timestamp()
            )";

    // Execute and handle result
    if (mysqli_query($con, $sql)) {
        $message .= "Subscription plan added successfully!";
    } else {
        $message .= "Error: " . mysqli_error($con);
    }

    // Show success modal and redirect
    showSuccessModal('Processed', $message);
    header("refresh:2; url=add-plan.php");
    
}


// Approve payment
// Approve payment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['approve_payment'])) {

    $order_id = mysqli_real_escape_string($con, $_POST['order_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);
    $date = date('Y-m-d H:i:s');
     $fileuploadDir = '../../documents';

    $attachments = [];

    // Approve manual payment
    $update_query = "UPDATE {$siteprefix}manual_payments 
                     SET status = 'approved', rejection_reason = '' 
                     WHERE order_id = '$order_id'";
    if (!mysqli_query($con, $update_query)) {
        showErrorModal('Oops', "Error updating payment status.");
        exit;
    }

    // Update order status
    $updates_query = "UPDATE {$siteprefix}orders 
                      SET status = 'paid', total_amount = '$amount', date = '$date' 
                      WHERE order_id = '$order_id'";
    if (!mysqli_query($con, $updates_query)) {
        showErrorModal('Oops', "Error updating order status: " . mysqli_error($con));
        exit;
    }

    // Fetch buyer details
    $buyer_result = mysqli_query($con, "SELECT email_address, display_name FROM {$siteprefix}users WHERE s = '$user_id'");
    $buyer = mysqli_fetch_assoc($buyer_result);
    $email = $buyer['email_address'];
    $username = $buyer['display_name'];

    // Fetch order items
    $items_result = mysqli_query($con, "SELECT oi.*, t.title as resource_title
        FROM {$siteprefix}order_items oi
        JOIN {$siteprefix}training t ON oi.training_id = t.training_id
        WHERE oi.order_id = '$order_id'");

    while ($item = mysqli_fetch_assoc($items_result)) {
        $s = $item['s'];
        $training_id = $item['training_id'];
        $price = $item['price'];
        $original_price = $item['original_price'];
        $loyalty_id = $item['loyalty_id'];
        $affiliate_id = $item['affiliate_id'];
        $item_row_id = $item['id'] ?? 0;
        $order_id = $item['order_id'];
        $date = $item['date'];
        $resourceTitle = $item['resource_title'];

        // Handle affiliate
        if ($affiliate_id != 0) {
            // Set your affiliate percentage here
            $aff_result = mysqli_query($con, "SELECT * FROM {$siteprefix}users WHERE affliate = '$affiliate_id'");
            while ($row_aff = mysqli_fetch_assoc($aff_result)) {
                $affiliate_user_id = $row_aff['s'];
                $affiliate_amount = $price * ($affiliate_percentage / 100);

                mysqli_query($con, "UPDATE {$siteprefix}users SET wallet = wallet + $affiliate_amount WHERE affliate = '$affiliate_id'");
                insertAffliatePurchase($con, $item_row_id, $affiliate_amount, $affiliate_id, $date);
                insertWallet($con, $affiliate_user_id, $affiliate_amount, 'credit', "Affiliate Earnings from Order ID: $order_id", $date);
                insertaffiliateAlert($con, $affiliate_user_id, "You have earned $sitecurrency$affiliate_amount from Order ID: $order_id", "wallet.php", $date, "wallet", 0);
            }
        }

        // Get seller ID
        $sql_seller = "SELECT u.s AS user, u.* FROM {$siteprefix}users u 
                       LEFT JOIN {$siteprefix}training t ON t.user=u.s 
                       WHERE t.training_id = '$training_id'";
        $sql_seller_result = mysqli_query($con, $sql_seller);
        if (mysqli_num_rows($sql_seller_result) > 0) {
            while ($row_seller = mysqli_fetch_array($sql_seller_result)) {
                $seller_id = $row_seller['user'];
                $vendorEmail = $row_seller['email_address'];
                $vendorName = $row_seller['display_name'];
                $sellertype = $row_seller['type'];
                $admin_commission = 0;
                $seller_amount = 0;

                 $admin_commission = ($sellertype === "user") ? $price * ($escrowfee / 100) : $price;
            $seller_amount = $price - $admin_commission;
                // Insert admin commission
                $sql_insert_commission = "INSERT INTO {$siteprefix}profits (amount, training_id, order_id, type, date) 
                                          VALUES ('$admin_commission', '$training_id', '$order_id', 'Order Payment', '$date')";
                mysqli_query($con, $sql_insert_commission);
                insertadminAlert($con, "Admin Commission of $sitecurrency$admin_commission from Order ID: $order_id", "profits.php", $date, "profits", 0);

                // Credit seller
                mysqli_query($con, "UPDATE {$siteprefix}users SET wallet = wallet + $seller_amount WHERE s = '$seller_id'");
                insertWallet($con, $seller_id, $seller_amount, 'credit', "Payment from Order ID: $order_id", $date);
                insertAlert($con, $seller_id, "You have received $sitecurrency$seller_amount from Order ID: $order_id", $date, 0);

                // Send email to seller
                $emailSubject = "New Sale on Project Report Hub. Let's Keep the Momentum Going!";
                $emailMessage = "
                    <p>Great news! A new sale has just been made on $siteurl.</p>
                    <p><strong>Title of Resource:</strong> $resourceTitle</p>
                    <p><strong>Price:</strong> $sitecurrencyCode.$price</p>
                    <p><strong>Earning:</strong> $sitecurrencyCode.$seller_amount</p>
                    <p>If you haven’t updated your listings recently, now is a great time to refresh, promote, or add more resources.</p>";
                sendEmail($vendorEmail, $vendorName, $siteName, $siteMail, $emailMessage, $emailSubject);
            }
        }
    }
// Send confirmation email to buyer
$subject = "Your Training Registration Details";

$sql_items = "SELECT 
                oi.*, 
                t.*, 
                GROUP_CONCAT(
                    DISTINCT CONCAT(
                        DATE_FORMAT(tem.event_date, '%b %d, %Y'),
                        ' (',
                        DATE_FORMAT(tem.start_time, '%h:%i %p'),
                        ' – ',
                        DATE_FORMAT(tem.end_time, '%h:%i %p'),
                        ')'
                    )
                    ORDER BY tem.event_date SEPARATOR ', '
                ) AS event_datetime,
                tt.ticket_name
              FROM {$siteprefix}order_items oi
              JOIN {$siteprefix}training t 
                   ON oi.training_id = t.training_id
              LEFT JOIN {$siteprefix}training_event_dates tem 
                   ON t.training_id = tem.training_id
              LEFT JOIN {$siteprefix}training_tickets tt 
                   ON oi.item_id = tt.s   
              WHERE oi.order_id = '$order_id'
              GROUP BY oi.item_id";

$sql_items_result = mysqli_query($con, $sql_items);

$emailDetails = [];
$attachments  = []; // collect all files here

while ($row = mysqli_fetch_assoc($sql_items_result)) {
    // Dates / times (already grouped by SQL)
   $date_time_str = $row['event_datetime'] ?? '';


    // Delivery format details
    $format  = ucfirst($row['delivery_format']);
    $details = '';
    $fields  = [];

    if ($format === 'Physical') {
        $fields = [
            'physical_address' => 'Address',
            'physical_state'   => 'State',
            'physical_lga'     => 'LGA',
            'physical_country' => 'Country',
            'foreign_address'  => 'Foreign Address'
        ];
    } elseif ($format === 'Hybrid') {
        $fields = [
            'hybrid_physical_address' => 'Physical Address',
            'hybrid_web_address'      => 'Web Address',
            'hybrid_state'            => 'State',
            'hybrid_lga'              => 'LGA',
            'hybrid_country'          => 'Country',
            'hybrid_foreign_address'  => 'Foreign Address'
        ];
    } elseif ($format === 'Online' && !empty($row['web_address'])) {
        $details .= "<li><strong>Link to join:</strong> <a href='" . htmlspecialchars($row['web_address']) . "'>" . htmlspecialchars($row['web_address']) . "</a></li>";
    }

    if (!empty($fields)) {
        foreach ($fields as $col => $label) {
            if (!empty($row[$col])) {
                $details .= "<li><strong>$label:</strong> " . htmlspecialchars($row[$col]) . "</li>";
            }
        }
    }

    // 👉 Attachments for Text/Video trainings
    $training_id = $row['training_id'];

    if ($format === 'Text' || $format === 'Video' || $format === 'Video_text') {
        $details .= "<li><strong>Training Materials:</strong> (attached to this email)</li>";

        // Video modules
        if ($format === 'Video' || $format === 'Video_text') {
            $video_sql = "SELECT file_path FROM {$siteprefix}training_video_modules WHERE training_id='$training_id'";
            $video_res = mysqli_query($con, $video_sql);
            while ($vm = mysqli_fetch_assoc($video_res)) {
                if (!empty($vm['file_path'])) {
                    $filePath = $fileuploadDir . "/" . $vm['file_path'];
                    if (file_exists($filePath)) {
                        $attachments[] = $filePath;
                    }
                }
            }
        }

        // Text modules
        if ($format === 'Text' || $format === 'Video_text') {
            $text_sql = "SELECT file_path FROM {$siteprefix}training_texts_modules WHERE training_id='$training_id'";
            $text_res = mysqli_query($con, $text_sql);
            while ($tm = mysqli_fetch_assoc($text_res)) {
                if (!empty($tm['file_path'])) {
                    $filePath = $fileuploadDir . "/" . $tm['file_path'];
                    if (file_exists($filePath)) {
                        $attachments[] = $filePath;
                    }
                }
            }
        }
    }

    // Ticket name / price
    $ticket_name = !empty($row['ticket_name']) ? $row['ticket_name'] : 
        (($row['pricing'] === 'free') ? 'Free' : (($row['pricing'] === 'donate') ? 'Donate' : ''));
    $amount_paid = number_format($row['price'], 2);

    $emailDetails[] = [
        'training_title' => $row['title'],
        'date_time_str'  => $date_time_str,
        'format'         => $format,
        'ticket_name'    => $ticket_name,
        'amount_paid'    => $amount_paid,
        'details'        => $details
    ];
}

// Build email body
$user_first_name = explode(' ', $username)[0];
$emailMessage = "<p>Hi $user_first_name,</p><p>Thank you for registering for:</p>";

foreach ($emailDetails as $ed) {
    $emailMessage .= "<ul>
        <li>🎓 <strong>Training:</strong> {$ed['training_title']}</li>
        <li>📅 <strong>Schedule:</strong> {$ed['date_time_str']}</li>
        <li>🌍 <strong>Format:</strong> {$ed['format']}</li>
        <li>⭐️ <strong>Ticket:</strong> {$ed['ticket_name']}</li>
        <li>💰 <strong>Amount Paid:</strong> ₦{$ed['amount_paid']}</li>
    </ul>
    <p>Here’s what to expect:</p>
    <ul>
        {$ed['details']}
        <li>You’ll get a reminder 24 hours before the event.</li>
        <li>Save this email — it contains your access details.</li>
    </ul><hr>";
}

// Send email with attachments
sendEmail2($email, $username, $siteName, $siteMail, $emailMessage, $subject, $attachments);



    showSuccessModal('Processed', "Payment for Order ID $order_id has been approved successfully.");
    header("refresh:2;");
 
}


if(isset($_POST['settings'])){
    $name = $_POST['site_name'];
    $keywords = $_POST['site_keywords'];
    $url = $_POST['site_url']; 
    $description = $_POST['site_description'];
    $email = $_POST['site_mail'];
    $number = $_POST['site_number'];
    $profilePicture = $_FILES['site_logo']['name'];
    $paymenturl = $_POST['paymenturl'];
    $apikey = $_POST['apikey'];

    $site_bank= $_POST['site_bank'];
    $account_name= $_POST['account_name'];
    $account_number= $_POST['account_number'];
    $google= $_POST['google_map'];
    $com_fee= $_POST['com_fee'];
    $affiliate_percentage= $_POST['affiliate_percentage'];
    $tinymce= $_POST['tinymce'];

    $uploadDir = '../../uploads/';
    $fileKey='site_logo';
    global $fileName;

    // Update profile picture if a new one is uploaded
    if (!empty($profilePicture)) {
        $fileName = uniqid() . '_' . basename($profilePicture);
        $logo = handleFileUpload($fileKey, $uploadDir);
    } else {
        $logo = $siteimg; // Use the current picture  
    }

    $update = mysqli_query($con,"UPDATE " . $siteprefix . "site_settings SET site_name='$name',site_bank='$site_bank', account_name='$account_name', affliate_percentage='$affiliate_percentage', commision_fee='$com_fee', account_number='$account_number', google_map='$google',  site_logo='$logo',  site_keywords='$keywords', site_url='$url', site_description='$description', site_mail='$email', site_number='$number', payment_url='$paymenturl', paystack_key='$apikey', tinymce='$tinymce' WHERE s=1");
    if($update){
    $statusAction = "Successful";
    $statusMessage = "Settings Updated Successfully!";
    showSuccessModal2($statusAction, $statusMessage);
     header("refresh:2; url=settings.php");
    } else {
        $statusAction = "Oops!";
        $statusMessage = "An error has occurred!";
        showErrorModal2($statusAction, $statusMessage);
    }
}



//admin update profile
if(isset($_POST['update-profile'])){
    $fullName = htmlspecialchars($_POST['fullName']);
    $email = htmlspecialchars($_POST['email']);
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
    $retypePassword = !empty($_POST['retypePassword']) ? $_POST['retypePassword'] : null;
    $oldPassword = htmlspecialchars($_POST['oldpassword']);
    $profilePicture = $_FILES['profilePicture']['name'];

    // Validate passwords match
    if ($password && $password !== $retypePassword) {
        $message= "Passwords do not match.";
    }

    // Validate old password
    $stmt = $con->prepare("SELECT password FROM ".$siteprefix."users WHERE s = ?");
    if ($stmt === false) {
        $message = "Error preparing statement: " . $con->error;
    } else {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user === null || !checkPassword($oldPassword, $user['password'])) {
            $message = "Old password is incorrect.";
        }
    }

    $uploadDir = '../../uploads/';
    $fileKey='profilePicture';
    global $fileName;

    // Update profile picture if a new one is uploaded
    if (!empty($profilePicture)) {
        $profilePicture = handleFileUpload($fileKey, $uploadDir);
    } else {
        $profilePicture = $profile_picture; // Use the current profile picture if no new one is uploaded
    }

    // Update user information in the database
    $query = "UPDATE ".$siteprefix."users SET display_name = ?, email_address = ?, profile_photo = ?";
    $params = [$fullName, $email, $profilePicture];

    if ($password) {
        $query .= ", password = ?";
        $params[] = $password;
    }

    $query .= " WHERE s = ?";
    $params[] = $user_id;

    $stmt = $con->prepare($query);
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    if ($stmt->execute()) {
        $message= "Profile updated successfully.";
    } else {
        $message= "Error updating profile.";
    }
    showToast($message); 
    echo "<meta http-equiv='refresh' content='2'>";
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['inform_trainer'])) {

       $trainerEmail = $_POST['trainer_email'];
    $trainerName = $_POST['trainer_name'];
    $subject = $_POST['subject'];
    $message = nl2br($_POST['message']);
   sendEmail($trainerEmail, $trainerName, $siteName, $siteMail, $message, $subject);
    $statusAction = "Message Sent";
    $statusMessage = "Your message has been sent to the trainer successfully.";
    showSuccessModal2($statusAction, $statusMessage);
    header("refresh:2; url=inhouse-proposal.php");

}


// manual payment rejection
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reject_payment'])) {
    $order_id = mysqli_real_escape_string($con, $_POST['order_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $rejection_reason = mysqli_real_escape_string($con, $_POST['rejection_reason']);
    $date = date('Y-m-d H:i:s');

    // Update the payment status to "payment resend" and store the rejection reason
    $update_query = "UPDATE " . $siteprefix . "manual_payments SET status = 'payment resend', rejection_reason = '$rejection_reason'  WHERE order_id = '$order_id'";
    if (mysqli_query($con, $update_query)) {
        // Fetch user details
        $user_query = "SELECT display_name, email_address AS email FROM " . $siteprefix . "users WHERE s = '$user_id'";
        $user_result = mysqli_query($con, $user_query);

        if ($user_result && mysqli_num_rows($user_result) > 0) {
            $user = mysqli_fetch_assoc($user_result);
            $user_name = $user['display_name'];
            $user_email = $user['email'];

            // Send email to the user
            $emailSubject = "Payment Rejected for Order ID  $order_id";
            $emailMessage = "
                <p>We hope this message finds you well.</p>
                <p>Unfortunately, your payment for Order ID: <strong>$order_id</strong> has been rejected for the following reason:</p>
                <p><em>\"$rejection_reason\"</em></p>
                <p>To proceed with your order, kindly resubmit a valid payment proof at your earliest convenience.</p>
                <p>Thank you for your understanding. If you have any questions, feel free to contact our support team.</p> ";

            sendEmail($user_email, $user_name, $siteName, $siteMail, $emailMessage, $emailSubject);
        }

        // Display success message
        $message = "Payment for Order ID $order_id has been rejected successfully.";
        showToast($message); // Use showToast to display the message
        header("refresh:2;");
       
    } else {
        // Display error message
        $message = "An error occurred while rejecting the payment. Please try again.";
        showErrorModal('Oops', $message); // Use showErrorModal to display the error
        header("refresh:2;");
       
    }
}


//update plans
if (isset($_POST['updatePlan'])) {
    $plan_id = $_POST['id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = $_POST['price'];
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $discount = $_POST['discount'];
    $downloads = $_POST['downloads'];
    $duration = $_POST['planDuration'];
    $durationCount = $_POST['durationCount'];
    $status = $_POST['status'];

    // Handle benefits checkboxes
    $benefits = isset($_POST['benefits']) ? implode(", ", $_POST['benefits']) : "";

    // Image Upload Settings
    $uploadDir = '../../uploads/';
    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
    $fileKey = 'planImage';
    $uploadedImage = "";
    $message = "";

    // Check if an image is uploaded
    if (!empty($_FILES[$fileKey]['name'])) {
        $fileType = mime_content_type($_FILES[$fileKey]['tmp_name']);
        if (in_array($fileType, $allowedImageTypes)) {
            $fileName = uniqid() . '_' . basename($_FILES[$fileKey]['name']);
            $fileName = preg_replace("/[^a-zA-Z0-9\._-]/", "", $fileName); // Sanitize file name
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $filePath)) {
                $uploadedImage = $fileName;
            } else {
                $message .= "Error uploading image.<br>";
            }
        } else {
            $message .= "Invalid file type (Only JPG, PNG, GIF, WEBP allowed).<br>";
        }
    }

    // Prepare the update query
    $query = "UPDATE " . $siteprefix . "subscription_plans 
              SET name='$name', price='$price', description='$description', discount='$discount', 
                  downloads='$downloads', duration='$duration', no_of_duration='$durationCount', 
                  status='$status', benefits='$benefits'";

    // Only update the image if a new one was uploaded
    if (!empty($uploadedImage)) {
        $query .= ", image='$uploadedImage'";
    }

    $query .= " WHERE s='$plan_id'";

    // Execute the query
    if (mysqli_query($con, $query)) {
        $message = "Plan updated successfully!";
        showSuccessModal('Processed', $message);
        header("refresh:1; url=edit-plan.php");
    } else {
        $message = "Update failed: " . mysqli_error($con);
        showErrorModal('Oops', $message);
        header("refresh:2; url=edit-plan.php");
        exit;
    }
}


if(isset($_POST['approvewithdraw'])){
    $action=$_POST['approvewithdraw'];
    $therow=$_POST['therow'];
    $user=$_POST['user'];
    $date = date('Y-m-d H:i:s');
    
    $sql = "SELECT * FROM " . $siteprefix . "withdrawal WHERE s = '$therow'";
    $sql2 = mysqli_query($con, $sql);
    while ($insertedRecord = mysqli_fetch_array($sql2)) {
            $amount = $insertedRecord['amount'];
            $bank = $insertedRecord['bank'];
            $bankname = $insertedRecord['bank_name'];
            $bankno = $insertedRecord['bank_number'];
            $thedate = formatDateTime($insertedRecord['date']);
        }
        
    $sql = "SELECT * FROM  ".$siteprefix."users WHERE s='$user'";
    $result = mysqli_query($con, $sql);
    while ($insertedRecord = mysqli_fetch_array($result)) {
            $host_mail = $insertedRecord['email_address'];
            $host_name = $insertedRecord['display_name'];
            $thecurrency = $sitecurrency;
            $host_phone= $insertedRecord['phone_number'];}
            
            
    $message_status = 1;
    $siteName = $sitename;
    $siteMail = $sitemail;
    $vendorEmail = $host_mail;
    $vendorName = $host_name;
    $currency = convertHtmlEntities($thecurrency);
    
    $submit = mysqli_query($con, "UPDATE ".$siteprefix."withdrawal SET status='paid' WHERE s = '$therow'") or die('Could not connect: ' . mysqli_error($con));
    $emailSubject="Withdrawal Request Paid ($currency$amount)";
    $vendor_emailMessage="Your withdrawal requested made on $thedate for an amount of $currency$amount has been paid to your account<br> $bank | $bankno | $bankname.";
    $message = "Your withdrawal requested made on $thedate for an amount of $thecurrency$amount has been paid ";
    
    
    $statusAction="Successful";
    $statusMessage="You have successfully marked this payment as paid";   
    sendEmail($vendorEmail, $vendorName, $siteName, $siteMail, $vendor_emailMessage, $emailSubject);
    insertAlert($con, $user, $message, $date, $message_status);  
    showSuccessModal($statusAction,$statusMessage);
    header('Refresh:3; url=' . $_SERVER['REQUEST_URI']);
    
    
    }


    // Suspend user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['suspend_user'])) {
    $user_id = $_POST['user_id'];
    $duration_type = $_POST['duration_type']; // days, months, years
    $duration_value = (int)$_POST['duration_value'];
    $reason = mysqli_real_escape_string($con, $_POST['reason']);

    // Calculate the suspension end date
    $suspend_end_date = null;
    if ($duration_type === 'days') {
        $suspend_end_date = date('Y-m-d H:i:s', strtotime("+$duration_value days"));
    } elseif ($duration_type === 'months') {
        $suspend_end_date = date('Y-m-d H:i:s', strtotime("+$duration_value months"));
    } elseif ($duration_type === 'years') {
        $suspend_end_date = date('Y-m-d H:i:s', strtotime("+$duration_value years"));
    }

    // Update the user's status and suspension details
    $update_query = "UPDATE ".$siteprefix."users 
                     SET status = 'suspended' 
                     WHERE s = '$user_id'";
    if (mysqli_query($con, $update_query)) {
        // Insert suspension details into the suspend table
        $insert_query = "INSERT INTO " . $siteprefix . "suspend (user_id, suspend_date, suspend_reason, suspend_end) 
                         VALUES ('$user_id', NOW(), '$reason', '$suspend_end_date')";
        if (mysqli_query($con, $insert_query)) {
            // Fetch user details for the email
            $user_query = "SELECT email_address, display_name FROM ".$siteprefix."users WHERE s = '$user_id'";
            $user_result = mysqli_query($con, $user_query);
            if ($user_row = mysqli_fetch_assoc($user_result)) {
                $user_email = $user_row['email_address'];
                $user_name = $user_row['display_name'];

                // Prepare the email
                $emailSubject = "Account Suspension Notice ";
                $emailMessage = "
                    <p>We regret to inform you that your account on <strong>ProjectReportHub.ng</strong> has been temporarily suspended due to a violation of our platform’s terms of use and seller guidelines.</p>
                    <p>This action has been taken to maintain the integrity and quality of our marketplace for all users.</p>
                    <p><strong>Reason for Suspension:</strong> $reason</p>
                    <p><strong>Duration:</strong> $duration_value $duration_type</p>
                    <p>We kindly request that you review your account and take the necessary corrective steps. If you believe this suspension was made in error or would like to appeal the decision, please contact us at <a href='mailto:hello@learnora.ng'>hello@learnora.ng</a> with relevant details.</p>
                    <p>Your cooperation is appreciated, and we look forward to resolving this matter promptly.</p>
                   
                ";

                // Send the email
                if (sendEmail($user_email, $user_name, $siteName, $siteMail, $emailMessage, $emailSubject)) {
                    // Display success message
                    $message = "User suspended successfully, and an email notification has been sent.";
                    showSuccessModal('Processed', $message);
                    header("refresh:2; url=users.php");
                } else {
                    // Display error message for email failure
                    $message = "User suspended successfully, but the email notification could not be sent.";
                    showErrorModal('Email Error', $message);
                    header("refresh:2;");
                }
            }
        } else {
            // Display error message for suspension table insertion failure
            $message = "An error occurred while saving suspension details. Please try again.";
            showErrorModal('Oops', $message);
            header("refresh:2; url=users.php");
        }
    } else {
        // Display error message for user status update failure
        $message = "An error occurred while updating the user's status. Please try again.";
        showErrorModal('Oops', $message);
        header("refresh:2; url=users.php");
    }
}

//delete-record
  if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $table = $_GET['table'];
    $item = $_GET['item'];
    $page = $_GET['page'];
    
    if (deleteRecord($table, $item)) {
        $message="Record deleted successfully.";
    } else {
         $message="Failed to delete the record.";
    }

    showToast($message);
    header("refresh:1; url=$page");
}

//delete-plans
if (isset($_GET['action']) && $_GET['action'] == 'deleteplans') {
    $table = $_GET['table'];
    $item = $_GET['item'];
    $page = $_GET['page'];
    
    if (deleteRecord($table, $item)) {
        $message="Record deleted successfully.";
    } else {
         $message="Failed to delete the record.";
    }

    showToast($message);
    header("refresh:1; url=$page");
}


if(isset($_POST['update_profile_admin'])){
    // Personal Details
     $uploadDir = '../../uploads/';
      $user_id = mysqli_real_escape_string($con, $_POST['userid']);
    $title = mysqli_real_escape_string($con, $_POST['title'] ?? '');
    $firstName = mysqli_real_escape_string($con, $_POST['first-name'] ?? '');
    $middleName = mysqli_real_escape_string($con, $_POST['middle-name'] ?? '');
    $lastName = mysqli_real_escape_string($con, $_POST['last-name'] ?? '');
    $profile = mysqli_real_escape_string($con, $_POST['profile'] ?? '');
    $age = mysqli_real_escape_string($con, $_POST['age'] ?? '');
    $gender = mysqli_real_escape_string($con, $_POST['gender'] ?? '');
    $email = mysqli_real_escape_string($con, $_POST['email'] ?? '');
    $phone = mysqli_real_escape_string($con, $_POST['phone'] ?? '');
    $skills = mysqli_real_escape_string($con, $_POST['skills'] ?? '');
    $proficiency = mysqli_real_escape_string($con, $_POST['proficiency'] ?? '');
    $language = mysqli_real_escape_string($con, $_POST['language'] ?? '');
    $proficiency = mysqli_real_escape_string($con, $_POST['proficiency'] ?? '');
    $facebook = mysqli_real_escape_string($con, $_POST['facebook'] ?? '');
    $instagram = mysqli_real_escape_string($con, $_POST['instagram'] ?? '');
    $twitter = mysqli_real_escape_string($con, $_POST['twitter'] ?? '');
    $linkedin = mysqli_real_escape_string($con, $_POST['linkedin'] ?? '');
    // Company Details
    $companyName = mysqli_real_escape_string($con, $_POST['company-name'] ?? '');
    $companyProfile = mysqli_real_escape_string($con, $_POST['company-profile'] ?? '');
    $nigeriaOffice = mysqli_real_escape_string($con, $_POST['nigeria-office'] ?? '');
    $state = mysqli_real_escape_string($con, $_POST['state'] ?? '');
    $lga = mysqli_real_escape_string($con, $_POST['lga'] ?? '');
    $country = mysqli_real_escape_string($con, $_POST['country'] ?? '');
    $foreignOffice = mysqli_real_escape_string($con, $_POST['foreign-office'] ?? '');
    $category = mysqli_real_escape_string($con, $_POST['category'] ?? '');
    $subcategory = mysqli_real_escape_string($con, $_POST['subcategory'] ?? '');
    $status = $_POST['status']; // Default to 'active' if not set
    $type = $_POST['type'] ?? 'user'; // Default to 'user' if not set

    // === Handle Company Profile Picture Upload ===
$companyProfilePicture = $_FILES['company_profile_picture']['name'] ?? '';

if (!empty($companyProfilePicture)) {
    $fileKey = 'company_profile_picture';
    $companyProfilePicture = handleFileUpload($fileKey, $uploadDir);
} else {
    // Get existing company logo from database if not uploading a new one
    $query = mysqli_query($con, "SELECT company_logo FROM {$siteprefix}users WHERE s = '$user_id'");
    $row = mysqli_fetch_assoc($query);
    $companyProfilePicture = $row['company_logo'];
}

// === Handle Profile Picture Upload ===
$profilePicture = $_FILES['photo']['name'] ?? '';

if (!empty($profilePicture)) {
    $fileKey = 'photo';
    $profilePicture = handleFileUpload($fileKey, $uploadDir, $profilePicture);
} else {
    // Get existing profile photo from database if not uploading a new one
    $query = mysqli_query($con, "SELECT profile_photo FROM {$siteprefix}users WHERE s = '$user_id'");
    $row = mysqli_fetch_assoc($query);
    $profilePicture = $row['profile_photo'];
}


$update_query = "UPDATE {$siteprefix}users SET
    title = '$title',
    display_name = '$firstName $lastName',
    first_name = '$firstName',
    middle_name = '$middleName',
    last_name = '$lastName',
    company_name = '$companyName',
    proficiency = '$proficiency',
    company_profile = '$companyProfile',
    company_logo = '$companyProfilePicture',
    biography = '$profile',
    profile_photo = '$profilePicture',
    age = '$age',
    gender = '$gender',
    email_address = '$email',
    phone_number = '$phone',
    skills_hobbies = '$skills',
    status = '$status',
    type = '$type',
    language = '$language',
    n_office_address = '$nigeriaOffice',
    f_office_address = '$foreignOffice',
    category = '$category',
    subcategory = '$subcategory',
    facebook = '$facebook',
    instagram = '$instagram',
    twitter = '$twitter',
    linkedin = '$linkedin',
    state = '$state',
    lga = '$lga',
    country = '$country' WHERE s = '$user_id'";

 if (mysqli_query($con, $update_query)) {
        showSuccessModal("Success!", "Profile updated successfully!");
     
   
    } else {
        showErrorModal("Error!", "Failed to update profile: " . mysqli_error($con));
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addCategory'])) {
    // Sanitize inputs
    $categoryName = mysqli_real_escape_string($con, $_POST['categoryName']);
    $parentId = isset($_POST['parentId']) ? intval($_POST['parentId']) : 'NULL'; // Default to NULL if not provided

    // Generate base slug
    $baseSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $categoryName), '-'));

    // Make slug unique
    $alt_title = $baseSlug;
    $counter = 1;
    while (true) {
        $query = "SELECT COUNT(*) AS count FROM " . $siteprefix . "categories WHERE slug = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $alt_title);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            break; // slug is unique
        }

        // Append counter to slug if not unique
        $alt_title = $baseSlug . '-' . $counter;
        $counter++;
    }

    // Check if category name already exists under same parent
    $checkQuery = "SELECT COUNT(*) AS count FROM {$siteprefix}categories WHERE parent_id <=> $parentId AND category_name = '$categoryName'";
    $checkResult = mysqli_query($con, $checkQuery);
    $row = mysqli_fetch_assoc($checkResult);

    if ($row['count'] > 0) {
        // Category already exists
        $statusAction = "Duplicate Category!";
        $statusMessage = "Category \"$categoryName\" already exists under the selected parent.";
        showErrorModal2($statusAction, $statusMessage);
         header("refresh:2; url=add-category.php");
    } else {
        // Insert category with unique slug
        $insertQuery = "INSERT INTO {$siteprefix}categories (parent_id, category_name, slug) VALUES ($parentId, '$categoryName', '$alt_title')";
        if (mysqli_query($con, $insertQuery)) {
            $statusAction = "Success!";
            $statusMessage = "Category \"$categoryName\" created successfully!";
            showSuccessModal2($statusAction, $statusMessage);
            header("refresh:2; url=add-category.php");
        } else {
            $statusAction = "Error!";
            $statusMessage = "Failed to create category: " . mysqli_error($con);
            showErrorModal2($statusAction, $statusMessage);
        }
    }
}

if (isset($_POST['update-category'])) {
    $ids = $_POST['ids'];
    $names = $_POST['category_names'];

    foreach ($ids as $index => $id) {
        $name = mysqli_real_escape_string($con, $names[$index]);
        $id = intval($id);
        $query = "UPDATE " . $siteprefix . "categories SET category_name = '$name' WHERE id = $id";
        mysqli_query($con, $query);
        if (mysqli_error($con)) {
            $statusAction = "Error!";
            $statusMessage = "Failed to update category with $name: " . mysqli_error($con);
            showErrorModal2($statusAction, $statusMessage);
            exit;
        }
    }
    $message = "Categories updated successfully!";
    showToast($message);
    header("refresh:2; url=categories.php");
} 


//edit subategory
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editSubCategory'])) {
    $parentId = $_POST['parentId'];
    $subCategoryName = trim($_POST['subCategoryName']);
    $subcategory_id = intval($_POST['subcategory_id']);

    if ($subCategoryName !== '') {
        $escapedName = mysqli_real_escape_string($con, $subCategoryName);

        // Get the existing sub-category info (name and slug)
        $query = "SELECT category_name, slug FROM {$siteprefix}categories WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $subcategory_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $oldSubName = $row['category_name'];
            $oldSlug = $row['slug'];

            // Check if a category with the same name already exists under the same parent except current subcategory
            $checkQuery = "SELECT id FROM {$siteprefix}categories 
                           WHERE category_name = ? 
                           AND " . ($parentId === 'NULL' ? "parent_id IS NULL" : "parent_id = ?") . " 
                           AND id != ?";
            
            if ($parentId === 'NULL') {
                $checkStmt = $con->prepare($checkQuery);
                $checkStmt->bind_param("si", $escapedName, $subcategory_id);
            } else {
                $parentIdInt = intval($parentId);
                $checkStmt = $con->prepare($checkQuery);
                $checkStmt->bind_param("sii", $escapedName, $parentIdInt, $subcategory_id);
            }
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                $statusAction = "Duplicate!";
                $statusMessage = "A sub-category with the same name already exists under the selected parent category.";
                showErrorModal2($statusAction, $statusMessage);
                exit; // stop execution here
            }

            // If name changed, generate new slug
            if ($subCategoryName !== $oldSubName) {
                $baseSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $subCategoryName), '-'));
                $altSlug = $baseSlug;
                $counter = 1;

                // Check slug uniqueness excluding current record
                while (true) {
                    $slugCheckQuery = "SELECT COUNT(*) AS count FROM {$siteprefix}categories WHERE slug = ? AND id != ?";
                    $slugCheckStmt = $con->prepare($slugCheckQuery);
                    $slugCheckStmt->bind_param("si", $altSlug, $subcategory_id);
                    $slugCheckStmt->execute();
                    $slugCheckResult = $slugCheckStmt->get_result();
                    $countRow = $slugCheckResult->fetch_assoc();

                    if ($countRow['count'] == 0) {
                        break; // unique slug found
                    }

                    $altSlug = $baseSlug . '-' . $counter;
                    $counter++;
                }

                // Update name, parent_id, and slug
                $updateQuery = "UPDATE {$siteprefix}categories 
                                SET category_name = ?, 
                                    parent_id = " . ($parentId === 'NULL' ? "NULL" : "?") . ", 
                                    slug = ? 
                                WHERE id = ?";
                if ($parentId === 'NULL') {
                    $updateStmt = $con->prepare($updateQuery);
                    $updateStmt->bind_param("ssi", $escapedName, $altSlug, $subcategory_id);
                } else {
                    $updateStmt = $con->prepare($updateQuery);
                    $parentIdInt = intval($parentId);
                    $updateStmt->bind_param("sisi", $escapedName, $parentIdInt, $altSlug, $subcategory_id);
                }

            } else {
                // Name not changed, only update name and parent_id (slug remains the same)
                $updateQuery = "UPDATE {$siteprefix}categories 
                                SET category_name = ?, 
                                    parent_id = " . ($parentId === 'NULL' ? "NULL" : "?") . " 
                                WHERE id = ?";
                if ($parentId === 'NULL') {
                    $updateStmt = $con->prepare($updateQuery);
                    $updateStmt->bind_param("si", $escapedName, $subcategory_id);
                } else {
                    $updateStmt = $con->prepare($updateQuery);
                    $parentIdInt = intval($parentId);
                    $updateStmt->bind_param("sii", $escapedName, $parentIdInt, $subcategory_id);
                }
            }

            if ($updateStmt->execute()) {
                $statusAction = "Success!";
                $statusMessage = "Sub-category \"$subCategoryName\" updated successfully.";
                showSuccessModal2($statusAction, $statusMessage);
                header("refresh:2;");
             
            } else {
                $statusAction = "Error!";
                $statusMessage = "Failed to update sub-category: " . $updateStmt->error;
                showErrorModal2($statusAction, $statusMessage);
              
            }

        } else {
            $statusAction = "Error!";
            $statusMessage = "Sub-category not found.";
            showErrorModal2($statusAction, $statusMessage);
            exit;
        }
    } else {
        $statusAction = "Warning!";
        $statusMessage = "Please provide a valid sub-category name.";
        showErrorModal2($statusAction, $statusMessage);
        exit;
    }
}



//edit category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editCategory'])) {
    $category_id = intval($_POST['category_id']);
    $new_category_name = trim($_POST['category_name']);

    if ($category_id > 0 && $new_category_name !== '') {
        // First get the existing category info (name and slug)
        $query = "SELECT category_name, slug FROM {$siteprefix}categories WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $old_category_name = $row['category_name'];
            $old_slug = $row['slug'];

            // If category name changed, regenerate slug
            if ($new_category_name !== $old_category_name) {
                // Sanitize new category name
                $category_name_safe = mysqli_real_escape_string($con, $new_category_name);

                // Generate base slug
                $baseSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $new_category_name), '-'));

                // Ensure unique slug (exclude current id)
                $alt_slug = $baseSlug;
                $counter = 1;
                while (true) {
                    $checkQuery = "SELECT COUNT(*) AS count FROM {$siteprefix}categories WHERE slug = ? AND id != ?";
                    $checkStmt = $con->prepare($checkQuery);
                    $checkStmt->bind_param("si", $alt_slug, $category_id);
                    $checkStmt->execute();
                    $checkResult = $checkStmt->get_result();
                    $countRow = $checkResult->fetch_assoc();

                    if ($countRow['count'] == 0) {
                        break; // unique slug found
                    }

                    $alt_slug = $baseSlug . '-' . $counter;
                    $counter++;
                }

                // Update both category_name and slug
                $updateQuery = "UPDATE {$siteprefix}categories SET category_name = ?, slug = ? WHERE id = ?";
                $updateStmt = $con->prepare($updateQuery);
                $updateStmt->bind_param("ssi", $category_name_safe, $alt_slug, $category_id);

                if ($updateStmt->execute()) {
                    $statusAction = "Success!";
                    $statusMessage = "Category \"$new_category_name\" and slug updated successfully.";
                    showSuccessModal2($statusAction, $statusMessage);
                    header("refresh:2; url=manage-category.php");
                } else {
                    $statusAction = "Error!";
                    $statusMessage = "Failed to update category: " . $updateStmt->error;
                    showErrorModal2($statusAction, $statusMessage);
                }
            } else {
                // If category name NOT changed, do nothing or just show success without updating slug
                $statusAction = "No Change!";
                $statusMessage = "Category name unchanged, slug remains the same.";
                showSuccessModal2($statusAction, $statusMessage);
                header("refresh:2; url=manage-category.php");
            }
        } else {
            $statusAction = "Error!";
            $statusMessage = "Category not found.";
            showErrorModal2($statusAction, $statusMessage);
        }
    } else {
        $statusAction = "Warning!";
        $statusMessage = "Please provide a valid category name.";
        showErrorModal2($statusAction, $statusMessage);
    }
}


//ADD SUBCATEGORY
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addSubCategory'])) {
    // Sanitize and validate inputs
    $parentId = intval($_POST['parentId']); // ensure numeric value
    $subCategoryName = mysqli_real_escape_string($con, trim($_POST['subCategoryName'])); // clean input

    // Generate base slug from sub-category name
    $baseSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $subCategoryName), '-'));

    // Ensure slug is unique
    $alt_title = $baseSlug;
    $counter = 1;
    while (true) {
        $query = "SELECT COUNT(*) AS count FROM {$siteprefix}categories WHERE slug = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $alt_title);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            break; // slug is unique
        }

        $alt_title = $baseSlug . '-' . $counter;
        $counter++;
    }

    // Check for duplicate sub-category under the same parent (based on name)
    $checkQuery = "SELECT COUNT(*) AS count FROM {$siteprefix}categories WHERE parent_id = $parentId AND category_name = '$subCategoryName'";
    $checkResult = mysqli_query($con, $checkQuery);

    if ($checkResult) {
        $row = mysqli_fetch_assoc($checkResult);

        if ($row['count'] > 0) {
            $statusAction = "Duplicate Sub-Category!";
            $statusMessage = "Sub-category \"$subCategoryName\" already exists under the selected category.";
            showErrorModal2($statusAction, $statusMessage);
             header("refresh:2; url=add-subcategory.php");
        } else {
            // Insert sub-category with unique slug
            $insertQuery = "INSERT INTO {$siteprefix}categories (parent_id, category_name, slug) VALUES ($parentId, '$subCategoryName', '$alt_title')";
            if (mysqli_query($con, $insertQuery)) {
                $statusAction = "Success!";
                $statusMessage = "Sub-category \"$subCategoryName\" added successfully.";
                showSuccessModal2($statusAction, $statusMessage);
                header("refresh:2; url=add-subcategory.php");
            } else {
                $statusAction = "Error!";
                $statusMessage = "Failed to add sub-category: " . mysqli_error($con);
                showErrorModal2($statusAction, $statusMessage);
                 header("refresh:2; url=add-subcategory.php");
            }
        }
    } else {
        $statusAction = "Query Failed!";
        $statusMessage = "Could not check for duplicates: " . mysqli_error($con);
        showErrorModal2($statusAction, $statusMessage);
    }
}


//delete-category
if (isset($_GET['action']) && $_GET['action'] == 'deletecategory') {
    $table = $_GET['table'];
    $item = $_GET['item'];
    $page = $_GET['page'];

    // Delete subcategories first
    $sqlSub = "DELETE FROM {$siteprefix}{$table} WHERE parent_id = ?";
    $stmtSub = $con->prepare($sqlSub);
    $stmtSub->bind_param("i", $item);
    $stmtSub->execute();

    // Delete main category
    $sqlMain = "DELETE FROM {$siteprefix}{$table} WHERE id = ?";
    $stmtMain = $con->prepare($sqlMain);
    $stmtMain->bind_param("i", $item);

    if ($stmtMain->execute()) {
        $message = "Category and all its subcategories deleted successfully.";
    } else {
        $message = "Failed to delete the category: " . $stmtMain->error;
    }

    showToast($message);
    header("refresh:1; url=$page");
}

//sub category
if (isset($_GET['action']) && $_GET['action'] == 'deletesubcategory') {
    $table = $_GET['table'];
    $item = $_GET['item'];
    $page = $_GET['page'];
    
    if (deletecategoryRecord($table, $item)) {
        $message="Subcategory deleted successfully.";
    } else {
         $message="Failed to delete the Subcategory.";
    }

    showToast($message);
    header("refresh:1; url=$page");
}

//send message
// Send message
if (isset($_POST['sendmessage'])) {
    $subject = htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8');
    $content = trim($_POST['content']);
    $recipientSelection = isset($_POST['user']) ? (array)$_POST['user'] : [];

    $recipients = [];
    $recipientNames = [];
    $query = '';

    // Handle group-based recipient selections
    if (in_array('all', $recipientSelection)) {
        $query = "SELECT email_address, display_name FROM " . $siteprefix . "users WHERE type != 'admin' AND status = 'active'";
    } elseif (in_array('affiliate', $recipientSelection)) {
        $query = "SELECT email_address, display_name FROM " . $siteprefix . "users WHERE type = 'affiliate'";
    } elseif (in_array('instructors', $recipientSelection)) {
        $query = "SELECT email_address, name AS display_name FROM " . $siteprefix . "instructors";
    } elseif (in_array('user', $recipientSelection)) {
        $query = "SELECT email_address, display_name FROM " . $siteprefix . "users WHERE type = 'user' AND trainer = '1' AND status = 'active'";
    }

    // Execute group query if set
    if (!empty($query)) {
        $result = mysqli_query($con, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $email = $row['email_address'];
                $name = htmlspecialchars($row['display_name'] ?? 'Valued User', ENT_QUOTES, 'UTF-8');
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $recipients[] = $email;
                    $recipientNames[$email] = $name;
                }
            }
        }
    }

    // Handle individual recipients (only if group is not selected)
    if (empty($query)) {
        foreach ($recipientSelection as $email) {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $escaped = mysqli_real_escape_string($con, $email);
                $indivQuery = "SELECT display_name FROM " . $siteprefix . "users WHERE email_address = '$escaped'";
                $result = mysqli_query($con, $indivQuery);
                if ($result && $row = mysqli_fetch_assoc($result)) {
                    $recipients[] = $email;
                    $recipientNames[$email] = htmlspecialchars($row['display_name'], ENT_QUOTES, 'UTF-8');
                } else {
                    $recipients[] = $email;
                    $recipientNames[$email] = 'Valued User';
                }
            }
        }
    }

    // Filter valid, unique emails
    $recipients = array_filter(array_unique($recipients), fn($e) => filter_var($e, FILTER_VALIDATE_EMAIL));

    // Send messages
    $successCount = 0;
    $failCount = 0;

    foreach ($recipients as $email) {
        $name = $recipientNames[$email] ?? 'Valued User';
        $personalizedContent = str_replace('{{name}}', $name, $content);

        if (sendEmail($email, $name, $siteName, $siteMail, $personalizedContent, $subject)) {
            showToast("Message sent to $name ($email)");
            $successCount++;
        } else {
            showErrorModal2("Failed", "Failed to send message to $name ($email)");
            $failCount++;
        }
    }

    // Optionally show total summary
    if ($successCount > 0 || $failCount > 0) {
        echo "<div class='alert alert-info text-center'>
            Messages Sent: <strong>$successCount</strong><br>
            Failed: <strong>$failCount</strong>
        </div>";
    } elseif (empty($recipients)) {
        echo "<div class='alert alert-warning text-center'>No valid recipients found.</div>";
    }
}




// Add forum topic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addforum'])) {
    $user_id = mysqli_real_escape_string($con, $_POST['user']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $article = mysqli_real_escape_string($con, $_POST['article']);
    $categories = isset($_POST['category']) ? implode(',', array_map('intval', $_POST['category'])) : '';
    $created_at = date('Y-m-d H:i:s');
    $views = 0;


    // Replace spaces with hyphens and convert to lowercase
$baseSlug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $title), '-'));


// Start with the cleaned slug
$alt_title = $baseSlug;
$counter = 1;

// Ensure the alt_title is unique
while (true) {
    $query = "SELECT COUNT(*) AS count FROM " . $siteprefix . "forum_posts WHERE slug = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $alt_title);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] == 0) {
        break; // alt_title is unique
    }

    // Append counter to baseSlug if not unique
    $alt_title = $baseSlug . '-' . $counter;
    $counter++;
}
  
    // Handle image upload
  // Image Upload Settings
    $uploadDir = '../../uploads/';
    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
    $fileKey = 'featured_image';
    $uploadedImage = "";
    $message = "";

    // Check if an image is uploaded
    if (!empty($_FILES[$fileKey]['name'])) {
        $fileType = mime_content_type($_FILES[$fileKey]['tmp_name']);
        if (in_array($fileType, $allowedImageTypes)) {
            $fileName = uniqid() . '_' . basename($_FILES[$fileKey]['name']);
            $fileName = preg_replace("/[^a-zA-Z0-9\._-]/", "", $fileName); // Sanitize file name
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $filePath)) {
                $uploadedImage = $fileName;
            } else {
                $message .= "Error uploading image.<br>";
            }
        } else {
            $message .= "Invalid file type (Only JPG, PNG, GIF, WEBP allowed).<br>";
        }
    }
    // Insert into forum_posts table
    $sql = "INSERT INTO {$siteprefix}forum_posts (user_id, title, article, categories, featured_image, created_at, views,slug)
            VALUES (?, ?, ?, ?, ?, ?, ?,?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("isssssis", $user_id, $title, $article, $categories, $uploadedImage, $created_at, $views, $alt_title);

    if ($stmt->execute()) {
        showSuccessModal('Success!', 'Forum topic created successfully!');
        header("refresh:2; url=forum-list.php");
      
    } else {
        showErrorModal('Error!', 'Failed to create forum topic: ' . $stmt->error);
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editforum'])) {
    $forum_id = intval($_POST['forum_id']);
    $user_id = intval($_POST['user']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $article = mysqli_real_escape_string($con, $_POST['article']);
    $categories = isset($_POST['category']) ? implode(',', array_map('intval', $_POST['category'])) : '';
    $updated_at = date('Y-m-d H:i:s');
    $message = "";

    // Handle image upload
    $uploadDir = '../../uploads/';
    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
    $fileKey = 'featured_image';
    $uploadedImage = "";

    // Fetch current image
    $currentImage = '';
    $imgRes = mysqli_query($con, "SELECT featured_image FROM {$siteprefix}forum_posts WHERE s = $forum_id LIMIT 1");
    if ($imgRes && $imgRow = mysqli_fetch_assoc($imgRes)) {
        $currentImage = $imgRow['featured_image'];
    }

    // Check if a new image is uploaded
    if (!empty($_FILES[$fileKey]['name']) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
        $fileType = mime_content_type($_FILES[$fileKey]['tmp_name']);
        if (in_array($fileType, $allowedImageTypes)) {
            $fileName = uniqid() . '_' . basename($_FILES[$fileKey]['name']);
            $fileName = preg_replace("/[^a-zA-Z0-9\._-]/", "", $fileName);
            $filePath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $filePath)) {
                $uploadedImage = $fileName;
                // Optionally delete old image file here if you want
            } else {
                $message .= "Error uploading new image.<br>";
                $uploadedImage = $currentImage;
            }
        } else {
            $message .= "Invalid file type (Only JPG, PNG, GIF, WEBP allowed).<br>";
            $uploadedImage = $currentImage;
        }
    } else {
        $uploadedImage = $currentImage;
    }

    // Update the forum post
    $sql = "UPDATE {$siteprefix}forum_posts 
            SET user_id=?, title=?, article=?, categories=?, featured_image=?
            WHERE s=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("issssi", $user_id, $title, $article, $categories, $uploadedImage,  $forum_id);

    if ($stmt->execute()) {
        showSuccessModal('Success!', 'Forum topic updated successfully!');
        header("refresh:2; url=forum-list.php");
     
    } else {
        showErrorModal('Error!', 'Failed to update forum topic: ' . $stmt->error);
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment_id']) && isset($_POST['delete_comment'])) {
    $delete_comment_id = mysqli_real_escape_string($con, $_POST['delete_comment_id']);
    // Check if the logged-in user owns the comment
    $checkRes = mysqli_query($con, "SELECT user_id FROM fm_comments WHERE s='$delete_comment_id' LIMIT 1");
    $checkRow = mysqli_fetch_assoc($checkRes);
    if ($checkRow && $checkRow['user_id'] == $user_id) {
        deleteCommentAndReplies($delete_comment_id, $con);
        $statusAction = "Deleted!";
        $statusMessage = "Comment and all its replies deleted successfully.";
        showSuccessModal($statusAction, $statusMessage);
        header("refresh:1;");
       
    } else {
        $statusAction = "Error!";
        $statusMessage = "You are not allowed to delete this comment.";
        showErrorModal($statusAction, $statusMessage);
    }
}


//delete 
  if (isset($_GET['action']) && $_GET['action'] == 'deleteforum') {
    $table = $_GET['table'];
    $item = $_GET['item'];
    $page = $_GET['page'];
    
    if (deleteRecord($table, $item)) {
        $message="Post deleted successfully.";
    } else {
         $message="Failed to delete the post.";
    }

    showToast($message);
    header("refresh:1; url=$page");
}
// Blog Comment Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_reply_comment'])) {
    $blog_id = mysqli_real_escape_string($con, $_POST['blog_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user']);
    $comment = mysqli_real_escape_string($con, trim($_POST['comment']));
    $parent_comment_id = mysqli_real_escape_string($con, trim($_POST['parent_comment_id']));
    $commented_time = date('Y-m-d H:i:s');

    if ($blog_id && $user_id && $comment) {
        $insert_query = "INSERT INTO fm_comments (blog_id, comments, user_id, commented_time, parent_comment_id) 
                         VALUES ('$blog_id', '$comment', '$user_id', '$commented_time', '$parent_comment_id')";
        if (mysqli_query($con, $insert_query)) {
            $statusAction = "Success!";
            $statusMessage = "Your comment has been posted successfully!";
            showSuccessModal($statusAction, $statusMessage);
            // Redirect to avoid resubmission
            header("refresh:1;");
        
        } else {
            $statusAction = "Error!";
            $statusMessage = "An error occurred while posting your comment. Please try again.";
            showErrorModal($statusAction, $statusMessage);
        }
    } else {
        $statusAction = "Error!";
        $statusMessage = "All fields are required.";
        showErrorModal($statusAction, $statusMessage);
    }
}


//update dispute status
if (isset($_POST['update-dispute'])){
    $dispute_id = $_POST['ticket_id'];
    $status = $_POST['status'];
    updateDisputeStatus($con, $siteprefix, $dispute_id, $status);

    //get dispute details
    $sql = "SELECT * FROM ".$siteprefix."disputes WHERE ticket_number='$dispute_id'";
    $sql2 = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($sql2);
    $ticket_number = $row['ticket_number'];
    $recipient_id = $row['recipient_id'];
    $sender_id = $row['user_id'];

    $emailSubject="Dispute Updated($ticket_number)";
    $emailMessage="<p>This dispute status has been updated to $status</p>";
    $message = "Dispute status updated to $status: " . $ticket_number;
    $status=0;
    $date = date("Y-m-d H:i:s");

if($status=="resolved"){
$emailSubject="Your Issue Has Been Resolved ($ticket_number)";
$emailMessage="<p>Thank you for bringing your concern to our attention.<br>
We’re pleased to inform you that the issue (ticket number) you raised has now been successfully resolved. If you have any further questions or if there’s anything else we can assist you with, please don’t hesitate to reach out.
We appreciate your continued trust in ProjectReportHub.ng and look forward to serving you better.</p>";
}

    //notify sender and if recipient exists
    $sDetails = getUserDetails($con, $siteprefix, $sender_id);
    $s_email = $sDetails['email_address'];
    $s_name = $sDetails['display_name'];
    sendEmail($s_email, $s_name, $siteName, $siteMail, $emailMessage, $emailSubject);
    insertAlert($con, $sender_id, $message, $date, $status);

    if($recipient_id){
        $rDetails = getUserDetails($con, $siteprefix, $recipient_id);
        $r_email = $rDetails['email_address'];
        $r_name = $rDetails['display_name'];
       sendEmail($r_email, $r_name, $siteName, $siteMail, $emailMessage, $emailSubject);
       insertAlert($con, $recipient_id, $message, $date, $status);
    }
    $message="Dispute status updated successfully.";
    showToast($message);
}


    ?>