<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Legislator') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Invalid request!";
    exit();
}

$bill_id = $_GET['id'];
$mp_name = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vote_choice = $_POST['vote_choice'];

    // Check if MP has already voted
    $check_sql = "SELECT * FROM votes WHERE bill_id='$bill_id' AND mp_name='$mp_name'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<p style='color:red;'>You have already voted on this bill!</p>";
    } else {
        // Insert vote
        $sql = "INSERT INTO votes (bill_id, mp_name, vote_choice) VALUES ('$bill_id', '$mp_name', '$vote_choice')";

        if ($conn->query($sql) === TRUE) {
            echo "<p style='color:green;'>Vote submitted successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }
    }
}
?>
<link rel="stylesheet" href="css/styles.css">

<h2>Vote on Bill</h2>
<form method="post">
    <label>
        <input type="radio" name="vote_choice" value="For" required> For
    </label><br>
    <label>
        <input type="radio" name="vote_choice" value="Against" required> Against
    </label><br>
    <label>
        <input type="radio" name="vote_choice" value="Abstain" required> Abstain
    </label><br>
    <button type="submit">Submit Vote</button>
</form>

<a href="view_bills.php">Back to Bills</a>
