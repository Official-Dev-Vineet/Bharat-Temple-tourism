<?php
// Include your database connection file here
require_once "../Admin/config.php";
session_start();
// get cookie 
$cookieData = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : '';
if (isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id'] . $_SESSION['user_id'] == $cookieData) {
    header("Location: Dashboard/dashboard.php");
    exit();
}
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the username (email or mobile) and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // You should sanitize and validate the input data before using it in the query to prevent SQL injection

    // Query to fetch user data based on email or mobile
    $sql = "SELECT * FROM user_register WHERE Email = :username OR Mobile = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if a user with the provided email or mobile exists
    if ($user) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, login successful
            // You can set session variables or perform other login actions here
            // start session
            // set a unique session ID
            $_SESSION['id'] = uniqid();
            // set session variables
            $_SESSION['name'] = $user['Name'];
            $_SESSION['email'] = $user['Email'];
            $_SESSION['mobile'] = $user['Mobile'];
            $_SESSION['city'] = $user['city'];
            $_SESSION['state'] = $user['state'];
            $_SESSION['country'] = $user['country'];
            $_SESSION['pincode'] = $user['pincode'];
            $_SESSION['user_id'] = $user['id'];
            setcookie('user_id', $_SESSION['id'] . $user['id'], time() + (86400 * 30), "/");
            // Display success message
            echo 'success';
            exit;
        } else {
            // Password is incorrect
            echo 'Username or Password does not match';
            exit;
        }
    } else {
        // User not found
        echo 'Username does not found';
        exit;
    }
    $conn = null;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.dev/svgjs' width='1440' height='560' preserveAspectRatio='none' viewBox='0 0 1440 560'%3e%3cg mask='url(%26quot%3b%23SvgjsMask1153%26quot%3b)' fill='none'%3e%3crect width='1440' height='560' x='0' y='0' fill='url(%26quot%3b%23SvgjsLinearGradient1154%26quot%3b)'%3e%3c/rect%3e%3cpath d='M164.5953860065294 238.06334073884096L256.26602754091107 351.2671553073927 369.46984210946283 259.5965137730111 277.79920057508116 146.3926992044593z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M1322.002%2c538.54C1349.022%2c537.878%2c1366.532%2c513.008%2c1379.375%2c489.227C1391.404%2c466.955%2c1398.216%2c441.292%2c1386.695%2c418.753C1374.174%2c394.258%2c1349.501%2c376.203%2c1322.002%2c376.99C1295.558%2c377.747%2c1276.03%2c399.026%2c1263.419%2c422.281C1251.499%2c444.262%2c1248.291%2c469.834%2c1259.543%2c492.164C1272.05%2c516.984%2c1294.217%2c539.221%2c1322.002%2c538.54' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M847.58%2c170.576C872.964%2c169.269%2c893.757%2c151.213%2c904.825%2c128.331C914.561%2c108.203%2c909.877%2c85.12%2c898.109%2c66.108C887.034%2c48.216%2c868.605%2c36.684%2c847.58%2c35.848C824.897%2c34.946%2c802.491%2c43.124%2c789.576%2c61.793C774.584%2c83.464%2c766.725%2c111.553%2c779.123%2c134.805C792.106%2c159.155%2c820.022%2c171.995%2c847.58%2c170.576' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M860.61 510.14 a148.97 148.97 0 1 0 297.94 0 a148.97 148.97 0 1 0 -297.94 0z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M913.8770859662379 118.72981438405012L803.0234376946165 241.8452634689864 1036.9925350511742 229.5834626556715z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M155.5 510.77 a105.75 105.75 0 1 0 211.5 0 a105.75 105.75 0 1 0 -211.5 0z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M160.20063452844917 545.5071503664562L229.29689313404825 473.95588001084593 87.42185829783323 406.0871272802525z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M1446.871425535672 613.3266243118014L1506.107505538046 537.5078993888428 1371.0527006127134 554.0905443094273z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M686.0323540662771 265.11278199668345L689.5204093090359 165.22794860023822 589.6355759125908 161.73989335747933 586.1475206698319 261.62472675392456z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M1437.3176780725717 311.62940354490087L1510.0612274824948 218.52190618164593 1344.2101807093168 238.88585413497776z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M1097.8427120981485 595.3251170630675L1122.2982403255667 456.6309244377634 983.6040477002625 432.17539621034524 959.1485194728443 570.8695888356493z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float1'%3e%3c/path%3e%3cpath d='M482.15712167946003 412.8205200553936L543.1847141585018 342.6163056987455 407.3645963840088 286.177024158507z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float1'%3e%3c/path%3e%3c/g%3e%3cdefs%3e%3cmask id='SvgjsMask1153'%3e%3crect width='1440' height='560' fill='white'%3e%3c/rect%3e%3c/mask%3e%3clinearGradient x1='100%25' y1='50%25' x2='0%25' y2='50%25' gradientUnits='userSpaceOnUse' id='SvgjsLinearGradient1154'%3e%3cstop stop-color='%230e2a47' offset='0'%3e%3c/stop%3e%3cstop stop-color='rgba(0%2c 0%2c 0%2c 1)' offset='1'%3e%3c/stop%3e%3c/linearGradient%3e%3cstyle%3e %40keyframes float1 %7b 0%25%7btransform: translate(0%2c 0)%7d 50%25%7btransform: translate(-10px%2c 0)%7d 100%25%7btransform: translate(0%2c 0)%7d %7d .triangle-float1 %7b animation: float1 5s infinite%3b %7d %40keyframes float2 %7b 0%25%7btransform: translate(0%2c 0)%7d 50%25%7btransform: translate(-5px%2c -5px)%7d 100%25%7btransform: translate(0%2c 0)%7d %7d .triangle-float2 %7b animation: float2 4s infinite%3b %7d %40keyframes float3 %7b 0%25%7btransform: translate(0%2c 0)%7d 50%25%7btransform: translate(0%2c -10px)%7d 100%25%7btransform: translate(0%2c 0)%7d %7d .triangle-float3 %7b animation: float3 6s infinite%3b %7d %3c/style%3e%3c/defs%3e%3c/svg%3e");
            background-attachment: fixed;
            background-size: cover;
        }

        .container {
            max-width: 400px;
            margin: 30px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mt-5 mb-4">Login to your account</h2>
        <p>
            Don't have an account? <a href="register.php">Register</a>
        </p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data" id="login">
            <div class="form-group">
                <label for="username">Email or Mobile:</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter email or mobile" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
    <script>
        // reset form after successful login
        $('#login').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response === 'success') {
                        window.location.href = 'dashboard/dashboard.php';
                    } else {
                        console.log(response);
                        alert(response);
                    }
                }
            })
        })
    </script>
</body>

</html>