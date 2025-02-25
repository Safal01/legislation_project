<?php
session_start();
include "db_connect.php"; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'] ?? ''; 

$sql = "SELECT * FROM bills ORDER BY created_at DESC";
$result = $conn->query($sql);

echo "<h2>All Bills</h2>";

while ($row = $result->fetch_assoc()) {
    echo "<h3>" . $row['bill_title'] . "</h3>";
    echo "<p>" . $row['bill_description'] . "</p>";
    echo "<p><strong>Author:</strong> " . $row['author'] . "</p>";
    echo "<p><strong>Status:</strong> " . $row['status'] . "</p>";

    // Legislators can edit their own draft bills
    if ($row['author'] == $username && $row['status'] == 'Draft') {
        echo "<a href='edit_bill.php?id=" . $row['bill_id'] . "'>Edit</a><br>";
    }

    // Reviewers can suggest amendments for bills under review
    if ($role == 'Reviewer' && $row['status'] == 'Review') {
        echo "<a href='suggest_amendment.php?id=" . $row['bill_id'] . "'>Suggest Amendment</a><br>";
    }

    // Admins can approve/reject bills
    if ($role == 'Admin') {
        if ($row['status'] == 'Draft') {
            echo "<a href='approve_bill.php?id=" . $row['bill_id'] . "&action=approve'>Move to Review</a><br>";
        } elseif ($row['status'] == 'Review') {
            echo "<a href='approve_bill.php?id=" . $row['bill_id'] . "&action=approve'>Approve</a> | ";
            echo "<a href='approve_bill.php?id=" . $row['bill_id'] . "&action=reject'>Reject</a><br>";
        }
    }

    // MPs can vote on Approved bills
    if ($role == 'Legislator' && $row['status'] == 'Approved') {
        echo "<a href='vote_bill.php?id=" . $row['bill_id'] . "'>Vote on Bill</a><br>";
    }

    // Show voting results if the bill is Approved
    if ($row['status'] == 'Approved') {
        $bill_id = $row['bill_id'];

        // Counting votes
        $vote_count_sql = "SELECT vote_choice, COUNT(*) as count FROM votes WHERE bill_id='$bill_id' GROUP BY vote_choice";
        $vote_result = $conn->query($vote_count_sql);

        echo "<p><strong>Voting Results:</strong></p>";
        while ($vote = $vote_result->fetch_assoc()) {
            echo "<p>" . $vote['vote_choice'] . ": " . $vote['count'] . "</p>";
        }
    }

    echo "<hr>";
}
?>
<link rel="stylesheet" href="css/styles.css">
<a href="dashboard.php">Back to Dashboard</a>
