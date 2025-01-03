<?php
session_start();
// Database connection
include 'display_user_wallet.php';
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "scholarlend_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch data where status is 'Pending'
$sql = "SELECT fname, mname, lname, transaction_id, status, created_at FROM borrower_info";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="styles.css" />
    <title>ScholarLend - Admin</title>

    <style>
    
    .list-group-item {
    width: 300px; /* Set the desired width */
    border-radius: 8px; /* Add border radius */
    transition: background-color 0.3s ease, transform 0.3s ease, padding 0.3s ease; /* Add transitions */
    margin-left: 60px; /* Adjust left margin for the entire item */
    margin-bottom: 4px; /* Add spacing between items */
    display: flex; /* Use flexbox */
    align-items: center; /* Center text vertically */
    height: 50px; /* Set a fixed height */
    font-size: larger; /* Increase font size */
    text-align: left; /* Align text to the left */
    padding-left: 85px; /* Add padding to move the text leftwards */
}


/* Active sidebar item */
.list-group-item.active {
    background-color: #dbbf94; /* Set the background color for active item */
    color: rgb(255, 255, 255); /* Set the text color for active item */
    font-weight: bold; /* Make the text bold for active item */
    border-radius: 8px; /* Keep the rounded corners */
    border: none; /* Remove any border if necessary */
}

    .list-group-item:hover {
        background-color: #dbbf94; /* Set background color on hover */
        color: white; /* Set text color on hover */
       
    }

    .user-info {
    display: flex; /* Use flexbox */
    align-items: center; /* Center items vertically */
    justify-content: center; /* Center items horizontally */
 
}

.user-info img {
    margin-right: 80px; /* Space between image and text */
}

.user-details {
    text-align: left; /* Align text to the left */
}

.username {
    font-weight: bold; /* Make username bold */
    font-size: large;
}

.email {
    font-size: 0.9em; /* Slightly smaller font for email */
    color: black; /* Change email color if desired */
}
.border-bottom {
    border-bottom: 3.5px solid #f0f0f0 !important;
}



.modal-content {
    border-radius: 15px;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
   
}

.modal-header {
    border-bottom: none;
    background-color: #f8f9fa;
    padding: 20px;
}

.modal-title {
    font-weight: bold;
    color: #333;
}

.section-title {
    font-size: 1.2em;
    margin-bottom: 10px;
    color: #555;
}

.info-item {
    margin-bottom: 8px;
    line-height: 1.5;
    font-size: 0.9em;
}

.image-uploads img {
    max-width: 100%;
    height: auto;
    border: 2px solid #007bff;
    border-radius: 8px;
}

.btn-secondary {
    background-color: #007bff;
    border: none;
    color: white;
}

.btn-secondary:hover {
    background-color: #0056b3;
}

.section-title {
    font-size: 1.2em;
    margin-bottom: 10px;
    color: #fff; /* White text for better contrast */
    background-color: #ccac82; /* Background color */
    border-radius: 9px; /* Rounded corners */
    padding: 8px 12px; /* Padding for better spacing */
    display: inline-block; /* To make the background wrap around the text */
}
/* card tab */
.card {
      background-color: #f8f9fa;
      border-radius: 10px;
    }

    .nav-tabs .nav-link.active {
      background-color: #f8f9fa;
      border-color: #f8f9fa;
      font-weight: bold;
    }

    h5 {
      font-weight: bold;
    }

    p {
      margin-bottom: 0.5rem;
    }

    .tab-content {
      border: 1px solid #e9ecef;
      border-top: none;
      background-color: #fff;
      padding: 1rem;
      border-radius: 0 0 10px 10px;
    }
    .navbar {
            background-color: #f9f7f3;
            height: 8vh;
            padding: 0.5rem 1rem;
        }
        .navbar-brand span {
            font-weight: bold;
            color: #c29c6d; /* Scholar color */
        }
        .navbar-brand .logo-text {
            color: #2c2e45; /* Lend color */
        }
        .navbar-text {
            color: #2c2e45;
        }

        .modal-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #1a1a40;
}

.status-box {
    background-color: #d8b389;
    padding: 5px 10px;
    border-radius: 4px;
    display: inline-block;
    margin-left: 10px;
}

.section-title {
    font-size: 1.2rem;
    font-weight: bold;
    margin-top: 20px;
    color: #1a1a40;
    border-bottom: 1px solid #ddd;
    padding-bottom: 5px;
}

.loan-info p, .payment-details p {
    margin-left: 20px;
    color: #333;
    font-weight: normal;
    font-size: 1rem;
}


    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand d-flex primary-text fs-1 fw-bold" href="#" style="font-family: 'Times New Roman', Times, serif; margin-left:60px;">
            <span>Scholar</span><span class="logo-text">Lend</span>
        </a>
        <div class="d-none d-lg-block">
            <span class="navbar-text" style="font-family: 'Times New Roman', Times, serif; font-weight:bolder; font-size:larger;">Administrator</span>
        </div>
    </div>
