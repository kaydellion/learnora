<?php
include "backend/connect.php";

if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);

    $stmt = $con->prepare("SELECT name, bio, photo FROM {$siteprefix}instructors WHERE s = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name, $bio, $photo);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        echo json_encode([
            "success" => true,
            "name" => $name,
            "bio" => $bio,
            "photo" => $siteurl . "uploads/" . $photo
        ]);
    } else {
        echo json_encode(["success" => false]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false]);
}
?>
