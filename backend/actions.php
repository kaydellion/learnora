<?php
$total_amount = $total_withdrawal = $total_cleared = $totalDisputeAmount= $totalEarnedAmount = 0;
$total_resources_sold = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $order_id = $_POST['order_id'];
    header("Location: $siteurl/pay_success.php?ref=$order_id");
    exit;
}


if($active_log==1){
    $sql = "SELECT SUM(price) as total FROM ".$siteprefix."order_items WHERE order_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $order_total = empty($row['total']) ? 0 : $row['total'];

    //update total orders in orders table
    $sql = "UPDATE ".$siteprefix."orders SET total_amount = ? WHERE order_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ds", $order_total, $order_id);
    $stmt->execute();
    $stmt->close();

    // Get count of paid orders
$sql = "SELECT COUNT(*) as count FROM ".$siteprefix."orders WHERE user = ? AND status = 'paid'";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$paid_orders_count = $row['count'];

// Get count of reviews received
$sql = "SELECT COUNT(*) as count 
    FROM ".$siteprefix."reviews r
    JOIN ".$siteprefix."training p ON r.training_id = p.training_id
    WHERE p.user = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$reviews_count = $row['count'];

// Get count of pending manual payments
$pendingOrResendQuery = "SELECT COUNT(*) as count FROM ".$siteprefix."manual_payments WHERE user_id = ?";
$stmt = $con->prepare($pendingOrResendQuery);
$stmt->bind_param("s", $user_id);
$stmt->execute(); 
$pendingOrResendResult = $stmt->get_result();
$pendingOrResendRow = $pendingOrResendResult->fetch_assoc();
$pending_payments_count = $pendingOrResendRow['count'];

 // Fetch data for the cards
$withdrawal_query = "SELECT SUM(amount) AS total_withdrawal FROM ".$siteprefix."withdrawal WHERE user='$user_id' AND status='pending'";
$withdrawal_result = mysqli_query($con, $withdrawal_query);
$withdrawal_row = mysqli_fetch_assoc($withdrawal_result);
$total_withdrawal = $withdrawal_row['total_withdrawal'] ?? 0;

// Get count of resources sold
$sql = "SELECT COUNT(DISTINCT r.training_id) as count
    FROM {$siteprefix}training r
    JOIN {$siteprefix}order_items oi ON r.training_id = oi.training_id
    JOIN {$siteprefix}orders o ON oi.order_id = o.order_id
    WHERE r.user = ? AND o.status = 'paid'";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$resources_sold_count = $row['count'];

$total_resources_sold = $resources_sold_count;


// Fetch Cleared Transactions
$cleared_query = "SELECT SUM(amount) AS total_cleared FROM ".$siteprefix."withdrawal WHERE user='$user_id' AND status='paid'";
$cleared_result = mysqli_query($con, $cleared_query);
$cleared_row = mysqli_fetch_assoc($cleared_result);
$total_cleared = $cleared_row['total_cleared'] ?? 0;
$userId = $user_id; 

$sql = "
    SELECT
        SUM(CASE
            WHEN reason LIKE '%Dispute Resolution:%' AND status = 'credit' THEN amount
            ELSE 0
        END) AS total_dispute_amount,
        
        SUM(CASE
            WHEN reason LIKE '%Payment from Order ID%' AND status = 'credit' THEN amount
            ELSE 0
        END) AS total_earned_amount
    FROM {$siteprefix}wallet_history
    WHERE user = '$userId'
";
$result = mysqli_query($con, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalDisputeAmount = $row['total_dispute_amount'] ?? 0;
    $totalEarnedAmount = $row['total_earned_amount'] ?? 0;
} else {
    echo "Error: " . mysqli_error($con);
}
    } else ($order_total = 0);
//new-registertion
if(isset($_POST['register-user'])){

    // Personal Details
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
    $language = mysqli_real_escape_string($con, $_POST['language'] ?? '');
    $proficiency = mysqli_real_escape_string($con, $_POST['proficiency'] ?? '');
    $facebook = mysqli_real_escape_string($con, $_POST['facebook'] ?? '');
    $instagram = mysqli_real_escape_string($con, $_POST['instagram'] ?? '');
    $twitter = mysqli_real_escape_string($con, $_POST['twitter'] ?? '');
    $linkedin = mysqli_real_escape_string($con, $_POST['linkedin'] ?? '');
    // Company Details
     $company_profile_picture = $_FILES['company_profile_picture']['name'];
    $companyName = mysqli_real_escape_string($con, $_POST['company-name'] ?? '');
    $companyProfile = mysqli_real_escape_string($con, $_POST['company-profile'] ?? '');
    $nigeriaOffice = mysqli_real_escape_string($con, $_POST['nigeria-office'] ?? '');

    $foreignOffice = mysqli_real_escape_string($con, $_POST['foreign-office'] ?? '');
    $category = isset($_POST['category']) && is_array($_POST['category']) ? implode(',', $_POST['category']) : '';
$subcategory = isset($_POST['subcategory']) && is_array($_POST['subcategory']) ? implode(',', $_POST['subcategory']) : '';
    $profile_picture = $_FILES['photo']['name'];
    $password = $_POST['password'];
    $retypePassword = $_POST['retypePassword'];
    

     // Address logic
    $is_nigerian = $_POST['is_nigerian'] ?? '';
    $full_address_ng = mysqli_real_escape_string($con, $_POST['full_address_ng'] ?? '');
    $state = mysqli_real_escape_string($con, $_POST['state'] ?? '');
    $lga = mysqli_real_escape_string($con, $_POST['lga'] ?? '');
    $country_ng = mysqli_real_escape_string($con, $_POST['country_ng'] ?? 'Nigeria');
    $full_address_foreign = mysqli_real_escape_string($con, $_POST['full_address_foreign'] ?? '');
    $country_foreign = mysqli_real_escape_string($con, $_POST['country_foreign'] ?? '');

    // Determine which address/country to use
    if ($is_nigerian === 'yes') {
        $address = $full_address_ng;
        $country = $country_ng;
    } else {
        $address = $full_address_foreign;
        $country = $country_foreign;
        $state = '';
        $lga = '';
    }

    //profile picture
    $status = 'inactive';
    $date = date('Y-m-d H:i:s');
    $last_login = $date;
    $created_date = date("Y-m-d H:i:s");
    $uploadDir = 'uploads/';
    $profilePicture = '';
	$type = 'user';
    $fileKey='company_profile_picture';
    $display_name = $firstName . ' ' . $lastName;
    $biography = $profile;
    $profile_photo = $profile_picture;
    $company_logo = $company_profile_picture;
    $trainer = 0;
    $reset_token = '';
    $reset_token_expiry = '';
    global $fileName;
    $fileKey='photo';

        if (!empty($profile_picture)) {
             $fileName = uniqid() . '_' . basename($profile_picture);
           $profile_picture = handleFileUpload($fileKey, $uploadDir, $fileName);
       } else {
           $profile_picture = 'user.png'; // Use the current profile picture if no new one is uploaded
       }
   
    // Handle profile/company logo upload
       if (!empty($company_profile_picture)) {
        $fileName = uniqid() . '_' . basename($company_profile_picture);
           $company_profile_picture = handleFileUpload($fileKey, $uploadDir, $fileName);
       } else {
           $company_profile_picture = 'user.png'; // Use the current profile picture if no new one is uploaded
       }


  //error for same email,password errors
  $checkEmail = mysqli_query($con, "SELECT * FROM ".$siteprefix."users WHERE email_address='$email'");
  if(mysqli_num_rows($checkEmail) >= 1 ) {
  $statusAction="Ooops!";
  $statusMessage="This email has already been registered. Please try registering another email.";
  showErrorModal($statusAction, $statusMessage); } 	

  //check if password is less than 6
  else if (strlen($password) < 6){
      $statusAction="Try Again";
      $statusMessage="Password must have 8 or more characters";
      showErrorModal($statusAction, $statusMessage);
  }	
  //check if password match									
  else if ($password !== $retypePassword ){
      $statusAction="Ooops!";
      $statusMessage="Password do not match!";
      showErrorModal($statusAction, $statusMessage);
  }
   else if (
        ($is_nigerian === 'yes' && (empty($full_address_ng) || empty($state) || empty($lga))) ||
        ($is_nigerian === 'no' && (empty($full_address_foreign) || empty($country_foreign)))
    ) {
        $statusAction="Ooops!";
        $statusMessage="Please fill all required address fields.";
        showErrorModal($statusAction, $statusMessage);
    }
       else {
       $password=hashPassword($password);
            $query = "INSERT INTO ".$siteprefix."users (
        title, display_name, first_name, middle_name, last_name, company_name, company_profile, company_logo, biography, profile_photo, age, gender, email_address, phone_number, skills_hobbies, language, proficiency, n_office_address, f_office_address, category, subcategory, facebook, instagram, twitter, linkedin, state, lga, country,address, type,status, trainer,password, last_login, created_date, reset_token, reset_token_expiry,affliate,loyalty,downloads,wallet,bank_name,bank_accname,bank_number
    ) VALUES ('$title','$display_name','$firstName','$middleName','$lastName','$companyName','$companyProfile','$company_profile_picture','$biography','$profile_picture','$age','$gender','$email','$phone','$skills','$language','$proficiency','$nigeriaOffice','$foreignOffice','$category','$subcategory','$facebook','$instagram','$twitter','$linkedin','$state','$lga','$country','$address','$type', '$status', '$trainer','$password','$last_login','$created_date','$reset_token','$reset_token_expiry','','','','','','',''
    )";

        if (mysqli_query($con, $query)) {
            $user_id = mysqli_insert_id($con);
            echo header("location:trainer.php?user_login=$user_id");
        }
        else {
            $statusAction = "Error!";
            $statusMessage = "There was an error registering the user: " . mysqli_error($con);
            showErrorModal($statusAction, $statusMessage);
            exit();
        } 
    }
}