</nav>

    <div class="d-flex" id="wrapper">
        
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            
                  
            <div class="user-info d-flex align-items-center my-4 text-center">
        

                <img src="iconnn.png" alt="User Profile Picture" class="img-fluid rounded-circle" style="width: 50px; height: 50px; margin-right: 10px;">
                <div class="user-details">
                    <div class="username">
                        <?php 
                        echo isset($_SESSION['first_name']) && isset($_SESSION['last_name']) 
                            ? $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] 
                            : 'Guest'; 
                        ?>
                    </div>
                    <div class="email">
                        <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'user@example.com'; ?>
                    </div>
                </div>  
                            </div>

          
        
                            <div class="list-group list-group-flush my-3">
    <a href="admindashboard.php" class="list-group-item  list-group-item-action">
        <i class="lnr lnr-home me-2"></i> Home
    </a>
    <?php
include'condb.php';

// SQL query to count 'pending' statuses in the loan-deadlines table
$sql = "SELECT COUNT(*) AS pending_count FROM borrower_info WHERE status = 'invested' OR status = 'pending'";

$result = $conn->query($sql);

// Fetch the count
$pending_count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pending_count = $row['pending_count'];
}

$conn->close();
?>

<a href="admin_applications.php" class="list-group-item position-relative">
    <i class="lnr lnr-file-empty me-2"></i>Applications
    <?php if ($pending_count > 0): ?>
        <span class="badge bg-danger position-absolute top-0 end-0 translate-middle rounded-pill"><?php echo $pending_count; ?></span>
    <?php endif; ?>
</a>
    <a href="admin_lenders.php" class="list-group-item">
        <i class="lnr lnr-briefcase me-2"></i>Lenders
    </a>
    <?php
include'condb.php';

// SQL query to count 'pending' statuses in the loan-deadlines table
$sql = "SELECT COUNT(*) AS pending_count FROM loan_deadlines WHERE status = 'pending'";
$result = $conn->query($sql);

// Fetch the count
$pending_count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pending_count = $row['pending_count'];
}

$conn->close();
?>

<a href="admin_borrowers.php" class="list-group-item position-relative">
    <i class="lnr lnr-users me-2"></i>Borrowers
    <?php if ($pending_count > 0): ?>
        <span class="badge bg-danger position-absolute top-0 end-0 translate-middle rounded-pill"><?php echo $pending_count; ?></span>
    <?php endif; ?>
</a>
    <a href="admin_loans.php" class="list-group-item">
        <i class="lnr lnr-book me-2"></i>Loans
    </a>
    <?php
include 'condb.php';

// SQL query to count unread messages in the contactus table
$sql = "SELECT COUNT(*) AS unread_count FROM contactus WHERE status = 'unread'";

$result = $conn->query($sql);

// Fetch the count
$unread_count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $unread_count = $row['unread_count'];
}

$conn->close();
?>

<a href="admin_messages.php" class="list-group-item position-relative">
    <i class="lnr lnr-file-empty me-2"></i>Messages
    <?php if ($unread_count > 0): ?>
        <span class="badge bg-danger position-absolute top-0 end-0 translate-middle rounded-pill"><?php echo $unread_count; ?></span>
    <?php endif; ?>
</a>

    <a href="admin_reports.php" class="list-group-item">
        <i class="lnr lnr-chart-bars me-2"></i>Reports
    </a>
    <a href="admin_settings.php" class="list-group-item active">
        <i class="lnr lnr-cog me-2"></i>Settings
    </a>
    <a href="/butterfly/index.html" class="list-group-item list-group-item-action text-danger fw-bold">
        <i class="lnr lnr-power-switch me-2"></i>Logout
    </a>
</div>

            
            
        </div>     
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
  <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
    <div class="d-flex align-items-center">
      <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
      <h2 class="fs-2 m-0" style="font-family: 'Times New Roman', Times, serif;">Settings</h2>
    </div>

    
    <a class="nav-link wallet-link second-text fw-bold ms-auto" href="#">
    <i class="fas fa-wallet me-2"></i>Balance: 
    <span class="wallet-balance">PHP <?php echo number_format($wallet_balance, 2); ?></span>
</a>
    
  </nav>
  <style>
    .wallet-link {
        color: black;
        font-size: 1.1rem;
        background-color: #dbbf94;
        border-radius: 9px;
    }
    .wallet-balance {
        font-weight: bold;
    }
</style>

