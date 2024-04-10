<?php
// Include the database configuration file
require_once 'Admin/config.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate email
    $email = trim($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Check if the email is already subscribed
    $stmt = $conn->prepare("SELECT * FROM newsletter WHERE email = ?");
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        echo "Email already subscribed.";
        exit;
    }
    // Insert email into database
    $stmt = $conn->prepare("INSERT INTO newsletter (email) VALUES (?)");
    if ($stmt->execute([$email])) {
        echo "Subscription successful!";
        exit;
    } else {
        echo "Error subscribing. Please try again later.";
        exit;
    }
    $conn = null;
} else {
    echo "Error: Invalid request.";
    exit;
}