if(isset($_POST['register-newuser'])){

    // Personal Details
    $title = mysqli_real_escape_string($con, $_POST['title'] ?? '');
    $firstName = mysqli_real_escape_string($con, $_POST['first-name'] ?? '');
    $middleName = mysqli_real_escape_string($con, $_POST['middle-name'] ?? '');
    $lastName = mysqli_real_escape_string($con, $_POST['last-name'] ?? '');
    $profile = mysqli_real_escape_string($con, $_POST['profile'] ?? '');
    $age = mysqli_real_escape_string($con, $_POST['age'] ?? '');
    $gender = mysqli_real_escape_string($con, $_POST['gender'] ?? '');
    $email = mysqli_real_escape_string($con, $_POST['email'] ?? '');
    $phone = mysqli_real_escape_string($con, $_POST['phone'] ?? '');
    $facebook = mysqli_real_escape_string($con, $_POST['facebook'] ?? '');
    $instagram = mysqli_real_escape_string($con, $_POST['instagram'] ?? '');
    $twitter = mysqli_real_escape_string($con, $_POST['twitter'] ?? '');
    $profile_picture = $_FILES['photo']['name'];
    $password = $_POST['password'];
    $retypePassword = $_POST['retypePassword'];
    //profile picture
    $status = 'inactive';
    $date = date('Y-m-d H:i:s');
    $last_login = $date;
    $created_date = date("Y-m-d H:i:s");
    $uploadDir = 'uploads/';
    $profilePicture = '';
	$type = 'user';
    $display_name = $firstName . ' ' . $lastName;
    $biography = $profile;
    $profile_photo = $profile_picture;
   

        // Address logic
    $is_nigerian = $_POST['is_nigerian'] ?? '';
    $full_address_ng = mysqli_real_escape_string($con, $_POST['full_address_ng'] ?? '');
    $state = mysqli_real_escape_string($con, $_POST['state'] ?? '');
    $lga = mysqli_real_escape_string($con, $_POST['lga'] ?? '');
    $country_ng = mysqli_real_escape_string($con, $_POST['country_ng'] ?? 'Nigeria');
    $full_address_foreign = mysqli_real_escape_string($con, $_POST['full_address_foreign'] ?? '');
    $country_foreign = mysqli_real_escape_string($con, $_POST['country_foreign'] ?? '');

    // Determine which address/country to use
    if ($is_nigerian === 'yes') {
        $address = $full_address_ng;
        $country = $country_ng;
    } else {
        $address = $full_address_foreign;
        $country = $country_foreign;
        $state = '';
        $lga = '';
    }

   
    $reset_token = '';
    $reset_token_expiry = '';
    global $fileName;
    $fileKey='photo';

        if (!empty($profile_picture)) {
                $fileName = uniqid() . '_' . basename($profile_picture);
           $profile_picture = handleFileUpload($fileKey, $uploadDir, $fileName);
       } else {
           $profile_picture = 'user.png'; // Use the current profile picture if no new one is uploaded
       }

    //error for same email,password errors
  $checkEmail = mysqli_query($con, "SELECT * FROM ".$siteprefix."users WHERE email_address='$email'");
  if(mysqli_num_rows($checkEmail) >= 1 ) {
  $statusAction="Ooops!";
  $statusMessage="This email has already been registered. Please try registering another email.";
  showErrorModal($statusAction, $statusMessage); } 	

  //check if password is less than 6
  else if (strlen($password) < 6){
      $statusAction="Try Again";
      $statusMessage="Password must have 8 or more characters";
      showErrorModal($statusAction, $statusMessage);
  }	
  //check if password match									
  else if ($password !== $retypePassword ){
      $statusAction="Ooops!";
      $statusMessage="Password do not match!";
      showErrorModal($statusAction, $statusMessage);
  }
    else if (
        ($is_nigerian === 'yes' && (empty($full_address_ng) || empty($state) || empty($lga))) ||
        ($is_nigerian === 'no' && (empty($full_address_foreign) || empty($country_foreign)))
    ) {
        $statusAction="Ooops!";
        $statusMessage="Please fill all required address fields.";
        showErrorModal($statusAction, $statusMessage);
    }

       else {
       $password=hashPassword($password);
                     $query = "INSERT INTO ".$siteprefix."users (
        title, display_name, first_name, middle_name, last_name, company_name, company_profile, company_logo, biography, profile_photo, age, gender, email_address, phone_number, skills_hobbies, language, proficiency, n_office_address, f_office_address, category, subcategory, facebook, instagram, twitter, linkedin, state, lga, country, address, type,status, trainer,password, last_login, created_date, reset_token, reset_token_expiry,affliate,loyalty,downloads,wallet,bank_name,bank_accname,bank_number
    ) VALUES ('$title','$display_name','$firstName','$middleName','$lastName','','','','$profile','$profile_picture','','$gender','$email','$phone','','','','','','','','$facebook','$instagram','$twitter','$linkedin','$state','$lga','$country','$address', '$type', '', '','$password','$last_login','$created_date','$reset_token','$reset_token_expiry','','','','','','',''
    )";

        if (mysqli_query($con, $query)) {
            $user_id = mysqli_insert_id($con);
            echo header("location:login.php?user_login=$user_id");

            $emailSubject="Confirm Your Email";
    $emailMessage = "
    <p>Thank you for signing up on <strong>Learnorq</strong>! To complete your registration
    and start exploring our platform, please verify your email address by clicking the link below:</p>
    <p><a href='$siteurl/verifymail.php?verify_status=$user_id'>Click here to verify your email</a></p>
    <p>Once verified, you can log in and start accessing premium reports, upload your content,
    or manage your dashboard.</p>";

        $adminmessage = "A new user has been registered($display_name)";
        $link="users.php";
        $msgtype='New User';
        $message_status=1;
        $emailMessage_admin="<p>A new user has been successfully registered!</p>";
        $emailSubject_admin="New User Registeration";
        insertadminAlert($con, $adminmessage, $link, $date, $msgtype, $message_status); 
        sendEmail($email, $display_name, $siteName, $siteMail, $emailMessage, $emailSubject);
        sendEmail($siteMail, $adminName, $siteName, $siteMail, $emailMessage_admin, $emailSubject_admin);
        }
        else {
            $statusAction = "Error!";
            $statusMessage = "There was an error registering the user: " . mysqli_error($con);
            showErrorModal($statusAction, $statusMessage);
            exit();
        } 
    }
}

