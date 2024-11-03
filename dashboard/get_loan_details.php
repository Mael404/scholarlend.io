<?php
include 'condb.php';

$transaction_id = $_GET['transaction_id'];
$response = array();

// Update SQL query to join borrower_info and users_tb
$sql = "
    SELECT 
        bi.*, 
        u.first_name AS lender_name 
    FROM 
        borrower_info bi
    LEFT JOIN 
        users_tb u ON bi.lender_id = u.user_id
    WHERE 
        bi.transaction_id = '$transaction_id'
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $response = $result->fetch_assoc();

    // Calculate share_lender and format with 2 decimal places
    $response['share_lender'] = number_format($response['interest_earned'] - $response['share_admin'], 2, '.', ''); // Ensures two decimal places

    // Handle next_deadline as a comma-separated string
    if (!empty($response['next_deadline'])) {
        // Convert the comma-separated string into an array
        $dates = array_map('trim', explode(',', $response['next_deadline']));
        
        // Format each date to a more readable format (e.g., "November 6, 2024")
        $response['next_deadline'] = array_map(function($date) {
            // Convert the date from MM/DD/YYYY to a DateTime object
            $dateTime = DateTime::createFromFormat('m/d/Y', $date);
            // Format the date as "F j, Y"
            return $dateTime ? $dateTime->format('F j, Y') : $date;
        }, $dates);
    } else {
        $response['next_deadline'] = [];
    }
} else {
    $response['error'] = 'Loan not found';
}

// Send the response back as JSON
header('Content-Type: application/json'); // Set content type to JSON
echo json_encode($response);
$conn->close();
?>