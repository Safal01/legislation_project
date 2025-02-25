<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Invalid request!";
    exit();
}

$bill_id = $_GET['id'];
$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amendment_text = $_POST['amendment_text'];
    $sql = "INSERT INTO amendments (bill_id, reviewer, amendment_text) VALUES ('$bill_id', '$username', '$amendment_text')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Amendment submitted!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>
<link rel="stylesheet" href="css/styles.css">

<h2>Suggest an Amendment</h2>
<form method="post">
    Amendment: <textarea name="amendment_text" required></textarea><br>
    <button type="submit">Submit</button>
</form>
<a href="view_bills.php">Back to Bills</a>
