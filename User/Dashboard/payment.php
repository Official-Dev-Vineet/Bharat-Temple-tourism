<?php
// phone pay payment request page 
use PhonePe\payments\v1\models\request\builders\InstrumentBuilder;
use PhonePe\payments\v1\models\request\builders\PgPayRequestBuilder;
use PhonePe\payments\v1\PhonePePaymentClient;
use PhonePe\Env;

require_once "../../Admin/config.php";
session_start();
// check request method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tourId = $_POST['tourId'];
    // fetch tour details from tourpackages
    $sql = "SELECT * FROM tourpackages WHERE tourId = :tourId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tourId', $tourId, PDO::PARAM_STR);
    $stmt->execute();
    $tour = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $stmt= null;
    $email = $_SESSION['email'];
    $contactNumber = $_POST['contactNumber'];
    $day = $tour['day'];
    $person = $_POST['person'];
    $userEmailId = $_SESSION['email'];
    $bookingDate = $_POST['startDate'];
    $currentDate = date("Y-m-d");
    $currentTime = date("H:i:s");
    $amount = $person * $tour['price'];
    $status = 'Pending';
    $transactionId = 'TRN' . rand(2999, 9999) . time();
    $pnr = 'BHARAT' . rand(10000000, 99999999);
    // insert booking data to bookingtour table
    $sql = "INSERT INTO bookingtour (tourId,amount, person, emailId, contactNumber, day,bookingDate, status,pnr,transId,currentTime) VALUES (:tourId, :amount,:person, :email, :contactNumber, :day, :bookingDate, :status,:pnr,:transId,:currentTime)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tourId', $tourId, PDO::PARAM_STR);
    $stmt->bindParam(':person', $person, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
    $stmt->bindParam(':contactNumber', $contactNumber, PDO::PARAM_STR);
    $stmt->bindParam(':day', $day, PDO::PARAM_STR);
    $stmt->bindParam(':bookingDate', $bookingDate, PDO::PARAM_STR);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':pnr', $pnr, PDO::PARAM_STR);
    $stmt->bindParam(':transId', $transactionId, PDO::PARAM_STR);
    $stmt->bindParam(':currentTime', $currentTime, PDO::PARAM_STR);
    if ($stmt->execute()) {
        if ($bookingDate < $currentDate) {
            echo "error: Invalid date";
            exit;
        } else {
            $phone = $contactNumber;
            $eventPayload = [
                'merchantId' => 'PGTESTPAYUAT',
                'merchantTransactionId' => $transactionId,
                'merchantUserId' => 'BHARATTEMPLETOURISM',
                'amount' => $amount * 100,
                'redirectUrl' => 'http://localhost:8080/Bharat-temple-tourism/User/Dashboard/paymentStatus.php?transactionId=' . $transactionId,
                'redirectMode' => 'POST',
                'callbackUrl' => 'http://localhost:8080/Bharat-temple-tourism/User/Dashboard/paymentStatus.php?transactionId=' . $transactionId,
                'mobileNumber' => $phone,
                'paymentInstrument' => [
                    'type' => 'PAY_PAGE',
                ],
            ];
            $encodedPayload = base64_encode(json_encode($eventPayload));

            // Set API Key and Index
            $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399'; // Your API Key
            $saltIndex = 1;

            // Construct X-VERIFY header
            $string = $encodedPayload . '/pg/v1/pay' . $saltKey;
            $sha256 = hash('sha256', $string);
            $finalXHeader = $sha256 . '###' . $saltIndex;

            // Set headers for the request
            $headers = [
                'Content-Type: application/json',
                'X-VERIFY: ' . $finalXHeader,
            ];

            // Define PhonePe API URL
            $phonePayUrl = 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay'; // For Development
            // $phonePayUrl = 'https://api.phonepe.com/apis/hermes/pg/v1/pay'; // For Production

            // Prepare data for the request
            $data = [
                'request' => $encodedPayload,
            ];

            // Set options for the HTTP request
            $options = [
                'http' => [
                    'method' => 'POST',
                    'content' => json_encode($data),
                    'header' => implode("\r\n", $headers),
                ],
            ];
            // Create a stream context
            $context = stream_context_create($options);
            // Make the request to PhonePe API
            $response = file_get_contents($phonePayUrl, false, $context);

            // Decode the response
            $result = json_decode($response, true);

            // Extract the redirect URL for payment
            $redirectUrl = $result['data']['instrumentResponse']['redirectInfo']['url'];

            // Redirect the user to PhonePe for payment
            header("Location: $redirectUrl");
        }
    }
} else {
    echo "error: Invalid request method";
    exit;
}