// Handle Report Product Submission
if (isset($_POST['submit_report'])) {
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $reason = mysqli_real_escape_string($con, $_POST['reason']);
    $custom_reason = isset($_POST['custom_reason']) ? mysqli_real_escape_string($con, trim($_POST['custom_reason'])) : null;

    

    $date = date('Y-m-d H:i:s');

    // Fetch the product title
    $product_query = "SELECT title,alt_title FROM " . $siteprefix . "training WHERE training_id = '$product_id'";
    $product_result = mysqli_query($con, $product_query);

    if ($product_result && mysqli_num_rows($product_result) > 0) {
        $product = mysqli_fetch_assoc($product_result);
        $product_title = $product['title'];
        $product_alt_title = $product['alt_title'];
    } else {
        $statusAction = "Error!";
        $statusMessage = "Product not found.";
        showErrorModal($statusAction, $statusMessage);
        header("refresh:2; url=events.php/$product_alt_title");
        exit();
    }

    // Insert the report into the database
    $insert_query = "INSERT INTO " . $siteprefix . "product_reports (product_id, user_id, reason, main_reason, report_date) 
                     VALUES ('$product_id', '$user_id', '$reason', '$custom_reason', '$date')";

    if (mysqli_query($con, $insert_query)) {
        // Fetch admin email
        $admin_email = $siteMail; // Replace with your admin email variable
       
        // Fetch user details
        $user_query = "SELECT display_name, email_address FROM " . $siteprefix . "users WHERE s = '$user_id'";
        $user_result = mysqli_query($con, $user_query);

        if ($user_result && mysqli_num_rows($user_result) > 0) {
            $user = mysqli_fetch_assoc($user_result);
            $user_name = $user['display_name'];
            $user_email = $user['email_address'];
        } else {
            $user_name = "Unknown User";
            $user_email = "Unknown Email";
        }

        // Email content
        $emailSubject = "New Product Report Submitted";
        $emailMessage = "
            <p>A new product report has been submitted:</p>
            <p><strong>Product Title:</strong> $product_title</p>
            <p><strong>User:</strong> $user_name ($user_email)</p>
            <p><strong>Reason:</strong> $reason</p>
            <p><strong>Other Reason:</strong> $custom_reason</p>
            <p><strong>Date:</strong> $date</p>
        ";

        // Send email to admin
      //  sendEmail($siteMail, $adminName, $siteName, $siteMail, $emailMessage, $emailSubject);

        // Success message
        $statusAction = "Success!";
        $statusMessage = "Your report for <strong>$product_title</strong> has been submitted successfully.";
        showSuccessModal($statusAction, $statusMessage);
        header("Refresh:2; url=" . $siteurl . "events/" . $product_alt_title);

    } else {
        // Error message
        $statusAction = "Error!";
        $statusMessage = "An error occurred while submitting your report. Please try again.";
        showErrorModal($statusAction, $statusMessage);
        header("Refresh:2; url=" . $siteurl . "events/" . $product_alt_title);

    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit-message'])) {
    $name = mysqli_real_escape_string($con, $_POST['name'] ?? '');
    $email = mysqli_real_escape_string($con, $_POST['email'] ?? '');
    $subject = mysqli_real_escape_string($con, $_POST['subject'] ?? '');
    $message = mysqli_real_escape_string($con, $_POST['message'] ?? '');

    if ($name && $email && $subject && $message) {
        // Insert into contact_messages table (create this table if not exists)
        $insert_sql = "INSERT INTO {$siteprefix}contact_messages 
            (name, email, subject, message, created_at)
            VALUES 
            ('$name', '$email', '$subject', '$message', NOW())";
        $insert_result = mysqli_query($con, $insert_sql);

        if ($insert_result) {
            // Send email to admin
            $emailSubject = "New Contact Message: $subject";
            $emailMessage = "
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Subject:</strong> $subject</p>
                <p><strong>Message:</strong><br>$message</p>
            ";
            sendEmail($siteMail, $sitename, $siteName, $siteMail, $emailMessage, $emailSubject);

            showSuccessModal("Success!", "Your message has been sent successfully!");
            header("refresh:1;");
        } else {
            showErrorModal("Error!", "Failed to send your message: " . mysqli_error($con));
        }
    } else {
        showErrorModal("Error!", "All fields are required.");
    }
}


//folow category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['follow_category_submit'])) {
    $user_id = $_POST['user_id']; // Logged-in user ID
    $category_id = $_POST['category_id']; // Category ID
    $subcategory_id = $_POST['subcategory_id']; // Subcategory ID (can be empty)
    $actioning = isset($_POST['actioning']) ? $_POST['actioning'] : null; // Action: follow or unfollow

    if (empty($user_id) || empty($category_id)) {
        echo "<script>alert('Invalid request.');</script>";
        exit();
    }

    if ($actioning === "follow_category") {
        // Add a new follow record for the category
        $insertQuery = "INSERT INTO ".$siteprefix."followers (user_id, seller_id, followed_at, category_id, subcategory_id) VALUES (?, '', NOW(), ?, ?)";
        $stmt = $con->prepare($insertQuery);
        $stmt->bind_param("iis", $user_id, $category_id, $subcategory_id);
        if ($stmt->execute()) {
            echo "<script>alert('You are now following this category.');</script>";
        } else {
            echo "<script>alert('Failed to follow the category.');</script>";
        }
    } elseif ($actioning === "unfollow_category") {
        // Remove the follow record for the category
        $deleteQuery = "DELETE FROM ".$siteprefix."followers WHERE user_id = ? AND category_id = ? AND subcategory_id = ?";
        $stmt = $con->prepare($deleteQuery);
        $stmt->bind_param("iis", $user_id, $category_id, $subcategory_id);
        if ($stmt->execute()) {
            echo "<script>alert('You have unfollowed this category.');</script>";
        } else {
            echo "<script>alert('Failed to unfollow the category.');</script>";
        }
    }
}