<!-- HTML Code to Display Messages -->
<div id="page-content-wrapper">
    <div class="container-fluid">
        
    </div>

    <div class="container mt-4">
        <!-- Profile Settings Card -->
        <div class="card shadow-sm rounded-lg">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Manage Your Account</h5>
                
                <!-- Options List -->
                <div class="list-group">
                    <!-- Forgot Password Option -->
                    <a href="#" class="list-group-item list-group-item-action py-3" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                        <i class="fas fa-key me-2"></i> Forgot Password
                    </a>
                    
                    <!-- Update Password Option -->
                    <a href="#" class="list-group-item list-group-item-action py-3" data-bs-toggle="modal" data-bs-target="#updatePasswordModal">
                        <i class="fas fa-lock me-2"></i> Update Password
                    </a>

                    <!-- Change Email Option -->
                    <a href="#" class="list-group-item list-group-item-action py-3" data-bs-toggle="modal" data-bs-target="#changeEmailModal">
                        <i class="fas fa-envelope me-2"></i> Change Email
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Forgot Password Modal -->
<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="forgot-email" class="form-label">Enter your email to reset password</label>
            <input type="email" class="form-control" id="forgot-email" placeholder="Enter registered email" required>
        </div>
        <div class="mb-3" id="password-fields" style="display: none;">
            <label for="new-password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="new-password" placeholder="Enter new password" required>
        </div>
        <div class="mb-3" id="confirm-password-fields" style="display: none;">
            <label for="confirm-password" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="confirm-password" placeholder="Confirm new password" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="reset-password-btn">Reset Password</button>
      </div>
    </div>
  </div>
</div>

<!-- Update Password Modal -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePasswordModalLabel">Update Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updatePasswordForm">
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="updatePasswordBtn">Update Password</button>
            </div>
        </div>
    </div>
</div>


<!-- Change Email Modal -->
<div class="modal fade" id="changeEmailModal" tabindex="-1" aria-labelledby="changeEmailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changeEmailModalLabel">Change Email</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="new-email" class="form-label">New Email Address</label>
            <input type="email" class="form-control" id="new-email" placeholder="Enter new email" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Change Email</button>
      </div>
    </div>
  </div>
</div>

    </div>
    </div>
    
  








<!-- Bootstrap JS 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    
   




</script>





    <script>  

        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };



    </script>
<script>
document.getElementById('reset-password-btn').addEventListener('click', function () {
    var email = document.getElementById('forgot-email').value;
    var newPassword = document.getElementById('new-password').value;
    var confirmPassword = document.getElementById('confirm-password').value;

    if (!email) {
        alert('Please enter an email.');
        return;
    }

    if (newPassword !== confirmPassword) {
        alert('Passwords do not match.');
        return;
    }

    console.log("Email:", email); // Check the email
    console.log("New Password:", newPassword); // Check the new password

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "reset_password.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert(response.message);
                $('#forgotPasswordModal').modal('hide');
            } else {
                alert(response.message);
            }
        }
    };

    var data = "email=" + encodeURIComponent(email) + "&new_password=" + encodeURIComponent(newPassword);
    console.log("Data to send:", data); // Check the data being sent

    xhr.send(data);
});
document.getElementById('forgot-email').addEventListener('input', function () {
    if (this.value) {
        document.getElementById('password-fields').style.display = 'block';
        document.getElementById('confirm-password-fields').style.display = 'block';
    } else {
        document.getElementById('password-fields').style.display = 'none';
        document.getElementById('confirm-password-fields').style.display = 'none';
    }
});

// Event listener for the update password button
document.getElementById('updatePasswordBtn').addEventListener('click', function () {
    var currentPassword = document.getElementById('currentPassword').value;
    var newPassword = document.getElementById('newPassword').value;
    var confirmPassword = document.getElementById('confirmPassword').value;

    if (!currentPassword || !newPassword || !confirmPassword) {
        alert('Please fill in all fields.');
        return;
    }

    if (newPassword !== confirmPassword) {
        alert('New password and confirm password do not match.');
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_password.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            alert(response.message); // Show the response message

            if (response.success) {
                $('#updatePasswordModal').modal('hide'); // Hide the modal if successful
            }
        }
    };

    // Sending the data to the server
    var data = "currentPassword=" + encodeURIComponent(currentPassword) + 
               "&newPassword=" + encodeURIComponent(newPassword) + 
               "&confirmPassword=" + encodeURIComponent(confirmPassword);
    xhr.send(data);
});



document.querySelector('#changeEmailModal .btn-primary').addEventListener('click', function () {
    var newEmail = document.getElementById('new-email').value;

    if (!newEmail) {
        alert('Please enter a new email address.');
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "change_email.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert(response.message);
                $('#changeEmailModal').modal('hide');
            } else {
                alert(response.message);
            }
        }
    };

    var data = "new_email=" + encodeURIComponent(newEmail);
    xhr.send(data);
});

</script>


</body>

</html>