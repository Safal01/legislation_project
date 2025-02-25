<?php
session_start();
include "db_connect.php"; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $author = $_SESSION['username'];

    $sql = "INSERT INTO bills (bill_title, bill_description, author, status) 
            VALUES ('$title', '$description', '$author', 'Draft')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Bill created successfully! It is now in Draft.</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<link rel="stylesheet" href="css/styles.css">

<h2>Create a New Bill</h2>
<form method="post">
    Title: <input type="text" name="title" required><br>
    Description: <textarea name="description" required></textarea><br>
    <button type="submit">Create Bill</button>
</form>
<a href="dashboard.php">Back to Dashboard</a>
