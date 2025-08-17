<?php
include "backend/connect.php";

function getSubcategories($parentIds, $con, $siteprefix) {
  $allSubcategories = [];
  $queue = $parentIds;

  while (!empty($queue)) {
    $safe_ids = array_map(function($id) use ($con) {
      return "'" . mysqli_real_escape_string($con, trim($id)) . "'";
    }, $queue);

    $id_list = implode(',', $safe_ids);
    $query = "SELECT id, category_name AS title, parent_id FROM " . $siteprefix . "categories WHERE parent_id IN ($id_list)";
    $result = mysqli_query($con, $query);

    $queue = []; // Prepare for next level
    while ($row = mysqli_fetch_assoc($result)) {
      $allSubcategories[] = [
        's' => $row['id'],
        'title' => $row['title'],
        'parent_id' => $row['parent_id']
      ];
      $queue[] = $row['id']; // Add for next recursion
    }
  }
  return $allSubcategories;
}

if (isset($_GET['parent_ids'])) {
  $ids = explode(',', $_GET['parent_ids']);
  $subcategories = getSubcategories($ids, $con, $siteprefix);

  header('Content-Type: application/json');
  echo json_encode($subcategories);
}
?>
