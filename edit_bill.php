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

$sql = "SELECT * FROM bills WHERE bill_id='$bill_id' AND author='$username' AND status='Draft'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "You are not allowed to edit this bill!";
    exit();
}

$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $update_sql = "UPDATE bills SET bill_title='$title', bill_description='$description' WHERE bill_id='$bill_id' AND author='$username'";
    
    if ($conn->query($update_sql) === TRUE) {
        echo "<p style='color:green;'>Bill updated successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>
<link rel="stylesheet" href="css/styles.css">


<h2>Edit Bill</h2>
<form method="post">
    Title: <input type="text" name="title" value="<?php echo $row['bill_title']; ?>" required><br>
    Description: <textarea name="description" required><?php echo $row['bill_description']; ?></textarea><br>
    <button type="submit">Update Bill</button>
</form>
<a href="view_bills.php">Back to Bills</a>
