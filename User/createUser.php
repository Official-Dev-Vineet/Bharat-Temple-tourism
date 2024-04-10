<?php
// Database configuration
require_once "../Admin/config.php";
try {
    // Create a PDO instance as db connection


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare an insert statement
        $sql = "INSERT INTO user_register (name, email, mobile, city, state, country, pincode, password,token) VALUES (:name, :email, :mobile, :city, :state, :country, :pincode, :password, :token)";
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $country = $_POST['country'];
        $pincode = $_POST['pincode'];
        $password = $_POST['password'];
        // Hash password
        // check email or phone already exists
        $checkStmt = $conn->prepare("SELECT * FROM user_register WHERE email = :email OR mobile = :mobile");
        $checkStmt->bindParam(':email', $email);
        $checkStmt->bindParam(':mobile', $mobile);
        $checkStmt->execute();
        $rowCount = $checkStmt->rowCount();
        if ($rowCount > 0) {
            echo "Email or mobile already exists";
            exit;
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare($sql);
            // create a sha256 token for verification
            $token = hash('sha256', bin2hex(random_bytes(64)));
            // Bind parameters to statement variables
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mobile', $mobile);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':country', $country);
            $stmt->bindParam(':pincode', $pincode);
            $stmt->bindParam(':password', $hashedPassword); // It's important to hash passwords before storing them
            $stmt->bindParam(':token', $token);
            // Set parameters and execute
            $name = $_POST['name'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $country = $_POST['country'];
            $pincode = $_POST['pincode'];
            $password = $_POST['password'];
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute();
            // check if the statement was successful
            if ($stmt->rowCount() > 0) {
                // Set POST data
                $postData = array(
                    'toEmail' => $email,
                    'name' => $name,
                    'secrete_key'=>"12345",
                    'subject' => 'Email Verification',
                    'body' => '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Registration Successful</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                margin: 0;
                                padding: 0;
                                background-color: #f4f4f4;
                            }
                            .container {
                                background-color: #ffffff;
                                margin: 0 auto;
                                padding: 20px;
                                max-width: 600px;
                                border-collapse: collapse;
                                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                margin-bottom: 20px;
                            }
                            .header {
                                background-color: #007bff;
                                color: #ffffff;
                                padding: 10px;
                                text-align: center;
                            }
                            .content {
                                padding: 20px;
                                text-align: left;
                                line-height: 1.5;
                            }
                            .footer {
                                padding: 10px;
                                text-align: center;
                                font-size: 12px;
                                color: #999;
                            }
                        </style>
                    </head>
                    <body>
                        <table class="container">
                            <tr>
                                <td class="header">Welcome to Bharat Temple Tourism</td>
                            </tr>
                            <tr>
                                <td class="content">
                                    Hello, <strong id="name">'.$name.'</strong><br><br>
                                    Your registration is successful. Welcome to the community of Bharat Temple Tourism enthusiasts! We are excited to have you on board and look forward to providing you with the best experiences.<br><br>
                                    Your account details are as follows:<br><br>
                                    Email: '.$email.'<br>
                                    Password: '.$password.'<br><br>
                                    We look forward to working with you and helping you plan your next adventure.
                                    <br><br>
                                    please verify your email.<br><br>
                                    <a href="http://localhost:8080/bharat-temple-tourism/User/verifyEmail.php?token='.$token.'&email='.$email.'">Click here to verify your email</a><br><br>
                                    Should you have any questions or need further information, please feel free to contact us.
                                    <br><br>
                                    Best Regards,<br>
                                    The Bharat Temple Tourism Team
                                </td>
                            </tr>
                            <tr>
                                <td class="footer">
                                    &copy; Bharat Temple Tourism. All rights reserved.
                                </td>
                            </tr>
                        </table>
                    </body>
                    </html>'
                );

                // Initialize cURL session
                $ch = curl_init();

                // Set cURL options
                curl_setopt($ch, CURLOPT_URL, 'http://localhost:8080/bharat-temple-tourism/sendmail.php');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                // Execute cURL session
                $response = curl_exec($ch);

                // Check for errors
                if (curl_errno($ch)) {
                    echo 'Curl error: ' . curl_error($ch);
                }

                // Close cURL session
                curl_close($ch);
                // Handle response
                echo $response;
                exit;
            } else {
                echo "failed";
                exit;
            }
        }
    }
} catch (PDOException $e) {
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
    // Handle error
    echo $e->getMessage();
    exit;
}

// Close connection
unset($conn);
