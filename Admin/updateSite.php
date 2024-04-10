<?php
require_once "config.php";
session_start();
if (!isset($_SESSION['Admin_id'])) {
    header("location:login.php");
    exit;
}
//fetch data from database
$sql = "SELECT * FROM admin WHERE name = :email";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $_SESSION['AdminName'], PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Define variables and initialize with empty values
        $email = $phone = $address = $facebook = $twitter = $youtube = $password = $token = $contactEmail = $logo = $name = '';

        // Processing form data when form is submitted
        // Validate email
        $email = trim($_POST['email']);

        // Validate phone
        $phone = trim($_POST['phone']);

        // Validate address
        $address = trim($_POST['address']);

        // Validate social media links
        $facebook = trim($_POST['facebook']);
        $twitter = trim($_POST['twitter']);
        $youtube = trim($_POST['youtube']);

        // Validate password
        $password = trim($_POST['password']);


        // Validate contact email
        $contactEmail = trim($_POST['contactEmail']);

        // Validate logo file
        $logo = $_FILES['logo']['name'];
        $logo_tmp = $_FILES['logo']['tmp_name'];

        // Move uploaded logo to a specific directory

        // Validate name
        $name = trim($_POST['name']);

        // Prepare the SQL statement
        $sql = "UPDATE admin SET email=:email, phone=:phone, address=:address, facebook=:facebook, twitter=:twitter, youtube=:youtube, password=:password, contactEmail=:contactEmail, logo=:logo, name=:name";
        
        // Prepare the prepared statement
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind parameters
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':facebook', $facebook);
            $stmt->bindParam(':twitter', $twitter);
            $stmt->bindParam(':youtube', $youtube);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':contactEmail', $contactEmail);
            $stmt->bindParam(':logo', $logo);
            $stmt->bindParam(':name', $name);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to success page
                move_uploaded_file($logo_tmp, "uploads/$logo");
                echo "success";
                exit();
            } else {
                echo "Error updating record. Please try again.";
            }
        } else {
            echo "Error preparing statement.";
        }

        // Close statement
        unset($stmt);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }

    // Close connection
    unset($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popular Destination Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> <style>
        body {
            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25'%3E%3Cdefs%3E%3ClinearGradient id='a' gradientUnits='userSpaceOnUse' x1='0' x2='0' y1='0' y2='100%25' gradientTransform='rotate(240)'%3E%3Cstop offset='0' stop-color='%23ffffff'/%3E%3Cstop offset='1' stop-color='%234FE'/%3E%3C/linearGradient%3E%3Cpattern patternUnits='userSpaceOnUse' id='b' width='540' height='450' x='0' y='0' viewBox='0 0 1080 900'%3E%3Cg fill-opacity='0.1'%3E%3Cpolygon fill='%23444' points='90 150 0 300 180 300'/%3E%3Cpolygon points='90 150 180 0 0 0'/%3E%3Cpolygon fill='%23AAA' points='270 150 360 0 180 0'/%3E%3Cpolygon fill='%23DDD' points='450 150 360 300 540 300'/%3E%3Cpolygon fill='%23999' points='450 150 540 0 360 0'/%3E%3Cpolygon points='630 150 540 300 720 300'/%3E%3Cpolygon fill='%23DDD' points='630 150 720 0 540 0'/%3E%3Cpolygon fill='%23444' points='810 150 720 300 900 300'/%3E%3Cpolygon fill='%23FFF' points='810 150 900 0 720 0'/%3E%3Cpolygon fill='%23DDD' points='990 150 900 300 1080 300'/%3E%3Cpolygon fill='%23444' points='990 150 1080 0 900 0'/%3E%3Cpolygon fill='%23DDD' points='90 450 0 600 180 600'/%3E%3Cpolygon points='90 450 180 300 0 300'/%3E%3Cpolygon fill='%23666' points='270 450 180 600 360 600'/%3E%3Cpolygon fill='%23AAA' points='270 450 360 300 180 300'/%3E%3Cpolygon fill='%23DDD' points='450 450 360 600 540 600'/%3E%3Cpolygon fill='%23999' points='450 450 540 300 360 300'/%3E%3Cpolygon fill='%23999' points='630 450 540 600 720 600'/%3E%3Cpolygon fill='%23FFF' points='630 450 720 300 540 300'/%3E%3Cpolygon points='810 450 720 600 900 600'/%3E%3Cpolygon fill='%23DDD' points='810 450 900 300 720 300'/%3E%3Cpolygon fill='%23AAA' points='990 450 900 600 1080 600'/%3E%3Cpolygon fill='%23444' points='990 450 1080 300 900 300'/%3E%3Cpolygon fill='%23222' points='90 750 0 900 180 900'/%3E%3Cpolygon points='270 750 180 900 360 900'/%3E%3Cpolygon fill='%23DDD' points='270 750 360 600 180 600'/%3E%3Cpolygon points='450 750 540 600 360 600'/%3E%3Cpolygon points='630 750 540 900 720 900'/%3E%3Cpolygon fill='%23444' points='630 750 720 600 540 600'/%3E%3Cpolygon fill='%23AAA' points='810 750 720 900 900 900'/%3E%3Cpolygon fill='%23666' points='810 750 900 600 720 600'/%3E%3Cpolygon fill='%23999' points='990 750 900 900 1080 900'/%3E%3Cpolygon fill='%23999' points='180 0 90 150 270 150'/%3E%3Cpolygon fill='%23444' points='360 0 270 150 450 150'/%3E%3Cpolygon fill='%23FFF' points='540 0 450 150 630 150'/%3E%3Cpolygon points='900 0 810 150 990 150'/%3E%3Cpolygon fill='%23222' points='0 300 -90 450 90 450'/%3E%3Cpolygon fill='%23FFF' points='0 300 90 150 -90 150'/%3E%3Cpolygon fill='%23FFF' points='180 300 90 450 270 450'/%3E%3Cpolygon fill='%23666' points='180 300 270 150 90 150'/%3E%3Cpolygon fill='%23222' points='360 300 270 450 450 450'/%3E%3Cpolygon fill='%23FFF' points='360 300 450 150 270 150'/%3E%3Cpolygon fill='%23444' points='540 300 450 450 630 450'/%3E%3Cpolygon fill='%23222' points='540 300 630 150 450 150'/%3E%3Cpolygon fill='%23AAA' points='720 300 630 450 810 450'/%3E%3Cpolygon fill='%23666' points='720 300 810 150 630 150'/%3E%3Cpolygon fill='%23FFF' points='900 300 810 450 990 450'/%3E%3Cpolygon fill='%23999' points='900 300 990 150 810 150'/%3E%3Cpolygon points='0 600 -90 750 90 750'/%3E%3Cpolygon fill='%23666' points='0 600 90 450 -90 450'/%3E%3Cpolygon fill='%23AAA' points='180 600 90 750 270 750'/%3E%3Cpolygon fill='%23444' points='180 600 270 450 90 450'/%3E%3Cpolygon fill='%23444' points='360 600 270 750 450 750'/%3E%3Cpolygon fill='%23999' points='360 600 450 450 270 450'/%3E%3Cpolygon fill='%23666' points='540 600 630 450 450 450'/%3E%3Cpolygon fill='%23222' points='720 600 630 750 810 750'/%3E%3Cpolygon fill='%23FFF' points='900 600 810 750 990 750'/%3E%3Cpolygon fill='%23222' points='900 600 990 450 810 450'/%3E%3Cpolygon fill='%23DDD' points='0 900 90 750 -90 750'/%3E%3Cpolygon fill='%23444' points='180 900 270 750 90 750'/%3E%3Cpolygon fill='%23FFF' points='360 900 450 750 270 750'/%3E%3Cpolygon fill='%23AAA' points='540 900 630 750 450 750'/%3E%3Cpolygon fill='%23FFF' points='720 900 810 750 630 750'/%3E%3Cpolygon fill='%23222' points='900 900 990 750 810 750'/%3E%3Cpolygon fill='%23222' points='1080 300 990 450 1170 450'/%3E%3Cpolygon fill='%23FFF' points='1080 300 1170 150 990 150'/%3E%3Cpolygon points='1080 600 990 750 1170 750'/%3E%3Cpolygon fill='%23666' points='1080 600 1170 450 990 450'/%3E%3Cpolygon fill='%23DDD' points='1080 900 1170 750 990 750'/%3E%3C/g%3E%3C/pattern%3E%3C/defs%3E%3Crect x='0' y='0' fill='url(%23a)' width='100%25' height='100%25'/%3E%3Crect x='0' y='0' fill='url(%23b)' width='100%25' height='100%25'/%3E%3C/svg%3E");
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
        .navbar{
            backdrop-filter: blur(3px);
            background-color: rgba(250, 250, 250, 0.8);
            position: sticky;
            top: 0;
            z-index: 99;
        }
        .navbar a{
            color: #050505;
            font-weight: 600;
        }
        .navbar .navbar-brand{
            text-transform:capitalize !important;
        }
    </style>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light text-dark">
            <a class="navbar-brand font-weight-bold" href="#"><?= $_SESSION['AdminName']; ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                        <a class="nav-link" href="dashboard.php">Create a tour</span></a>
                    </li>
                    <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'popularDestination.php' ? 'active' : ''; ?>">
                        <a class="nav-link" href="popularDestination.php">Popular Destination</a>
                    </li>
                    <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'gallery.php' ? 'active' : ''; ?>">
                        <a class="nav-link" href="gallery.php">Gallery</a>
                    </li>
                    <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'updateSite.php' ? 'active' : ''; ?>">
                        <a class="nav-link" href="updateSite.php">Update Site</a>
                    </li>
                    <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'logout.php' ? 'active' : ''; ?>">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    <div class="container-fluid">
      
        <div class="container mt-3 mb-5">
            <h2 class="mt-5 mb-4 text-center">Update admin Details or website Data</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="createForm">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" value="<?= $row['email']; ?>" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="tel" class="form-control" id="phone" value="<?= $row['phone']; ?>" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" value="<?= $row['address']; ?>" name="address" required>
                </div>
                <div class="form-group">
                    <label for="facebook">Facebook:</label>
                    <input type="text" class="form-control" id="facebook" value="<?= $row['facebook']; ?>" name="facebook" required>
                </div>
                <div class="form-group">
                    <label for="twitter">Twitter:</label>
                    <input type="text" class="form-control" id="twitter" value="<?= $row['twitter']; ?>" name="twitter" required>
                </div>
                <div class="form-group">
                    <label for="youtube">Youtube:</label>
                    <input type="text" class="form-control" id="youtube" value="<?= $row['youtube']; ?>" name="youtube" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" value="<?= $row['password']; ?>" name="password" required>
                </div>
                <div class="form-group">
                    <label for="contactEmail">Contact Email:</label>
                    <input type="email" class="form-control" id="contactEmail" value="<?= $row['contactEmail']; ?>" name="contactEmail" required>
                </div>
                <div class="form-group">
                    <label for="logo">Website Logo:</label>
                    <input type="file" class="form-control-file" id="logo" name="logo" required>
                </div>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" value="<?= $row['name']; ?>" name="name" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Data</button>
            </form>
        </div>
    </div>
    <script>
        // Reset form data after submission
        $(document).ready(function() {
            $('#createForm').submit(function(event) {
                event.preventDefault(); // Prevent form submission

                // Perform AJAX submission
                var formData = new FormData(this);
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response === 'success') {
                            alert('Form submitted successfully!');
                        } else {
                            alert('Error submitting form: ' + response);
                        }
                    },
                    error: function() {
                        alert('Error submitting form!');
                    }
                });
            });
        });

        function deleteCard(cardId) {
            $.ajax({
                url: 'delete_popular.php',
                type: 'POST',
                data: {
                    id: cardId
                },
                success: function(data) {
                    if (data === 'success') {
                        $('#card-' + cardId).remove();
                    } else {
                        alert(data);
                    }
                }
            })
        }
    </script>
</body>

</html>