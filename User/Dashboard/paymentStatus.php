<?php
// Define PhonePe gateway information
session_start();
$msg = '';
$gateway = (object) [
    'token' => 'PGTESTPAYUAT',
    'secret_key' => '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399',
];

// Extract transaction ID from POST data
$orderId = $_POST['transactionId'];

// Construct X-VERIFY header for status check
$encodeIn265 = hash('sha256', '/pg/v1/status/' . $gateway->token . '/' . $orderId . $gateway->secret_key) . '###1';

// Set headers for the status check request
$headers = [
    'Content-Type: application/json',
    'X-MERCHANT-ID: ' . $gateway->token,
    'X-VERIFY: ' . $encodeIn265,
    'Accept: application/json',
];

// Define PhonePe status check URL
$phonePeStatusUrl = 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/' . $gateway->token . '/' . $orderId; // For Development
// $phonePeStatusUrl = 'https://api.phonepe.com/apis/hermes/pg/v1/status/' . $gateway->token . '/' . $orderId; // For Production

// Initialize cURL for status check
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $phonePeStatusUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);
// Decode the status check response
$api_response = json_decode($response);
if ($api_response->code == "PAYMENT_SUCCESS") {
    // Handle successful transactions
    // updateStatus in database
    require_once "../../Admin/config.php";
    $sql = "UPDATE bookingtour SET status = 'booked' WHERE transId = '$orderId'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $stmt->closeCursor();
        $stmt = null;
        // send details to mail id 
        // fetch data from database to send mail
        $sql = "SELECT * FROM bookingtour WHERE transId = '$orderId'";
        $result = $conn->prepare($sql);
        $result->execute();
        $row = $result->fetch();
        $result->closeCursor();
        $result = null;
        // fetch tour details from database
        $sql = "SELECT * FROM tourpackages WHERE tourId = '$row[tourId]'";
        $result = $conn->prepare($sql);
        $result->execute();
        $tourDetails = $result->fetch();
        $result->closeCursor();
        $result = null;
        // fetch name from user_register table
        $sql = "SELECT Name  FROM user_register WHERE Email = '$_SESSION[email]'";
        $result = $conn->prepare($sql);
        $result->execute();
        $name = $result->fetch();
        $result = null;
        // send mail to user
        $to = $row['emailId'];
        $subject = "Booking Confirmation";
        $body = '<!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Booking Confirmation</title>
            <meta name="description" content="Explore the rich cultural heritage of Bharat through its ancient temples. Plan your trip to experience spirituality and architectural marvels.">
        </head>
        <body style="font-family: Arial, sans-serif; margin: 0; padding: 0;">
        
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
                <td style="padding: 20px;">
                    <h1 style="font-size: 24px; margin-bottom: 20px;">Dear ' . $name['Name'] . '</h1>
                    <p style="font-size: 16px;">Thank you for booking with us. Your booking details are as follows:</p>
                    <ul style="list-style-type: none; padding: 0; margin: 0;">
                        <li><strong>Email:</strong> ' . $row['emailId'] . '</li>
                        <li><strong>Phone:</strong> ' . $row['contactNumber'] . '</li>
                        <li><strong>Tour Start Date:</strong> ' . $row['bookingDate'] . '</li>
                        <li><strong>Time:</strong> ' . $row['currentTime'] . '</li>
                        <li><strong>Tour Name:</strong> ' . $tourDetails['title'] . '</li>
                        <li><strong>Location:</strong> ' . $tourDetails['location'] . '</li>
                        <li><strong>Transaction ID:</strong> ' . $row['transId'] . '</li>
                        <li><strong>PNR NUMBER:</strong> ' . $row['pnr'] . '</li>
                        <li><strong>Payment Status:</strong> ' . $row['status'] . '/partial </li>
                        <li><strong>Amount:</strong> ' . $row['amount'] . '</li>
                    </ul>
                    <p style="font-size: 16px;">Please keep this transaction ID for future reference.</p>
                    <p style="font-size: 16px;">We appreciate your booking and look forward to seeing you soon.</p>
                    <img src="http://localhost:8080/Bharat-Temple-Tourism/Admin/uploads/' . $tourDetails['image'] . '" alt="Tour Image" style="max-width: 100%; height: auto; margin-top: 20px;">
                    <p style="font-size: 16px;">Best regards,</p>
                    <p style="font-size: 16px;">Team Bharat Temple Tourism</p>
                    <p style="font-size: 16px;">www.bharat-temple-tourism.com</p>
                    </td>
            </tr>
        </table>
        </body>
        </html>
        ';
        $curl = curl_init();
        $url = "http://localhost:8080/bharat-temple-tourism/sendmail.php";
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array('toEmail' => $to, 'subject' => $subject, 'body' => $body, 'name' => $name['Name'], 'secrete_key' => "12345"));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        if ($response == "success") {
        } else {
            echo "Mail could not be sent";
            exit;
        }
    } else {
        echo "Payment Details sent to your mail id ";
        // clear post data
        echo '<a href="http://localhost:8080/Bharat-Temple-Tourism/User/Dashboard/myBooking.php" class="btn btn-primary">Find Tour Details</a>';

        exit;
    }
} else {
    // Handle failed transactions
    echo "Transaction Failed";
    unset($_POST);
    exit;
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
</head>

<body>
    <?php
    if (isset($body)) {
        echo $body;
        echo '<button id="generate-pdf" style="background-color: #007bff; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; margin-top: 10px; cursor: pointer;" onclick="generatePDF()">Generate PDF</button>';
        echo '<a href="http://localhost:8080/Bharat-Temple-Tourism/User/Dashboard/myBooking.php" style="display: inline-block; padding: 10px 20px; background-color: #28a745; color: #fff; text-decoration: none; border-radius: 5px; margin-top: 10px;">Find Tour Details</a>';
    }
    ?>
    <script>
        function generatePDF() {
            window.print();
        }
    </script>
</body>

</html>