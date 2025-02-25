<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

echo "<h2>All Bills Report</h2>";
$bills_sql = "SELECT * FROM bills";
$bills_result = $conn->query($bills_sql);

echo "<table border='1'>";
echo "<tr><th>Bill ID</th><th>Title</th><th>Description</th><th>Author</th><th>Status</th></tr>";
while ($row = $bills_result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['bill_id']}</td>
            <td>{$row['bill_title']}</td>
            <td>{$row['bill_description']}</td>
            <td>{$row['author']}</td>
            <td>{$row['status']}</td>
          </tr>";
}
echo "</table>";

echo "<h2>All Votes Report</h2>";
$votes_sql = "SELECT * FROM votes";
$votes_result = $conn->query($votes_sql);

echo "<table border='1'>";
echo "<tr><th>Vote ID</th><th>Bill ID</th><th>MP Name</th><th>Vote Choice</th></tr>";
while ($row = $votes_result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['vote_id']}</td>
            <td>{$row['bill_id']}</td>
            <td>{$row['mp_name']}</td>
            <td>{$row['vote_choice']}</td>
          </tr>";
}
echo "</table>";

?>
<link rel="stylesheet" href="css/styles.css">

<a href="dashboard.php">Back to Dashboard</a>
<?php


