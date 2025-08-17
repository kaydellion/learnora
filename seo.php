<?php
$db_username = "projectr_learnorastore"; 
$db_pass = "Y34GgwK(]h82Yg"; 
$db_name = "projectr_learn";
$conn = mysqli_connect ("$db_host","$db_username","$db_pass","$db_name");

if (isset($_GET['slugs'])|| isset($_GET['slug'])) {
    if (isset($_GET['slug'])) {
        $raw_slug = $_GET['slug'];
    } else {
        $raw_slug = $_GET['slugs'];
    }
    $title_like = str_replace('-', ' ', $raw_slug);
    $category_name = mysqli_real_escape_string($conn, ucwords($title_like));
}

$page_title = $category_name;

?>