// Blog Comment Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_comment'])) {
    $blog_id = mysqli_real_escape_string($con, $_POST['blog_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user']);
    $comment = mysqli_real_escape_string($con, trim($_POST['comment']));
    $parent_comment_id = '';
    $commented_time = date('Y-m-d H:i:s');

    if ($blog_id && $user_id && $comment) {
        $insert_query = "INSERT INTO ln_comments (blog_id, comments, user_id, commented_time, parent_comment_id) 
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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment_id']) && isset($_POST['delete_comment'])) {
    $delete_comment_id = mysqli_real_escape_string($con, $_POST['delete_comment_id']);
    // Check if the logged-in user owns the comment
    $checkRes = mysqli_query($con, "SELECT user_id FROM ln_comments WHERE s='$delete_comment_id' LIMIT 1");
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



// Blog Comment Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_reply_comment'])) {
    $blog_id = mysqli_real_escape_string($con, $_POST['blog_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user']);
    $comment = mysqli_real_escape_string($con, trim($_POST['comment']));
    $parent_comment_id = mysqli_real_escape_string($con, trim($_POST['parent_comment_id']));
    $commented_time = date('Y-m-d H:i:s');

    if ($blog_id && $user_id && $comment) {
        $insert_query = "INSERT INTO ln_comments (blog_id, comments, user_id, commented_time, parent_comment_id) 
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_event'])) {

        // Directories for uploads
    $uploadDir = 'uploads/';
    $fileuploadDir = 'documents/';
  
    $message = "";
    $physical_address = $physical_state = $physical_lga = $physical_country = $foreign_address = '';
    $web_address = '';
    $hybrid_physical_address = $hybrid_web_address = $hybrid_state = $hybrid_lga = $hybrid_country = $hybrid_foreign_address = '';
    $status = 'pending';
    $trainingId = mysqli_real_escape_string($con, $_POST['id']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
     $description = mysqli_real_escape_string($con, $_POST['description']);
 $category = isset($_POST['category']) && is_array($_POST['category']) ? implode(',', $_POST['category']) : '';
$subcategory = isset($_POST['subcategory']) && is_array($_POST['subcategory']) ? implode(',', $_POST['subcategory']) : '';
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
$baseSlug = strtolower(str_replace(' ', '-', $title));

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

    $promo_video = $_FILES['promo_video']['name'];
    if (!empty($promo_video)) { 
        $fileKey = 'promo_video';
        $fileName = uniqid() . '_' . basename($promo_video);
        $logopromo_video = handleFileUpload($fileKey, $uploadDir, $fileName);
        $insertQuery=mysqli_query($con, "INSERT INTO {$siteprefix}training_videos (training_id, video_type, video_path, updated_at) VALUES ('$training_id', 'promo', '$logopromo_video', NOW())");
    } 
    $trailer_video = $_FILES['trailer_video']['name'];
    if (!empty($trailer_video)) {
        $fileKey = 'trailer_video';
        $fileName = uniqid() . '_' . basename($trailer_video);
        $logotrailer_video = handleFileUpload($fileKey, $fileuploadDir, $fileName);
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

     // 4. Handle Quiz/Assignment
$quiz_type = $_POST['quiz_method'];

if ($quiz_type === 'text' && !empty($_POST['quiz_text'][0])) {
    $text_content = mysqli_real_escape_string($con, $_POST['quiz_text'][0]);
   mysqli_query(
    $con,
    "INSERT INTO {$siteprefix}training_quizzes (training_id, type, file_path, text_path, instructions, updated_at) VALUES ('$training_id', 'text', '', '$text_content', '', NOW())"
);
} elseif ($quiz_type === 'upload' && !empty($_FILES['quiz_files']['name'][0])) {
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
elseif ($quiz_type === 'form' && !empty($_POST['questions'])) {
    $quiz_instructions = isset($_POST['quiz_instructions']) ? mysqli_real_escape_string($con, $_POST['quiz_instructions']) : '';
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
        $q = mysqli_real_escape_string($con, $question);
        $a = mysqli_real_escape_string($con, $_POST['option_a'][$i]);
        $b = mysqli_real_escape_string($con, $_POST['option_b'][$i]);
        $c = mysqli_real_escape_string($con, $_POST['option_c'][$i]);
        $d = mysqli_real_escape_string($con, $_POST['option_d'][$i]);
        $correct = mysqli_real_escape_string($con, $_POST['correct_answer'][$i]);
        mysqli_query(
            $con,
            "INSERT INTO {$siteprefix}training_quiz_questions (quiz_id, question, option_a, option_b, option_c, option_d, correct_answer)
             VALUES ('$quiz_id', '$q', '$a', '$b', '$c', '$d', '$correct')"
        );
    }
}



if ($delivery_format === 'video') {
    foreach ($_POST['video_module_title'] as $index => $title) {
        $desc        = $_POST['video_module_desc'][$index] ?? '';
        $duration    = $_POST['video_duration'][$index] ?? '';
        $videoLink   = $_POST['video_link'][$index] ?? '';
        $qualities   = isset($_POST['video_quality'][$index]) ? implode(',', $_POST['video_quality'][$index]) : '';
        $subtitles   = $_POST['video_subtitles'][$index] ?? '';

        // Prepare file path
        $filePath = '';
        if (!empty($_FILES['video_file']['name'][$index])) {
            // Temporarily restructure the file array for this index
            $tmpFileKey = 'single_video_upload';
            $_FILES[$tmpFileKey] = [
                'name'     => $_FILES['video_file']['name'][$index],
                'type'     => $_FILES['video_file']['type'][$index],
                'tmp_name' => $_FILES['video_file']['tmp_name'][$index],
                'error'    => $_FILES['video_file']['error'][$index],
                'size'     => $_FILES['video_file']['size'][$index]
            ];

            $fileName = handleFileUpload($tmpFileKey, $fileuploadDir); // using your function
            if ($fileName && strpos($fileName, 'Failed') === false && strpos($fileName, 'error') === false) {
                $filePath =  $fileName;
            }
        }

        // Insert into DB
        $stmt = $con->prepare("
            INSERT INTO {$siteprefix}training_video_modules
            (training_id, module_number, title, description, duration, file_path, video_link, video_quality, subtitles, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        $module_number = $index + 1;
        $stmt->bind_param("sisssssss", $training_id, $module_number, $title, $desc, $duration, $filePath, $videoLink, $qualities, $subtitles);
        $stmt->execute();
        $stmt->close();
    }
}

elseif ($delivery_format === 'text') {
    // Loop through all text modules
    foreach ($_POST['text_module_title'] as $index => $title) {
        $desc         = $_POST['text_module_desc'][$index] ?? '';
        $readingTime  = $_POST['text_reading_time'][$index] ?? '';

        // Handle file upload for this index using your function
        $filePath = '';
        if (!empty($_FILES['text_file']['name'][$index])) {
            // Create a temporary single-file array for this index
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

        // Insert into text table
        $stmt = $con->prepare("
            INSERT INTO {$siteprefix}training_texts_modules
            (training_id, module_number, title, description, reading_time, file_path, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        $module_number = $index + 1;
        $stmt->bind_param("sissss", $training_id, $module_number, $title, $desc, $readingTime, $filePath);

        if (!$stmt->execute()) {
            echo "Error inserting text module {$module_number}: " . $stmt->error . "<br>";
        }
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
                        VALUES ('$new_name', '$new_email', '$new_bio', '$instructor_photo', '$adduser')");

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
        '$pricing', '$category', '$subcategory', '$instructor_id', '$additional_notes', '$tags', '$quiz_type', NOW(), '$alt_title', '$status', '$loyalty', '$user'
    )");

if ($insertTraining) {
     $message .= "Training added successfully!";
            showSuccessModal('Processed', $message);
            header("refresh:2; url=dashboard.php");
} else {
    $message .= "Error adding report: " . mysqli_error($con);
            showErrorModal('Update Failed', $message);
            header("refresh:2;");
}


}


//follow seller
   if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $target_user_id = $_POST['seller_id'];
      $user_id = $_POST['user_id']; // Replace with your session variable for user ID

    if ($action === 'follow') {
        // Add a new follower
        $followQuery = "INSERT INTO ".$siteprefix."followers (user_id, seller_id, followed_at, category_id, subcategory_id) VALUES (?, ?, NOW(), '', '')";
        $stmt = $con->prepare($followQuery);
        $stmt->bind_param("ii", $user_id, $target_user_id);
        $stmt->execute();

        echo "<script>alert('You are now following the seller.');</script>";
    } elseif ($action === 'unfollow') {
        // Remove the follower
        $unfollowQuery = "DELETE FROM {$siteprefix}followers WHERE user_id = ? AND seller_id = ?";
        $stmt = $con->prepare($unfollowQuery);
        $stmt->bind_param("ii", $user_id, $target_user_id);
        $stmt->execute();
        echo "<script>alert('You have unfollowed the seller.');</script>";
    }

}


// Affiliate Registration
if (isset($_POST['register-affiliate'])) {
    // Sanitize and validate input fields
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($con, $_POST['middle_name']);
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $referral_source = mysqli_real_escape_string($con, $_POST['referral_source']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $agree_terms = isset($_POST['agree_terms']) ? 1 : 0;
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $retypePassword = mysqli_real_escape_string($con, $_POST['retypePassword']);
    $date = date('Y-m-d H:i:s');
    $status = 'active';
    $type = 'affiliate';
    $affiliate = 'AFF-' . strtoupper(substr(bin2hex(random_bytes(6)), 0, 12));
    // Generate unique affiliate ID

    // Validate email uniqueness
    $checkEmail = mysqli_query($con, "SELECT * FROM " . $siteprefix . "users WHERE email_address='$email'");
    if (mysqli_num_rows($checkEmail) >= 1) {
        $statusAction = "Ooops!";
        $statusMessage = "This email has already been registered. Please try registering with another email.";
        showErrorModal($statusAction, $statusMessage); 
    }

    // Validate password length
    if (strlen($password) < 6) {
        $statusAction = "Try Again";
        $statusMessage = "Password must have 6 or more characters.";
        showErrorModal($statusAction, $statusMessage);
        
    }

    // Validate password match
    if ($password !== $retypePassword) {
        $statusAction = "Ooops!";
        $statusMessage = "Passwords do not match!";
        showErrorModal($statusAction, $statusMessage);
        
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
/*
    // Handle file upload for ID
    $id_upload = '';
    if (!empty($_FILES['id_upload']['name'])) {
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['id_upload']['name']);
        $id_upload = $uploadDir . $fileName;

        // Validate file type and size
        $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
        if (!in_array($_FILES['id_upload']['type'], $allowed_types)) {
            $statusAction = "Invalid File!";
            $statusMessage = "Only JPG, PNG, and PDF files are allowed.";
            showErrorModal($statusAction, $statusMessage);
        }

        if ($_FILES['id_upload']['size'] > 2000000) { // Limit to 2MB
            $statusAction = "File Too Large!";
            $statusMessage = "File size exceeds the limit of 2MB.";
            showErrorModal($statusAction, $statusMessage);
        }

        // Move uploaded file to the uploads directory
        if (!move_uploaded_file($_FILES['id_upload']['tmp_name'], $id_upload)) {
            $statusAction = "Upload Failed!";
            $statusMessage = "Failed to upload the file. Please try again.";
            showErrorModal($statusAction, $statusMessage);
        }
    }
*/
    // Insert affiliate details into the database
   // Insert for company
$query = "INSERT INTO " . $siteprefix . "users (
    title, display_name, first_name, middle_name, last_name, company_name, company_profile, company_logo, biography, profile_photo, age, gender, email_address, phone_number, skills_hobbies, language, proficiency, n_office_address, f_office_address, category, subcategory, facebook, instagram, twitter, linkedin, state, lga, country, address, type, status, trainer, password, last_login, created_date, reset_token, reset_token_expiry,affliate,loyalty,downloads,wallet,bank_name,bank_accname,bank_number
) VALUES (
    '', '$first_name $last_name', '$first_name', '$middle_name', '$last_name',
    '', '', '', '', '', '', '$gender', '$email', '$phone', '', '', '', '$address', '', '', '', '', '', '', '', '', '', '$country','',
    '$type', '$status', '0', '$hashedPassword', '$date', '$date', '', '', '$affiliate', '','','', '', '', ''
)";

if (mysqli_query($con, $query)) {
$user_id = mysqli_insert_id($con);

 // Send Welcome Email
 $emailSubject = "Welcome to the Learnora.ng Affiliate Program!";
$emailMessage = "
<p>Welcome to <strong>Learnora.ng</strong> — Nigeria’s premier online learning platform, offering high-quality courses tailored to learners across various fields, from tech and business to personal development.</p>
<p>As the demand for digital skills continues to rise, so does the potential to earn by sharing this powerful resource.</p>
<p><strong>Here’s what you can do as an affiliate:</strong></p>
<ol>
    <li>Log in to your affiliate dashboard to access your unique referral link and track your performance.</li>
    <li>Promote any course on our website using your referral link.</li>
    <li>Earn a commission for every successful enrollment made through your link—easy, transparent, and rewarding!</li>
</ol>
<p>If you ever need help, tips, or content to promote, feel free to reach out to our team at <a href='mailto:hello@learnora.ng'>hello@learnora.ng</a>. We're here to support your growth.</p>
<p>Thank you for partnering with us—we look forward to growing together!</p>
";
 sendEmail($email, $first_name, $siteName, $siteMail, $emailMessage, $emailSubject);

$statusAction = "Success!";
$message = "Affiliate registration successful! A confirmation email has been sent to $email.";
showSuccessModal($statusAction, $message); // Correctly pass the variable
header("refresh:1; url=$affiliateurl"); 
    } else {
        $statusAction = "Error!";
        $statusMessage = "There was an error registering the affiliate: " . mysqli_error($con);
        showErrorModal($statusAction, $statusMessage);
    }
}


//login user
if (isset( $_POST['signin'])){
    $code= $_POST['email'];
    $password = $_POST['password'];
          
   $sql = "SELECT * FROM ".$siteprefix."users WHERE type='user' AND status='active' AND email_address = '$code'";
    $sql2 = mysqli_query($con,$sql);
    if (mysqli_affected_rows($con) == 0){
    $statusAction="Try Again!";
    $statusMessage='Invalid Email address or Display Name!';
    showErrorModal($statusAction, $statusMessage);  
    }
                
    else {  
    while($row = mysqli_fetch_array($sql2)){
    $id = $row["s"]; 
    $hashedPassword = $row['password'];
    $status = $row['status'];
    $type = $row['type'];
    }
     
    if($type!='user'){
        $statusAction="Ooops!";
        $statusMessage='Invalid Credentials!';
        showErrorModal($statusAction, $statusMessage);  
    }

     else if (!checkPassword($password, $hashedPassword)) {
     $statusAction="Ooops!";
     $statusMessage='Incorrect Password for this account! <a href="forgot-password.php" style="color:red;">Forgot password? Recover here</a>';
     showErrorModal($statusAction, $statusMessage);  
    }
     
    
    else if($status == "inactive"){
        $statusAction="Ooops!";
        $statusMessage=' Email Address have not been verified. we have sent you a mail which contains verification link. kindly check your email and verify your email address.';
        showErrorModal($statusAction, $statusMessage);  
    }
    elseif ($status == "suspended") {
        // Check suspension details
        $suspend_query = "SELECT suspend_end FROM " . $siteprefix . "suspend WHERE user_id = '$id' ORDER BY suspend_end DESC LIMIT 1";
        $suspend_result = mysqli_query($con, $suspend_query);

        if ($suspend_result && mysqli_num_rows($suspend_result) > 0) {
            $suspend_row = mysqli_fetch_assoc($suspend_result);
            $suspend_end_date = $suspend_row['suspend_end'];

            // Check if the suspension has ended
            if (strtotime($suspend_end_date) <= time()) {
                // Update user status to active
                $update_status_query = "UPDATE " . $siteprefix . "users SET status = 'active' WHERE s = '$id'";
                mysqli_query($con, $update_status_query);

                // Proceed with login
                $date = date('Y-m-d H:i:s');
                $insert = mysqli_query($con, "UPDATE " . $siteprefix . "users SET last_login = '$date' WHERE s = '$id'") or die('Could not connect: ' . mysqli_error($con));

             
                $_SESSION['id'] = $id;
                setcookie("userID", $id, time() + (10 * 365 * 24 * 60 * 60));
                $message = "Logged In Successfully";

                showToast($message);

                // Redirection
                if (isset($_SESSION['previous_page'])) {
                    $previousPage = $_SESSION['previous_page'];
                    header("location: $previousPage");
                } else {
                    header("location: dashboard.php");
                }
            } else {
                // Suspension is still active
                $statusAction = "Account Suspended!";
                $statusMessage = "Your account is suspended until " . date('d M Y', strtotime($suspend_end_date)) . ". Please contact support for further assistance.";
                showErrorModal($statusAction, $statusMessage);
            }
        } else {
            // No suspension details found, fallback to error
            $statusAction = "Error!";
            $statusMessage = "Your account is suspended, but no suspension details were found. Please contact support.";
            showErrorModal($statusAction, $statusMessage);
        }
    } elseif ($status == "active") {
        // Proceed with login
        $date = date('Y-m-d H:i:s');
        $insert = mysqli_query($con, "UPDATE " . $siteprefix . "users SET last_login = '$date' WHERE s = '$id'") or die('Could not connect: ' . mysqli_error($con));

      
        $_SESSION['id'] = $id;
        setcookie("userID", $id, time() + (10 * 365 * 24 * 60 * 60));
        $message = "Logged In Successfully";

        showToast($message);

        // Redirection
        if (isset($_SESSION['previous_page'])) {
            $previousPage = $_SESSION['previous_page'];
            header("location: $previousPage");
        } else {
            header("location: dashboard.php");
        }
    }
}
}


// Add review
if (isset($_POST['submit-review'])) {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $training_id = mysqli_real_escape_string($con, $_POST['training_id']);
    $rating = mysqli_real_escape_string($con, $_POST['rating']);
    $review = mysqli_real_escape_string($con, trim($_POST['review']));

    // Check if user already has a review
    $check_query = "SELECT * FROM " . $siteprefix . "reviews WHERE user = '$user_id' AND training_id = '$training_id'";
    $result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // Update existing review
        $update_query = "UPDATE " . $siteprefix . "reviews 
                         SET rating = '$rating', review = '$review', date = NOW() 
                         WHERE user = '$user_id' AND training_id = '$training_id'";
        if (mysqli_query($con, $update_query)) {
            $statusAction = "Successful";
            $statusMessage = "Your review has been updated successfully!";
            showSuccessModal($statusAction, $statusMessage);
            header("refresh:1;"); 
        } else {
            $statusAction = "Error";
            $statusMessage = "An error occurred while updating your review. Please try again.";
            showErrorModal($statusAction, $statusMessage);
        }
    } else {
        // Insert new review
        $insert_query = "INSERT INTO " . $siteprefix . "reviews (training_id, user, rating, review, date) 
                         VALUES ('$training_id', '$user_id', '$rating', '$review', NOW())";
        if (mysqli_query($con, $insert_query)) {
            $statusAction = "Successful";
            $statusMessage = "Your review has been submitted successfully!";
            showSuccessModal($statusAction, $statusMessage);
            header("refresh:1;"); 
        } else {
            $statusAction = "Error";
            $statusMessage = "An error occurred while submitting your review. Please try again.";
            showErrorModal($statusAction, $statusMessage);
        }
    }
}




//manual payment
if (isset($_POST['submit_manual_payment'])) {
    $order_id = mysqli_real_escape_string($con, $_POST['order_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);
    $date = date('Y-m-d H:i:s');

    // Handle file upload
    if (isset($_FILES['proof_of_payment']) && $_FILES['proof_of_payment']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['proof_of_payment']['tmp_name'];
        $file_name = $_FILES['proof_of_payment']['name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];

        if (in_array($file_ext, $allowed_ext)) {
            $new_file_name = uniqid() . '.' . $file_ext;
            $upload_dir = 'uploads/'; // Subdirectory for payment proofs
            $upload_path = $upload_dir . $new_file_name;

            // Ensure the directory exists
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Insert payment proof into the database
                $query = "INSERT INTO " . $siteprefix . "manual_payments (order_id, user_id, amount, proof, status, date_created, rejection_reason) 
                          VALUES ('$order_id', '$user_id', '$amount', '$new_file_name', 'pending', '$date', '')";
                if (mysqli_query($con, $query)) {
                    // Update order status to pending
                    $update_order_query = "UPDATE " . $siteprefix . "orders SET status = 'pending' WHERE order_id = '$order_id'";
                    mysqli_query($con, $update_order_query);

                    // Fetch admin email
                    $admin_email = $siteMail; // Replace with your admin email variable
                    $admin_name = "Admin"; // Replace with your admin name variable

                    // Fetch user details
                    $user_query = "SELECT display_name, email_address FROM " . $siteprefix . "users WHERE s = '$user_id'";
                    $user_result = mysqli_query($con, $user_query);

                    if ($user_result && mysqli_num_rows($user_result) > 0) {
                        $user = mysqli_fetch_assoc($user_result);
                        $user_name = $user['display_name'];
                        $user_email = $user['email_address'];
                    } else {
                        $user_name = "Unknown User";
                        $user_email = "Unknown Email";
                    }

                    // Email content for admin
                    $emailSubject = "New Manual Payment Submitted";
                    $emailMessage = "
                        <p>A new manual payment has been submitted:</p>
                        <p><strong>Order ID:</strong> $order_id</p>
                        <p><strong>User:</strong> $user_name ($user_email)</p>
                        <p><strong>Amount:</strong> $sitecurrencyCode" . formatNumber($amount, 2) . "</p>
                        <p><strong>Date:</strong> $date</p>
                        <p>Please log in to the admin panel to verify the payment.</p>
                    ";

                    // Send email to admin
                    sendEmail($admin_email, $admin_name, $siteName, $siteMail, $emailMessage, $emailSubject);

                    // Success message for the user
                    $statusAction = "Success!";
                    $statusMessage = "Your payment proof has been submitted successfully. Your order is now pending verification.";
                    showSuccessModal($statusAction, $statusMessage);
                    header("refresh:2; url=checkout.php");
                
                } else {
                    $statusAction = "Error!";
                    $statusMessage = "An error occurred while submitting your payment proof. Please try again.";
                    showErrorModal($statusAction, $statusMessage);
                    header("refresh:2; url=checkout.php");
                    
                }
            } else {
                $statusAction = "Error!";
                $statusMessage = "Failed to upload the proof of payment. Please try again.";
                showErrorModal($statusAction, $statusMessage);
                header("refresh:2; url=checkout.php");
            
            }
        } else {
            $statusAction = "Error!";
            $statusMessage = "Invalid file type. Only JPG, JPEG, PNG, and PDF files are allowed.";
            showErrorModal($statusAction, $statusMessage);
            header("refresh:2; url=checkout.php");
          
        }
    } else {
        $statusAction = "Error!";
        $statusMessage = "No proof of payment uploaded. Please try again.";
        showErrorModal($statusAction, $statusMessage);
        header("refresh:2; url=checkout.php");
       
    }
}

//remove wishlist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_wishlist'])) {
    $remove_id = $_POST['remove_wishlist_id'];
    $user_id = $_POST['user_id'];

    mysqli_query($con, "DELETE FROM {$siteprefix}wishlist WHERE user='$user_id' AND product='$remove_id'");

    // Refresh the page
    echo "<script>location.href=location.href;</script>";
}



//add dispute
if (isset($_POST['create_dispute'])){
    $category = $_POST['category'];
    $recipient_id = $_POST['seller'];
    $contract_reference = $_POST['order_id'];
    $issue = mysqli_real_escape_string($con, $_POST['issue']);
    $ticket_number = "TKT" . time(); // Unique Ticket ID
    $page="ticket.php?ticket_number=$ticket_number";
    $date = date('Y-m-d H:i:s');

    //

    // Insert dispute into DB
    $sql = "INSERT INTO ".$siteprefix."disputes (user_id, recipient_id, ticket_number, category, order_reference, issue) 
            VALUES ('$user_id', '$recipient_id','$ticket_number', '$category', '$contract_reference', '$issue')";
    
    $fileKey = 'evidence';
    $uploadDir = 'uploads/';
    $reportImages = handleMultipleFileUpload($fileKey, $uploadDir);
    $uploadedFiles = [];

     
    $sql2 = "INSERT INTO ".$siteprefix."dispute_messages (dispute_id, sender_id, message, file) 
    VALUES ('$ticket_number', '$user_id', '$issue', '')";
    mysqli_query($con, $sql2);
    
    
    if (mysqli_query($con, $sql)) {
        $dispute_id = mysqli_insert_id($con); // Get the ID of the just inserted dispute
        foreach ($reportImages as $image) {
            $sql = "INSERT INTO ".$siteprefix."evidence (dispute_id, file_path, uploaded_at) VALUES ('$dispute_id', '$image', NOW())";
            if (mysqli_query($con, $sql)) {
                $uploadedFiles[] = $image;
            } else {
                $message .= "Error: " . mysqli_error($con);
            }
        }

        $emailSubject="Dispute Submitted Successfully – Ticket No:$ticket_number";

        $emailMessage = "
        <p>Thank you for submitting your dispute. We’ve received your request and assigned it the following ticket number: <strong>$ticket_number</strong>.</p>
        <p>Our support team will review the details and get back to you as soon as possible.</p>
        <p>Visit <a href='$siteurl'>ProjectReportHub.ng</a> to track your dispute status or explore more resources.</p>
        ";
        $adminmessage = "A new dispute has been submitted ($ticket_number)";
        $link="ticket.php?ticket_number=$ticket_number";
        $msgtype='New Dispute';
        $message_status=1;
        $emailMessage_admin="<p>Hello Dear Admin,a new dispute has been submitted!</p>";
        $emailSubject_admin="New Dispute";
        insertadminAlert($con, $adminmessage, $link, $date, $msgtype, $message_status);
        sendEmail($email_address, $display_name, $siteName, $siteMail, $emailMessage, $emailSubject);
        sendEmail($siteMail, $adminName, $siteName, $siteMail, $emailMessage_admin, $emailSubject_admin);
    
            if($recipient_id){
            $rDetails = getUserDetails($con, $siteprefix, $recipient_id);
            $r_email = $rDetails['email_address'];
            $r_name = $rDetails['display_name'];
            $r_emailSubject="New Dispute ($ticket_number)";
            $r_emailMessage="<p>A new dispute has been submitted with you as the recipient. Login to your dashboard to check</p>";
           sendEmail($r_email, $r_name, $siteName, $siteMail, $r_emailMessage, $r_emailSubject);
           $message = "A new dispute has been submitted with you as the recipient: " . $ticket_number;
           $status=0;
           insertAlert($con, $recipient_id, $message, $date, $status);
        }

       $message= "Dispute submitted successfully. Ticket ID: " . $ticket_number;
       showSuccessModal('Success', $message);
       header("refresh:2; url=$page");
    } else {
       $message="Error: " . mysqli_error($con);
       showErrorModal('Oops', $message);
    }}

//updateproof
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_proof'])) {
    $order_id = mysqli_real_escape_string($con, $_POST['order_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $date = date('Y-m-d H:i:s');

    // Handle file upload
    if (isset($_FILES['proof_of_payment']) && $_FILES['proof_of_payment']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['proof_of_payment']['tmp_name'];
        $file_name = $_FILES['proof_of_payment']['name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION); // File extension (optional, no validation here)
        $new_file_name = uniqid() . '.' . $file_ext;
        $upload_dir = 'uploads/'; // Subdirectory for payment proofs
        $upload_path = $upload_dir . $new_file_name;

        // Ensure the directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($file_tmp, $upload_path)) {
            // Update the proof of payment in the database
            $update_query = "UPDATE " . $siteprefix . "manual_payments 
                             SET proof = '$new_file_name', status = 'pending', date_created = '$date' 
                             WHERE order_id = '$order_id' AND user_id = '$user_id'";
            if (mysqli_query($con, $update_query)) {
                // Fetch admin email
                $admin_email = $siteMail; // Replace with your admin email variable
                $admin_name = $sitename; // Replace with your admin name variable

                // Fetch user details
                $user_query = "SELECT display_name, email_address FROM " . $siteprefix . "users WHERE s = '$user_id'";
                $user_result = mysqli_query($con, $user_query);

                if ($user_result && mysqli_num_rows($user_result) > 0) {
                    $user = mysqli_fetch_assoc($user_result);
                    $user_name = $user['display_name'];
                    $user_email = $user['email_address'];
                } else {
                    $user_name = "Unknown User";
                    $user_email = "Unknown Email";
                }

                // Email content for admin
                $emailSubject = "Payment Resent for Order #$order_id";
                $emailMessage = "
                    <p>A payment has been resent:</p>
                    <p><strong>Order ID:</strong> $order_id</p>
                    <p><strong>User:</strong> $user_name ($user_email)</p>
                    <p><strong>Date:</strong> $date</p>
                    <p>Please log in to the admin panel to verify the payment.</p>
                ";

                // Send email to admin
                sendEmail($admin_email, $admin_name, $siteName, $siteMail, $emailMessage, $emailSubject);

                // Success message for the user
                $statusAction = "Success!";
                $statusMessage = "Proof of payment updated successfully. The admin has been notified.";
                showSuccessModal($statusAction, $statusMessage);
                header("refresh:2;");
                
            } else {
                // Database update error
                $statusAction = "Error!";
                $statusMessage = "An error occurred while updating the proof of payment.";
                showErrorModal($statusAction, $statusMessage);
                header("refresh:2;");
                
            }
        } else {
            // File upload error
            $statusAction = "Error!";
            $statusMessage = "Failed to upload the proof of payment. Please try again.";
            showErrorModal($statusAction, $statusMessage);
            header("refresh:2;");
            
        }
    } else {
        // No file uploaded
        $statusAction = "Error!";
        $statusMessage = "No proof of payment uploaded. Please try again.";
        showErrorModal($statusAction, $statusMessage);
        header("refresh:2;");
        
    }
}



//withdrawwallet
if (isset($_POST['withdraw'])){
$date=$currentdatetime;
$bank=$_POST['bank'];
$bankname=$_POST['bankname'];
$bankno=$_POST['bankno'];
$amount=$_POST['amount'];
$status="pending";


$emailMessage="<p>We are writing to confirm that we have successfully received your withdrawal request in the amount of $sitecurrency$amount.<br>
Please note that your request is currently being processed and is expected to be completed within the next twenty-four (24) hours. Once the transaction has been finalized, you will receive a confirmation notification.<br>
Should you have any questions or require further assistance, please do not hesitate to contact our support team.<br>
Thank you for choosing our services.</p>";
$footer="<p>Warm regards,<br>
Ikechukwu Anaekwe<br>
Project Report Hub (Customer Support Team).</p>";

insertWithdraw($con, $user_id, $amount,$bank, $bankname, $bankno, $date, $status);
$emailSubject="Withdrawal Request - Recieved";
$emailMessage_admin="<p>A new withdrawal request has been recieved for ₦$amount. Please login into your dashboard to process it</p>";
$adminmessage = "New Withdrawal Request - &#8358;$amount";
$link="withdrawals.php";
$msgtype='New Withdrawal';
$message_status=1;
insertadminAlert($con, $adminmessage, $link, $date, $msgtype, $message_status); 
sendEmail($email, $display_name, $siteName, $siteMail, $emailMessage, $emailSubject);
sendEmail($siteMail, $adminName, $siteName, $siteMail, $emailMessage_admin, $emailSubject);
    
   
$statusAction="Successful";
$statusMessage="Withdrawal Request Sent Sucessfully!";
showSuccessModal($statusAction,$statusMessage);
header("Refresh: 4; url=wallet.php");
}


if(isset($_POST['update-profile'])){
    // Personal Details
     $uploadDir = 'uploads/';
      $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
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
    $language = mysqli_real_escape_string($con, $_POST['language'] ?? '');
    $bank_name = mysqli_real_escape_string($con, $_POST['bank_name']);
    $bank_accname = mysqli_real_escape_string($con, $_POST['bank_accname']);
    $bank_number = mysqli_real_escape_string($con, $_POST['bank_number']);
    $proficiency = mysqli_real_escape_string($con, $_POST['proficiency'] ?? '');
    $facebook = mysqli_real_escape_string($con, $_POST['facebook'] ?? '');
    $instagram = mysqli_real_escape_string($con, $_POST['instagram'] ?? '');
    $twitter = mysqli_real_escape_string($con, $_POST['twitter'] ?? '');
    $linkedin = mysqli_real_escape_string($con, $_POST['linkedin'] ?? '');
    $trainers = !empty($_POST['register_as_trainer']) ? 1 : 0;
    // Company Details
    $companyName = mysqli_real_escape_string($con, $_POST['company-name'] ?? '');
    $companyProfile = mysqli_real_escape_string($con, $_POST['company-profile'] ?? '');
    $nigeriaOffice = mysqli_real_escape_string($con, $_POST['nigeria-office'] ?? '');
    $foreignOffice = mysqli_real_escape_string($con, $_POST['foreign-office'] ?? '');
    $category = isset($_POST['category']) && is_array($_POST['category']) ? implode(',', $_POST['category']) : '';
    $subcategory = isset($_POST['subcategory']) && is_array($_POST['subcategory']) ? implode(',', $_POST['subcategory']) : '';
    $password = $_POST['password'];
    $retypePassword = $_POST['retypePassword'];


        // Address logic
    $is_nigerian = $_POST['is_nigerian'] ?? '';
    $nigeriaOffice = mysqli_real_escape_string($con, $_POST['nigeria-office'] ?? '');
    $state = mysqli_real_escape_string($con, $_POST['state'] ?? '');
    $lga = mysqli_real_escape_string($con, $_POST['lga'] ?? '');
    $country_ng = mysqli_real_escape_string($con, $_POST['country_ng'] ?? 'Nigeria');
    $foreignOffice = mysqli_real_escape_string($con, $_POST['foreign-office'] ?? '');
    $country_foreign = mysqli_real_escape_string($con, $_POST['country_foreign'] ?? '');

    // Determine which address/country to use
    if ($is_nigerian === 'yes') {
        $n_office_address = $nigeriaOffice;
        $f_office_address = '';
        $country = $country_ng;
    } else {
        $n_office_address = '';
        $f_office_address = $foreignOffice;
        $country = $country_foreign;
        $state = '';
        $lga = '';
    }

    // Password change
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $retypePassword = !empty($_POST['retypePassword']) ? trim($_POST['retypePassword']) : null;
    $oldPassword = !empty($_POST['oldpassword']) ? trim($_POST['oldpassword']) : null;
    $hashedPassword = null;

    if (!empty($password) || !empty($retypePassword) || !empty($oldPassword)) {
        if (empty($password) || empty($retypePassword) || empty($oldPassword)) {
           echo "<script>
            alert('All password fields (Password, Retype Password, and Old Password) must be filled out.');
            window.history.back(); // Go back to previous form state
        </script>";
        exit;
            
        }
        if ($password !== $retypePassword) {
            echo "<script>
            alert('New password and retype password do not match.');
            window.history.back(); // Go back to previous form state
        </script>";
            exit;
        }
        $stmt = $con->prepare("SELECT password FROM {$siteprefix}users WHERE s = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        if (!$user || !password_verify($oldPassword, $user['password'])) {
            
            echo "<script>
            alert('Old password is incorrect.');
            window.history.back(); // Go back to previous form state
        </script>";
        exit;
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }


// === Handle Company Profile Picture Upload ===
$companyProfilePicture = $_FILES['company_profile_picture']['name'] ?? '';

if (!empty($companyProfilePicture)) {
    $fileKey = 'company_profile_picture';
    $companyProfilePicture = handleFileUpload($fileKey, $uploadDir, $companyProfilePicture);
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


$passwordSql = $hashedPassword ? "password = '" . mysqli_real_escape_string($con, $hashedPassword) . "'," : "";
$update_query = "UPDATE {$siteprefix}users SET
    title = '$title',
    display_name = '$firstName $lastName',
    first_name = '$firstName',
    middle_name = '$middleName',
    last_name = '$lastName',
    company_name = '$companyName',
    company_profile = '$companyProfile',
    company_logo = '$companyProfilePicture',
    biography = '$profile',
    profile_photo = '$profilePicture',
    age = '$age',
    gender = '$gender',
    bank_name = '$bank_name',
    bank_accname = '$bank_accname',
    bank_number = '$bank_number',
    email_address = '$email',
    phone_number = '$phone',
    skills_hobbies = '$skills',
      $passwordSql
    language = '$language',
    proficiency = '$proficiency',
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
        country = '$country',
        address = '$address'
   WHERE s = '$user_id'";

 if (mysqli_query($con, $update_query)) {
     if($trainers == 1){
            echo header("location:trainer.php?user_login=$user_id");
        }
        else{
        showSuccessModal("Success!", "Profile updated successfully!");
        header("refresh:1; url=settings.php");
        }
   
    } else {
        showErrorModal("Error!", "Failed to update profile: " . mysqli_error($con));
    }
}

//upload answer
if (isset($_POST['submit-upload-answer'])) {
    $quiz_id = $_POST['quiz_id'] ?? '';
    $user_id = $_POST['user_id'] ?? '';
    $file = $_FILES['answer_file']['name'] ?? '';

    $uploadDirs="answers/";
    if (!$quiz_id || !$user_id) {
        showErrorModal("Unauthorized", "You must be logged in and have a valid quiz.");
        exit;
    }

    if (!empty($file)) {
        $fileKey = 'answer_file';
        $filePath = handleFileUpload($fileKey, $uploadDirs, $file);

        $sql = "INSERT INTO {$siteprefix}quiz_answers (quiz_id, user_id, answer_file, answer_text, score, submitted_at) 
                VALUES ('$quiz_id', '$user_id', '$filePath','','', NOW())";

        if (mysqli_query($con, $sql)) {
            showSuccessModal("✅ Success!", "Your file has been submitted successfully!");
            header("refresh:1;");
        } else {
            showErrorModal("❌ Error!", "Failed to submit your answer: " . mysqli_error($con));
            header("refresh:1;");
        }
    } else {
        showErrorModal("⚠️ Missing File", "Please upload a valid file before submitting.");
        header("refresh:1;");
    }
}

//upload answer
if (isset($_POST['submit-text-answer'])) {
    $quiz_id = $_POST['quiz_id'] ?? '';
    $user_id = $_POST['user_id'] ?? '';
    $textanswer = $_POST['answer_text'];

    if (!$quiz_id || !$user_id) {
        showErrorModal("Unauthorized", "You must be logged in and have a valid quiz.");
        exit;
    }

    if (!empty($textanswer)) {
        $sql = "INSERT INTO {$siteprefix}quiz_answers (quiz_id, user_id, answer_file, answer_text, score, submitted_at) 
                VALUES ('$quiz_id', '$user_id', '','$textanswer','', NOW())";

        if (mysqli_query($con, $sql)) {
            showSuccessModal("✅ Success!", "Your file has been submitted successfully!");
            header("refresh:1;");
        } else {
            showErrorModal("❌ Error!", "Failed to submit your answer: " . mysqli_error($con));
            header("refresh:1;");
        }
    } else {
        showErrorModal("⚠️ Missing File", "Please upload a valid file before submitting.");
        header("refresh:1;");
    }
}

if (isset($_POST['submit-quiz'])) {
$user_id = $_SESSION['user_id'] ?? null;
$quiz_id = $_POST['quiz_id'];
$user_answers = $_POST['answer'] ?? [];

if (!$user_id || !$quiz_id) {
    echo "<p class='text-danger'>Invalid session or quiz ID.</p>";
    exit;
}

// Fetch quiz questions
$questions_sql = "SELECT * FROM {$siteprefix}training_quiz_questions WHERE quiz_id = $quiz_id";
$questions_result = mysqli_query($con, $questions_sql);

$score = 0;
$total = mysqli_num_rows($questions_result);
$feedback = [];

while ($q = mysqli_fetch_assoc($questions_result)) {
    $qid = $q['id'];
    $correct = strtolower($q['correct_answer']);
    $user_answer = strtolower($user_answers[$qid] ?? '');

    $is_correct = ($user_answer === $correct);
    if ($is_correct) {
        $score++;
    }

    $feedback[] = [
        'question' => $q['question'],
        'user_answer' => strtoupper($user_answer),
        'correct_answer' => strtoupper($correct),
        'is_correct' => $is_correct,
        'options' => [
            'A' => $q['option_a'],
            'B' => $q['option_b'],
            'C' => $q['option_c'],
            'D' => $q['option_d'],
        ]
    ];
}

// Insert score into quiz_answers
$check = mysqli_query($con, "SELECT * FROM {$siteprefix}quiz_answers WHERE quiz_id = '$quiz_id' AND user_id = '$user_id'");
if (mysqli_num_rows($check) > 0) {
    // Optional: update if already exists
    mysqli_query($con, "UPDATE {$siteprefix}quiz_answers SET score = '$score', submitted_at = NOW() WHERE quiz_id = '$quiz_id' AND user_id = '$user_id'");
} else {
    // Insert new score
    mysqli_query($con, "INSERT INTO {$siteprefix}quiz_answers (quiz_id, user_id, answer_file, answer_text, score, submitted_at) 
                        VALUES ('$quiz_id', '$user_id', '', '', '$score', NOW())");
}

// Output Result
header("Location: view-result.php?quiz_id=$quiz_id");


}

if (isset($_POST['send_dispute_message'])) {
        $dispute_id = $_POST['dispute_id'];
        $sender_id = $user_id; // Assume logged-in user
        $message = mysqli_real_escape_string($con, $_POST['message']);
        $page = "ticket.php?ticket_number=$dispute_id";
        $new_status = "awaiting-response";

        $fileKey = 'attachment';
        $uploadDir = 'uploads/';
        $reportImages = handleMultipleFileUpload($fileKey, $uploadDir);
        $uploadedFiles =  implode(', ', $reportImages);
        if (empty($_FILES[$fileKey]['name'][0])) {
            $uploadedFiles = '';
        }

        
        $sql = "INSERT INTO ".$siteprefix."dispute_messages (dispute_id, sender_id, message, file) 
            VALUES ('$dispute_id', '$sender_id', '$message', '$uploadedFiles')";
            
       
        if (mysqli_query($con, $sql)) {

        // Then call the function where needed:
        notifyDisputeRecipient($con, $siteprefix, $dispute_id);
        $date = date('Y-m-d H:i:s');
        $status = 0;
        $message = "A new message has been sent on dispute $dispute_id";
        $link = "ticket.php?ticket_number=$dispute_id";
        $msgtype = "Dispute Update";
        insertadminAlert($con, $message, $link, $date, $msgtype, $status);
        updateDisputeStatus($con, $siteprefix, $dispute_id, $new_status);
        showToast("Message sent successfully!");

        } else {
        $message = "Error: " . mysqli_error($con);
        showErrorModal('Oops', $message);
        }
    }


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
    header("refresh:2; url=$page");
}




if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_event'])) {

        // Directories for uploads
    $uploadDir = 'uploads/';
    $fileuploadDir = 'documents/';
  
    $message = "";
    $physical_address = $physical_state = $physical_lga = $physical_country = $foreign_address = '';
    $web_address = '';
    $hybrid_physical_address = $hybrid_web_address = $hybrid_state = $hybrid_lga = $hybrid_country = $hybrid_foreign_address = '';

    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $category = implode(',', $_POST['category']);
    $subcategory = implode(',', $_POST['subcategory']);
    $event_type = mysqli_real_escape_string($con, $_POST['event_type']);
    $attendee = mysqli_real_escape_string($con, $_POST['who_should_attend']);
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

if ($_POST['pricing'] === 'paid') {
    $ticket_ids = $_POST['ticket_ids'];
    $ticket_names = $_POST['ticket_name'];
    $ticket_benefits = $_POST['ticket_benefits'];
    $ticket_prices = $_POST['ticket_price'];
    $ticket_seats = $_POST['ticket_seats'];

    foreach ($ticket_names as $index => $name) {
        $ticket_id = intval($ticket_ids[$index]); // This will be 0 if empty
        $name = mysqli_real_escape_string($con, $name);
        $benefits = mysqli_real_escape_string($con, $ticket_benefits[$index]);
        $price = floatval($ticket_prices[$index]);
        $seats = intval($ticket_seats[$index]);

        if ($ticket_id > 0) {
            // Update existing ticket
            mysqli_query($con, "UPDATE {$siteprefix}training_tickets 
                SET ticket_name = '$name', benefits = '$benefits', price = '$price', seats = '$seats', seatremain = '$seats'
                WHERE s = '$ticket_id' AND training_id = '$training_id'");
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
    $logopromo_video = handleFileUpload($fileKey, $uploadDir, $fileName);

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
    $logotrailer_video = handleFileUpload($fileKey, $fileuploadDir, $fileName);

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
            tags = '$tags'
        WHERE training_id = '$training_id'");
if ($updateTraining) {
    $statusAction = "Success!";
    $statusMessage = "Training updated successfully.";
    showSuccessModal2($statusAction, $statusMessage);

    header("refresh:2; url=models.php"); // ✅ Change to the desired redirect page

} else {
    $statusAction = "Error!";
    $statusMessage = "Failed to update training. Please try again.";
    showErrorModal2($statusAction, $statusMessage);

    header("refresh:2; url=models.php"); // ✅ Optional: change this to a retry page
  
}

}

// Insert into table and send mail
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_request'])) {
    $seminar_title = mysqli_real_escape_string($con, $_POST['seminar_title']);
    $days = mysqli_real_escape_string($con, $_POST['days']);
    $participants = mysqli_real_escape_string($con, $_POST['participants']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $position = mysqli_real_escape_string($con, $_POST['position']);
    $company = mysqli_real_escape_string($con, $_POST['company']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $comment = mysqli_real_escape_string($con, $_POST['comment']);
    $training = mysqli_real_escape_string($con, $_POST['training']);

    // Insert into inhouse_proposals table (create this table if not exists)
    $insert_sql = "INSERT INTO {$siteprefix}inhouse_proposals 
        (training_id, seminar_title, days, participants, name, position, company, address, city, country, email, phone, mobile, comment, created_at)
        VALUES 
        ('$training', '$seminar_title', '$days', '$participants', '$name', '$position', '$company', '$address', '$city', '$country', '$email', '$phone', '$mobile', '$comment', NOW())";
    $insert_result = mysqli_query($con, $insert_sql);

    if ($insert_result) {
  // Email content for admin
                $emailSubject = "In-House Training Proposal Request: $seminar_title";
                $emailMessage = "
                    <p>A new in-house training proposal has been submitted:</p>
                    <p><strong>Seminar Title:</strong> $seminar_title</p>
                    <p><strong>Days:</strong> $days</p>
                    <p><strong>Participants:</strong> $participants</p>
                    <p><strong>Name:</strong> $name</p>
                    <p><strong>Position:</strong> $position</p>
                    <p><strong>Company:</strong> $company</p>
                    <p><strong>Address:</strong> $address</p>
                    <p><strong>City:</strong> $city</p>
                    <p><strong>Country:</strong> $country</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Phone:</strong> $phone</p>
                    <p><strong>Mobile:</strong> $mobile</p>
                    <p><strong>Comment:</strong> $comment</p>
                    <p>Please log in to the admin panel to verify the payment.</p>
                ";
                // Send email to admin
                sendEmail($siteMail, $sitename, $siteName, $siteMail, $emailMessage, $emailSubject);
                 sendEmail($siteMail, $adminName, $siteName, $siteMail, $emailMessage, $emailSubject);

                 showSuccessModal("Success!", "In-House Training Proposal submitted successfully!");
                    header("refresh:1; url=marketplace.php");


    }
    else {
        showErrorModal("Error!", "Failed to submit proposal: " . mysqli_error($con));
    }
}


    ?>