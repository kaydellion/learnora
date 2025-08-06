<?php
include "backend/connect.php";

if (isset($_GET['parent_ids'])) {
  $ids = explode(',', $_GET['parent_ids']);
  $safe_ids = array_map(function($id) use ($con) {
    return "'" . mysqli_real_escape_string($con, trim($id)) . "'";
  }, $ids);

  $id_list = implode(',', $safe_ids);
  $query = "SELECT id, category_name AS title, parent_id FROM " . $siteprefix . "categories WHERE parent_id IN ($id_list)";
  $result = mysqli_query($con, $query);

  $subcategories = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $subcategories[] = [
      's' => $row['id'],
      'title' => $row['title'],
      'parent_id' => $row['parent_id']
    ];
  }

  header('Content-Type: application/json');
  echo json_encode($subcategories);
}
?>
