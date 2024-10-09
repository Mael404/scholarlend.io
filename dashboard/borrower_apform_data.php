<?php
// Database connection
$host = 'localhost'; // Your database host
$db = 'scholarlend_db'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and sanitize form data
$fname = $conn->real_escape_string($_POST['fname']);
$mname = $conn->real_escape_string($_POST['mname']);
$lname = $conn->real_escape_string($_POST['lname']);
$birthdate = $conn->real_escape_string($_POST['birthdate']);
$gender = $conn->real_escape_string($_POST['gender']);
$cellphonenumber = $conn->real_escape_string($_POST['cellphonenumber']);
$email = $conn->real_escape_string($_POST['email']);
$school = $conn->real_escape_string($_POST['school']);
$college = $conn->real_escape_string($_POST['college']);
$course = $conn->real_escape_string($_POST['course']);
$yearofstudy = $conn->real_escape_string($_POST['yearofstudy']);
$graduationdate = $conn->real_escape_string($_POST['graduationdate']);
$monthly_allowance = $conn->real_escape_string($_POST['monthly-allowance']);
$source_of_allowance = $conn->real_escape_string($_POST['source-of-allowance']);
$monthly_expenses = $conn->real_escape_string($_POST['monthly-expenses']);
$school_community = $conn->real_escape_string($_POST['school_community']);
$spending_pattern = $conn->real_escape_string($_POST['spending-pattern']);
$monthly_savings = $conn->real_escape_string($_POST['monthly-savings']);
$career_goals = $conn->real_escape_string($_POST['career-goals']);
$loan_amount = $conn->real_escape_string($_POST['loan_amount']);
$loan_purpose = $conn->real_escape_string($_POST['loan_purpose']);
$loan_description = $conn->real_escape_string($_POST['loan_description']);
$payment_mode = $conn->real_escape_string($_POST['payment_mode']);
$payment_frequency = $conn->real_escape_string($_POST['frequency']);
$due_date = $conn->real_escape_string($_POST['due_date']);
$account_details = $conn->real_escape_string($_POST['account_details']);
$total_amount = $conn->real_escape_string($_POST['total_amount']);

// Handle file uploads
$uploadDir = "uploads/";
$files = ['cor1', 'cor2', 'cor3', 'cor4'];
$uploadedFiles = [];
$errorOccurred = false;

foreach ($files as $fileInput) {
    if (isset($_FILES[$fileInput]) && $_FILES[$fileInput]['error'] == 0) {
        $fileTmpPath = $_FILES[$fileInput]['tmp_name'];
        $fileName = basename($_FILES[$fileInput]['name']);
        $destPath = $uploadDir . $fileName;

        // Move the uploaded file to the destination directory
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $uploadedFiles[$fileInput] = $destPath;
        } else {
            echo json_encode(['status' => 'error', 'message' => "Error uploading $fileInput."]);
            $errorOccurred = true;
            break;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => "Error with $fileInput upload."]);
        $errorOccurred = true;
        break;
    }
}

// Only insert into the database if all files were uploaded successfully
if (!$errorOccurred) {
    // Prepare file paths for database insertion
    $file1 = isset($uploadedFiles['cor1']) ? $conn->real_escape_string($uploadedFiles['cor1']) : null;
    $file2 = isset($uploadedFiles['cor2']) ? $conn->real_escape_string($uploadedFiles['cor2']) : null;
    $file3 = isset($uploadedFiles['cor3']) ? $conn->real_escape_string($uploadedFiles['cor3']) : null;
    $file4 = isset($uploadedFiles['cor4']) ? $conn->real_escape_string($uploadedFiles['cor4']) : null;

    // Insert into the database
    $sql = "INSERT INTO borrower_info (
        fname, mname, lname, birthdate, gender, cellphonenumber, email, school, college, 
        course, yearofstudy, graduationdate, monthly_allowance, source_of_allowance, 
        monthly_expenses, school_community, spending_pattern, monthly_savings, 
        career_goals, loan_amount, loan_purpose, loan_description, payment_mode, 
        payment_frequency, due_date, account_details, total_amount,
        cor1_path, cor2_path, cor3_path, cor4_path
    ) VALUES (
        '$fname', '$mname', '$lname', '$birthdate', '$gender', '$cellphonenumber', '$email', 
        '$school', '$college', '$course', '$yearofstudy', '$graduationdate', 
        '$monthly_allowance', '$source_of_allowance', '$monthly_expenses', '$school_community', 
        '$spending_pattern', '$monthly_savings', '$career_goals', '$loan_amount', 
        '$loan_purpose', '$loan_description', '$payment_mode', '$payment_frequency', 
        '$due_date', '$account_details', '$total_amount',
        '$file1', '$file2', '$file3', '$file4'
    )";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>