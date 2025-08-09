

<?php
include "backend/connect.php"; 
$siteprefix="ln_";
$action = $_GET['action'];


if($action == 'deleteimage'){
    // Fetch the image file name
    $image_id = $_GET['image_id'];
    $query = "SELECT picture FROM ".$siteprefix."training_images WHERE s = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $image = $result->fetch_assoc();
    $stmt->close();

    if ($image) {
        // Delete the image file from the server
        $file_path = 'uploads/' . $image['picture'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Delete the image record from the database
        $delete_query = "DELETE FROM ".$siteprefix."training_images WHERE s = ?";
        $delete_stmt = $con->prepare($delete_query);
        $delete_stmt->bind_param("i", $image_id);
        $delete_stmt->execute();
        $delete_stmt->close();

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Image not found.']);
    }
} 


// Check if the correct action is provided
if (isset($_GET['action']) && $_GET['action'] === 'deletevideo' && isset($_GET['video_id'])) {
    $video_id = intval($_GET['video_id']);
    $query = "DELETE FROM {$siteprefix}training_video_lessons WHERE s = ?";
    $stmt = $con->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $video_id);
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error: could not execute query";
        }
        $stmt->close();
    } else {
        echo "error: invalid SQL statement";
    }
} else {
    echo "error: invalid request";
}





// Check if the correct action is provided
if (isset($_GET['action']) && $_GET['action'] === 'deletevideotrailer' && isset($_GET['video_id'])) {
    $video_id = intval($_GET['video_id']);
    $query = "DELETE FROM {$siteprefix}training_videos WHERE s = ?";
    $stmt = $con->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $video_id);
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error: could not execute query";
        }
        $stmt->close();
    } else {
        echo "error: invalid SQL statement";
    }
} else {
    echo "error: invalid request";
}

if (isset($_GET['action']) && $_GET['action'] === 'deletevideomodule' && !empty($_GET['module_id'])) {
    $moduleId = intval($_GET['module_id']);

    $stmt = $con->prepare("DELETE FROM {$siteprefix}training_video_modules WHERE id = ?");
    $stmt->bind_param("i", $moduleId);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Failed to delete module.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}


if ($_GET['action'] === 'deletetextmodule' && !empty($_GET['module_id'])) {
    $id = intval($_GET['module_id']);
    $stmt = $con->prepare("DELETE FROM {$siteprefix}training_texts_modules WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
    $stmt->close();
    exit;
}


// Check if the correct action is provided
if (isset($_GET['action']) && $_GET['action'] === 'deletevideopromo' && isset($_GET['video_id'])) {
    $video_id = intval($_GET['video_id']);
    $query = "DELETE FROM {$siteprefix}training_videos WHERE s = ?";
    $stmt = $con->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $video_id);
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error: could not execute query";
        }
        $stmt->close();
    } else {
        echo "error: invalid SQL statement";
    }
} else {
    echo "error: invalid request";
}

if (isset($_GET['action']) && $_GET['action'] === 'deletetext') {
    $textId = intval($_GET['text_id'] ?? 0);

    if ($textId <= 0) {
        echo 'Invalid ID';
        exit;
    }

    $sql = "DELETE FROM {$siteprefix}training_text_modules WHERE id = $textId";
    if (mysqli_query($con, $sql)) {
        echo 'success';
    } else {
        echo 'Delete failed: ' . mysqli_error($conn);
    }

    exit;
}





?>