<?php
require_once 'functions.php';

$message = "Invalid or missing email.";

if (isset($_GET['email'])) {
    $email = trim($_GET['email']);
    if (unsubscribeEmail($email)) {
        $message = "You have been unsubscribed successfully.";
    } else {
        $message = "Email was not found in the subscription list.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Unsubscribe</title>
</head>
<body>
    <h1><?= htmlspecialchars($message) ?></h1>
</body>
</html>
