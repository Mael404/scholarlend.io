<?php
session_start(); // Start the session

// Check if the user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    die("User not logged in."); // Stop execution if user is not logged in
}

$user_id = $_POST['user_id'];
$deadline_to_remove = $_POST['deadline'];

// Ensure transaction_id is in the session
if (!isset($_SESSION['transaction_id'])) {
    die("Transaction ID not found in session."); // Stop execution if transaction ID is missing
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "scholarlend_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch current next deadlines and transaction_id
$sql = "SELECT next_deadlines FROM borrower_info WHERE user_id = ? AND transaction_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $_SESSION['transaction_id']); // Bind user_id and transaction_id
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $next_deadlines = $row['next_deadlines'];
    
    // Convert the comma-separated string to an array
    $next_deadlines_array = array_map('trim', explode(',', $next_deadlines));
    
    // Remove the specified deadline (current date)
    if (($key = array_search(trim($deadline_to_remove), $next_deadlines_array)) !== false) {
        unset($next_deadlines_array[$key]);
    }

    // Update the database with the remaining deadlines
    $new_deadlines = implode(', ', array_values($next_deadlines_array)); // Convert back to string
    $update_sql = "UPDATE borrower_info SET next_deadlines = ? WHERE user_id = ? AND transaction_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sis", $new_deadlines, $user_id, $_SESSION['transaction_id']); // Bind new deadlines, user_id, and transaction_id
    $update_stmt->execute();

    // Close the statements
    $stmt->close();
    $update_stmt->close();
} else {
    echo "No application found for the given user ID and transaction ID."; // Optional error message
}

$conn->close();

// Redirect back to the previous page or show a success message
header("Location: borrower_applicationform.php");
exit();
?>
