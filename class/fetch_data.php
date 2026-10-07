<?php
// Include your database connection file
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../inc/auth.php';

// Query to fetch data
$query = "SELECT assettype, COUNT(*) AS count FROM assets_tbl GROUP BY assettype";

$result = mysqli_query($db->conn, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Close the connection
mysqli_close($db->conn);

// Return the data as JSON
echo json_encode($data);
?>