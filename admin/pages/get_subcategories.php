<?php
include "../../backend/connect.php";

if (isset($_GET['parent_id'])) {
  $parent_id = intval($_GET['parent_id']);

  $query = "SELECT id, category_name FROM {$siteprefix}categories WHERE parent_id = $parent_id";
  $result = mysqli_query($con, $query);

  $subcategories = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $subcategories[] = [
      'id' => $row['id'],
      'title' => $row['category_name']
    ];
  }

  header('Content-Type: application/json');
  echo json_encode($subcategories);
}
?>
