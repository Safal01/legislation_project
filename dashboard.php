<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$pageTitle = "Dashboard"; 
include('header.php'); 
?>

<link rel="stylesheet" href="css/styles.css">

<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

    <ul>
        <li><a href="add_bill.php">Create a New Bill</a></li>
        <li><a href="view_bills.php">View All Bills</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>

    <?php
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
        echo "<h3>Admin Reports</h3>";
        echo "<a href='admin_reports.php'>View All Bills & Votes</a><br>";
    }
    ?>
</div>
