<?php
include "backend/connect.php";

echo "=== Current ln_training table structure ===\n";
$result = mysqli_query($con, "DESCRIBE ln_training");
while ($row = mysqli_fetch_assoc($result)) {
    if (stripos($row['Field'], 'title') !== false) {
        echo "Field: " . $row['Field'] . "\n";
        echo "Type: " . $row['Type'] . "\n";
        echo "Null: " . $row['Null'] . "\n";
        echo "Key: " . $row['Key'] . "\n";
        echo "Default: " . $row['Default'] . "\n";
        echo "Extra: " . $row['Extra'] . "\n";
        echo "-----------------------------------\n";
    }
}

// Check current max length usage
echo "\n=== Current title length usage ===\n";
$result = mysqli_query($con, "SELECT MAX(LENGTH(title)) as max_length, AVG(LENGTH(title)) as avg_length FROM ln_training WHERE title IS NOT NULL");
$row = mysqli_fetch_assoc($result);
echo "Max length used: " . $row['max_length'] . " characters\n";
echo "Average length: " . round($row['avg_length'], 2) . " characters\n";
?>
