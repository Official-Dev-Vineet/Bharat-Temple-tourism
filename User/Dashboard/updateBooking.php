<?php
require_once "../../Admin/config.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}
$tourId = $_GET['tourId'];
$pnr = $_GET['id'];
// check pnr is valid or not
$stmt = $conn->prepare("SELECT * FROM bookingtour WHERE pnr = :pnr");
$stmt->bindParam(':pnr', $pnr);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $bookingDetails = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $bookingDetails = null;
    header('location:myBooking.php');
    exit;
}
// fetch price from database
// find package details from database table tourpackages 
$stmt = $conn->prepare("SELECT * FROM tourpackages WHERE tourId = :id");
$stmt->bindParam(':id', $tourId);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $tourDetails = $stmt->fetch(PDO::FETCH_ASSOC);
    $price = $tourDetails['price'];
} else {
    $tourDetails = null;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve updated values from the form
    $startDate = $_POST['startDate'];
    $person = $_POST['person'];
    $amount = $_POST['amount'];
    if ($bookingDetails['amount'] > $amount) {
        $amount = $bookingDetails['amount'] - $amount;
        $refundAmt = $amount;
        // insert data to refunddata table
        $emailId = $bookingDetails['emailId'];
        $phone = $bookingDetails['contactNumber'];
        $transId = $bookingDetails['transId'];
        $status = 'Refund Amount';
        $sql = "INSERT INTO refunddata (`pnr`, `amount`, `transId`, `emailId`, `phone`, `status`) VALUES (:pnr, :amount, :transId, :emailId, :phone, :status)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':pnr', $pnr);
        $stmt->bindParam(':amount', $refundAmt);
        $stmt->bindParam(':transId', $transId);
        $stmt->bindParam(':emailId', $emailId);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $stmt->closeCursor();
            $stmt = null;
            $stmt = $conn->prepare("UPDATE bookingtour SET bookingDate = :startDate, person = :person, amount = :amount WHERE pnr = :pnr");
            $stmt->bindParam(':startDate', $startDate);
            $stmt->bindParam(':person', $person);
            $stmt->bindParam(':amount', $amount);
            // $stmt->bindParam(':status', 'Updated', PDO::PARAM_STR);
            $stmt->bindParam(':pnr', $pnr);
            if ($stmt->execute()) {
                // Redirect to a success page or perform any other action
                echo "Tour updated Successfully";
                exit;
            } else {
                // Handle the case where the update fails
                $errorMessage = "Failed to update tour details.";
                exit;
            }
        }
    } else {
        echo "Data can't be updated";
        exit;
    }
    // Update the booking details in the database
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tour Booking Form</title>
    <meta name="description" content="Explore the rich cultural heritage of Bharat through its ancient temples. Plan your trip to experience spirituality and architectural marvels.">
    <meta name="keywords" content="Bharat, temple, tourism, cultural heritage, spirituality, architecture">
    <meta name="author" content="Official Dev Vineet">
    <meta property="og:title" content="Bharat Temple Tourism">
    <meta property="og:description" content="Explore the rich cultural heritage of Bharat through its ancient temples. Plan your trip to experience spirituality and architectural marvels.">
    <meta property="og:image" content="Admin/uploads/<?= $logo ?>">
    <meta property="og:url" content="https://example.com/bharat-temple-tourism">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Bharat Temple Tourism">
    <meta name="twitter:description" content="Explore the rich cultural heritage of Bharat through its ancient temples. Plan your trip to experience spirituality and architectural marvels.">
    <meta name="twitter:image" content="Admin/uploads/<?= $logo ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <style>
        body {
            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.dev/svgjs' width='1440' height='560' preserveAspectRatio='none' viewBox='0 0 1440 560'%3e%3cg mask='url(%26quot%3b%23SvgjsMask1153%26quot%3b)' fill='none'%3e%3crect width='1440' height='560' x='0' y='0' fill='url(%26quot%3b%23SvgjsLinearGradient1154%26quot%3b)'%3e%3c/rect%3e%3cpath d='M164.5953860065294 238.06334073884096L256.26602754091107 351.2671553073927 369.46984210946283 259.5965137730111 277.79920057508116 146.3926992044593z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M1322.002%2c538.54C1349.022%2c537.878%2c1366.532%2c513.008%2c1379.375%2c489.227C1391.404%2c466.955%2c1398.216%2c441.292%2c1386.695%2c418.753C1374.174%2c394.258%2c1349.501%2c376.203%2c1322.002%2c376.99C1295.558%2c377.747%2c1276.03%2c399.026%2c1263.419%2c422.281C1251.499%2c444.262%2c1248.291%2c469.834%2c1259.543%2c492.164C1272.05%2c516.984%2c1294.217%2c539.221%2c1322.002%2c538.54' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M847.58%2c170.576C872.964%2c169.269%2c893.757%2c151.213%2c904.825%2c128.331C914.561%2c108.203%2c909.877%2c85.12%2c898.109%2c66.108C887.034%2c48.216%2c868.605%2c36.684%2c847.58%2c35.848C824.897%2c34.946%2c802.491%2c43.124%2c789.576%2c61.793C774.584%2c83.464%2c766.725%2c111.553%2c779.123%2c134.805C792.106%2c159.155%2c820.022%2c171.995%2c847.58%2c170.576' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M860.61 510.14 a148.97 148.97 0 1 0 297.94 0 a148.97 148.97 0 1 0 -297.94 0z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M913.8770859662379 118.72981438405012L803.0234376946165 241.8452634689864 1036.9925350511742 229.5834626556715z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M155.5 510.77 a105.75 105.75 0 1 0 211.5 0 a105.75 105.75 0 1 0 -211.5 0z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M160.20063452844917 545.5071503664562L229.29689313404825 473.95588001084593 87.42185829783323 406.0871272802525z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M1446.871425535672 613.3266243118014L1506.107505538046 537.5078993888428 1371.0527006127134 554.0905443094273z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M686.0323540662771 265.11278199668345L689.5204093090359 165.22794860023822 589.6355759125908 161.73989335747933 586.1475206698319 261.62472675392456z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M1437.3176780725717 311.62940354490087L1510.0612274824948 218.52190618164593 1344.2101807093168 238.88585413497776z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M1097.8427120981485 595.3251170630675L1122.2982403255667 456.6309244377634 983.6040477002625 432.17539621034524 959.1485194728443 570.8695888356493z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float1'%3e%3c/path%3e%3cpath d='M482.15712167946003 412.8205200553936L543.1847141585018 342.6163056987455 407.3645963840088 286.177024158507z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float1'%3e%3c/path%3e%3c/g%3e%3cdefs%3e%3cmask id='SvgjsMask1153'%3e%3crect width='1440' height='560' fill='white'%3e%3c/rect%3e%3c/mask%3e%3clinearGradient x1='100%25' y1='50%25' x2='0%25' y2='50%25' gradientUnits='userSpaceOnUse' id='SvgjsLinearGradient1154'%3e%3cstop stop-color='%230e2a47' offset='0'%3e%3c/stop%3e%3cstop stop-color='rgba(0%2c 0%2c 0%2c 1)' offset='1'%3e%3c/stop%3e%3c/linearGradient%3e%3cstyle%3e %40keyframes float1 %7b 0%25%7btransform: translate(0%2c 0)%7d 50%25%7btransform: translate(-10px%2c 0)%7d 100%25%7btransform: translate(0%2c 0)%7d %7d .triangle-float1 %7b animation: float1 5s infinite%3b %7d %40keyframes float2 %7b 0%25%7btransform: translate(0%2c 0)%7d 50%25%7btransform: translate(-5px%2c -5px)%7d 100%25%7btransform: translate(0%2c 0)%7d %7d .triangle-float2 %7b animation: float2 4s infinite%3b %7d %40keyframes float3 %7b 0%25%7btransform: translate(0%2c 0)%7d 50%25%7btransform: translate(0%2c -10px)%7d 100%25%7btransform: translate(0%2c 0)%7d %7d .triangle-float3 %7b animation: float3 6s infinite%3b %7d %3c/style%3e%3c/defs%3e%3c/svg%3e");
            background-attachment: fixed;
            background-size: cover;
        }

        .container {
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            margin: 2rem auto;
            border-radius: 5px;
            backdrop-filter: blur(3px);
            background-color: rgba(250, 250, 250, 0.3);
        }

        .navbar {
            backdrop-filter: blur(3px);
            background-color: rgba(250, 250, 250, 0.8);
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .navbar a {
            color: #050505;
            font-weight: 600;
        }

        .navbar .navbar-brand {
            text-transform: capitalize !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand font-weight-bold" href="#"><?= $_SESSION['name']; ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../../index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../index.php#package">Book a tour</a>
                </li>

                <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'myBooking.php' ? 'active' : ''; ?>">
                    <a class="nav-link" href="myBooking.php">My Booking</a>
                </li>
                <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'myTour.php' ? 'active' : ''; ?>">
                    <a class="nav-link" href="review.php">Review</a>
                </li>
                <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                    <a class="nav-link" href="dashboard.php">Update Profile <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'logout.php' ? 'active' : ''; ?>">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h2 class="mt-5 mb-4 text-center text-primary">Update your Tour</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?" . $_SERVER['QUERY_STRING']; ?>" method="POST" id="updateForm">
            <div class="form-group">
                <label for="tourId">Tour ID:</label>
                <input type="text" class="form-control" id="tourId" readonly value="<?= $tourId ?>" name="tourId" required />
            </div>
            <div class="form-group">
                <label for="tourId">Pnr:</label>
                <input type="text" class="form-control" id="tourId" readonly value="<?= $pnr ?>" name="tourId" required />
            </div>
            <div class="form-group">
                <label for="emailId">Email ID:</label>
                <input type="email" class="form-control" id="emailId" readonly value="<?= $bookingDetails['emailId'] ?>" name="emailId" required />
            </div>
            <div class="form-group">
                <label for="contactNumber">Contact Number:</label>
                <input type="tel" class="form-control" id="contactNumber" name="contactNumber" readonly value="<?= $bookingDetails['contactNumber'] ?>" required />
            </div>
            <div class="form-group">
                <label for="startDate">Tour start Date:</label>
                <input type="date" class="form-control" id="startDate" name="startDate" required />
            </div>
            <div class="form-group">
                <label for="person">Person:</label>
                <input type="number" class="form-control" id="person" value="1" name="person" required />
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" class="form-control" id="amount" readonly value="<?= $price ?>" name="amount" required />
            </div>
            <button type="submit" class="btn btn-primary">Update Tour</button>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        var currentDate = new Date();
        // Calculate the date three days later
        var threeDaysLater = new Date(currentDate);
        threeDaysLater.setDate(currentDate.getDate() + 3);
        // Set the minimum date for the input element with id 'startDate'
        document.getElementById('startDate').min = threeDaysLater.toISOString().split('T')[0];
        $(document).ready(function() {
            // Event listener for input changes on the person field
            $('#person').on('input', function() {
                var numberOfPersons = parseInt($(this).val()); // Get the number of persons
                // Calculate price based on the number of persons (assuming $10 per person)
                var price = numberOfPersons * "<?= $tourDetails['price'] ?>"; // Adjust the price calculation based on your actual pricing logic
                // Update the price input field with the calculated price
                $('#amount').val(price); // Format price with two decimal places and prepend with '$'
            });
        });
        // form handling using ajax 
        $(document).ready(function() {
            $('#updateForm').submit(function(event) {
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response == 'success') {
                            alert('Updated successfully!');
                        } else {
                            alert(response);
                        }
                    }
                })
            })
        })
    </script>
</body>

</html>