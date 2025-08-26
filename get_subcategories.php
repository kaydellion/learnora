<?php
include "backend/connect.php";

function buildTree($parentIds, $con, $siteprefix) {
  $tree = [];

  foreach ($parentIds as $parentId) {
    $safe_id = mysqli_real_escape_string($con, trim($parentId));
    $query = "SELECT id, category_name FROM {$siteprefix}categories WHERE parent_id = '$safe_id'";
    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_assoc($result)) {
      $children = buildTree([$row['id']], $con, $siteprefix);
      $tree[] = [
        's' => $row['id'],
        'title' => $row['category_name'],
        'children' => $children
      ];
    }
  }

  return $tree;
}

if (isset($_GET['parent_ids'])) {
  $ids = explode(',', $_GET['parent_ids']);
  $subcategories = buildTree($ids, $con, $siteprefix);

  header('Content-Type: application/json');
  echo json_encode($subcategories);
}
?>