<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Start the session
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "scholarlend_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data

$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Check if the email is already registered
$email_check_sql = "SELECT * FROM users_tb WHERE email = '$email' AND is_verified = 1";
$email_check_result = $conn->query($email_check_sql);

if ($email_check_result->num_rows > 0) {
    header("Location: email_failed.php");
    exit();
} else {
    // otp digdi
    $otp = rand(100000, 999999);
    $otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

    $customID = '02000' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

    $sql = "INSERT INTO users_tb (user_id, first_name, middle_name, last_name, birthdate, phone_number, email, password, otp, otp_expiry, account_role) 
            VALUES ('$customID', '$firstName', '$middleName', '$lastName', '$birthdate', '$phoneNumber', '$email', '$password', '$otp', '$otp_expiry', '$accountRole')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        // Email content
        $subject = "Your OTP for Account Registration";
        $message = "
        <html>
        <head>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    background-color: #f4f4f4;
                    color: #333;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                }
                h1 {
                    color: #0056b3;
                    font-size: 24px;
                }
                .otp {
                    font-size: 20px;
                    font-weight: bold;
                    color: #007bff;
                    padding: 10px;
                    border: 2px solid #e7f0ff;
                    display: inline-block;
                    margin-top: 20px;
                    border-radius: 5px;
                    background-color: #ffffff;
                }
                .footer {
                    margin-top: 20px;
                    font-size: 12px;
                    color: #666;
                }
            </style>
        </head>
        <body>
            <h1>Welcome to ScholarLend!</h1>
            <p>Your One-Time Password (OTP) for secure registration is ready:</p>
            <div class='otp'>Your OTP is: <strong>$otp</strong></div>
            <p>Please enter this OTP to complete your registration process. If you did not request this, please contact IT support.</p>
            <div class='footer'>Thank you for being a valuable part of our team!</div>
        </body>
        </html>
        ";

        // Send email and redirect upon success
        if (send_mail($email, $subject, $message)) {
            header("Location: user_otp.php");
            exit();
        } else {
            header("Location: user_otp.php");
            exit();
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


$
$conn->close();

// Function to send email using PHPMailer
function send_mail($recipient, $subject, $message) {
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->Host = "smtp.gmail.com";
    $mail->Username = "maelaquino141@gmail.com";
    $mail->Password = "aytbbzlqaordegbl";

    $mail->IsHTML(true);
    $mail->AddAddress($recipient, "Esteemed Customer");
    $mail->SetFrom("ScholarLend@gmail.com", "ScholarLend");
    $mail->Subject = $subject;
    $mail->MsgHTML($message);

    return $mail->Send();
}
?>
