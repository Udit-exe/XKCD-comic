<?php
// Start the session at the beginning of the script
session_start();

// Include the functions
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // If email is submitted, generate and store the verification code in the session
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        // Generate a 6-digit verification code
        $verificationCode = generateVerificationCode();

        // Store the verification code in the session
        $_SESSION['verification_code'] = $verificationCode;

        if (sendVerificationEmail($email, $verificationCode)) {
            echo "<h2 class='updates' id='successMsg'> A verification code has been sent to your email! </h2>";
        } else {
            echo "<h2 class='updates' id='failedMsg'> Failed to send verification email. Please try again! </h2>";
        }
    }
    
    // If verification code is submitted, compare it with the session value
    elseif (isset($_POST['verification_code'])) {
        $enteredCode = $_POST['verification_code'];
        $email = $_SESSION['email'];
        if ($enteredCode == $_SESSION['verification_code']) {
            if (registerEmail($email)) {
                echo "Email verified and registered successfully!";
            } else {
                echo "Email already registered.";
            }
            unset($_SESSION['verification_code']);
        } else {
            echo "Incorrect verification code. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 class="headings">Enter your email to receive a verification code:</h1>
    <form method="POST" action="index.php">
        <input type="email" name="email" placeholder="Enter your email" required>
        <br>
        <button type="submit">Send Verification Code</button>
    </form>

    <h1 class="headings">Enter Verification Code:</h1>
    <form method="POST" action="index.php">
        <input type="text" name="verification_code" maxlength="6" placeholder="Enter verification code" required>
        <br>
        <button type="submit">Verify Code</button>
    </form>
</body>
</html>