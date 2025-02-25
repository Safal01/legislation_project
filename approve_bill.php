<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || !isset($_GET['action'])) {
    echo "Invalid request!";
    exit();
}

$bill_id = $_GET['id'];
$action = $_GET['action'];

$check_sql = "SELECT status FROM bills WHERE bill_id='$bill_id'";
$result = $conn->query($check_sql);
$row = $result->fetch_assoc();

if (!$row) {
    echo "<p style='color:red;'>Bill not found!</p>";
    exit();
}

$status = $row['status']; 

if ($action == 'approve') {
    if ($status == 'Draft') {
        $new_status = 'Review';  
    } elseif ($status == 'Review') {
        $new_status = 'Approved'; 
    } else {
        echo "<p style='color:red;'>This bill cannot be approved.</p>";
        exit();
    }
} elseif ($action == 'reject') {
    $new_status = 'Rejected';
} else {
    echo "Invalid action!";
    exit();
}

$update_sql = "UPDATE bills SET status='$new_status' WHERE bill_id='$bill_id'";
if ($conn->query($update_sql) === TRUE) {
    echo "<p style='color:green;'>Bill " . ucfirst($new_status) . " successfully!</p>";
} else {
    echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
}
?>

<link rel="stylesheet" href="css/styles.css">
<a href="view_bills.php">Back to Bills</a>
