<?php
// Establish PDO connection (replace with your actual database credentials)
require_once "../Admin/config.php";

try {
    $email = $_GET['email'];
    $token = $_GET['token'];
    // Prepare and execute the SQL query to check if the email and token match
    $stmt = $conn->prepare("SELECT * FROM user_register WHERE email = :email AND token = :token");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    // Check if a row was returned (user is verified)
    if ($stmt->rowCount() > 0) {
       // send html template 
       echo '<!DOCTYPE html>
       <html lang="en">
       <head>
           <meta charset="UTF-8">
           <meta name="viewport" content="width=device-width, initial-scale=1.0">
           <title>Account Verified</title>
           <meta name="description" content="Explore the rich cultural heritage of Bharat through its ancient temples. Plan your trip to experience spirituality and architectural marvels.">
           <!-- Bootstrap CSS -->
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
           <style>
               .container {
                   max-width: 600px;
                   margin: 50px auto;
                   text-align: center;
               }
           </style>
       </head>
       <body>
           <div class="container">
               <div class="alert alert-success" role="alert">
                   <h4 class="alert-heading">Account Verified Successfully</h4>
                   <p>Your account has been successfully verified.</p>
                   <hr>
                   <p class="mb-0">You can now <a href="login.php">login</a> to your account and start exploring our services.</p>
               </div>
           </div>
       </body>
       </html>
       ';
    } else {
        echo 'Invalid email or token!';
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

// Close the PDO connection
$conn = null;