<?php
// database connection 
session_start();
if (!isset($_SESSION['Admin_id'])) {
    header("location:login.php");
    exit;
}
require_once "config.php";
$msg = '';
$warning = '';
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["title"], $_POST["description"], $_FILES["image"], $_POST["pax"], $_POST["location"], $_POST["day"], $_POST["night"], $_POST["price"], $_POST["reviewCount"])) {
    // Connect to your database (modify these with your actual database credentials)

    move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $_FILES["image"]["name"]);
    try {
        // Prepare and execute SQL query to insert data into tour_packages table
        $stmt = $conn->prepare("INSERT INTO tourpackages (tourId,title, description, image, pax, location, day, night, price, reviewCount)VALUES (:tourId,:title, :description, :image, :pax, :location, :day, :night, :price, :reviewCount)");
        // create tourId
        $tourId = uniqid();
        $stmt->bindParam(':tourId', $tourId);
        $stmt->bindParam(':title', $_POST["title"]);
        $stmt->bindParam(':description', $_POST["description"]);
        $stmt->bindParam(':image', $_FILES["image"]["name"]);
        $stmt->bindParam(':pax', $_POST["pax"]);
        $stmt->bindParam(':location', $_POST["location"]);
        $stmt->bindParam(':day', $_POST["day"]);
        $stmt->bindParam(':night', $_POST["night"]);
        $stmt->bindParam(':price', $_POST["price"]);
        $stmt->bindParam(':reviewCount', $_POST["reviewCount"]);
        $stmt->execute();
        // upload file into uploads folder
        $msg = "New tour package created successfully!";
    } catch (PDOException $e) {
        $warning = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To Admin Dashboard: <?= $_SESSION['AdminName']; ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.dev/svgjs' width='1440' height='560' preserveAspectRatio='none' viewBox='0 0 1440 560'%3e%3cg mask='url(%26quot%3b%23SvgjsMask1153%26quot%3b)' fill='none'%3e%3crect width='1440' height='560' x='0' y='0' fill='url(%26quot%3b%23SvgjsLinearGradient1154%26quot%3b)'%3e%3c/rect%3e%3cpath d='M164.5953860065294 238.06334073884096L256.26602754091107 351.2671553073927 369.46984210946283 259.5965137730111 277.79920057508116 146.3926992044593z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M1322.002%2c538.54C1349.022%2c537.878%2c1366.532%2c513.008%2c1379.375%2c489.227C1391.404%2c466.955%2c1398.216%2c441.292%2c1386.695%2c418.753C1374.174%2c394.258%2c1349.501%2c376.203%2c1322.002%2c376.99C1295.558%2c377.747%2c1276.03%2c399.026%2c1263.419%2c422.281C1251.499%2c444.262%2c1248.291%2c469.834%2c1259.543%2c492.164C1272.05%2c516.984%2c1294.217%2c539.221%2c1322.002%2c538.54' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M847.58%2c170.576C872.964%2c169.269%2c893.757%2c151.213%2c904.825%2c128.331C914.561%2c108.203%2c909.877%2c85.12%2c898.109%2c66.108C887.034%2c48.216%2c868.605%2c36.684%2c847.58%2c35.848C824.897%2c34.946%2c802.491%2c43.124%2c789.576%2c61.793C774.584%2c83.464%2c766.725%2c111.553%2c779.123%2c134.805C792.106%2c159.155%2c820.022%2c171.995%2c847.58%2c170.576' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M860.61 510.14 a148.97 148.97 0 1 0 297.94 0 a148.97 148.97 0 1 0 -297.94 0z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M913.8770859662379 118.72981438405012L803.0234376946165 241.8452634689864 1036.9925350511742 229.5834626556715z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M155.5 510.77 a105.75 105.75 0 1 0 211.5 0 a105.75 105.75 0 1 0 -211.5 0z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M160.20063452844917 545.5071503664562L229.29689313404825 473.95588001084593 87.42185829783323 406.0871272802525z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M1446.871425535672 613.3266243118014L1506.107505538046 537.5078993888428 1371.0527006127134 554.0905443094273z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M686.0323540662771 265.11278199668345L689.5204093090359 165.22794860023822 589.6355759125908 161.73989335747933 586.1475206698319 261.62472675392456z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M1437.3176780725717 311.62940354490087L1510.0612274824948 218.52190618164593 1344.2101807093168 238.88585413497776z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M1097.8427120981485 595.3251170630675L1122.2982403255667 456.6309244377634 983.6040477002625 432.17539621034524 959.1485194728443 570.8695888356493z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float1'%3e%3c/path%3e%3cpath d='M482.15712167946003 412.8205200553936L543.1847141585018 342.6163056987455 407.3645963840088 286.177024158507z' fill='rgba(12%2c 207%2c 237%2c 0.4)' class='triangle-float1'%3e%3c/path%3e%3c/g%3e%3cdefs%3e%3cmask id='SvgjsMask1153'%3e%3crect width='1440' height='560' fill='white'%3e%3c/rect%3e%3c/mask%3e%3clinearGradient x1='100%25' y1='50%25' x2='0%25' y2='50%25' gradientUnits='userSpaceOnUse' id='SvgjsLinearGradient1154'%3e%3cstop stop-color='%230e2a47' offset='0'%3e%3c/stop%3e%3cstop stop-color='rgba(0%2c 0%2c 0%2c 1)' offset='1'%3e%3c/stop%3e%3c/linearGradient%3e%3cstyle%3e %40keyframes float1 %7b 0%25%7btransform: translate(0%2c 0)%7d 50%25%7btransform: translate(-10px%2c 0)%7d 100%25%7btransform: translate(0%2c 0)%7d %7d .triangle-float1 %7b animation: float1 5s infinite%3b %7d %40keyframes float2 %7b 0%25%7btransform: translate(0%2c 0)%7d 50%25%7btransform: translate(-5px%2c -5px)%7d 100%25%7btransform: translate(0%2c 0)%7d %7d .triangle-float2 %7b animation: float2 4s infinite%3b %7d %40keyframes float3 %7b 0%25%7btransform: translate(0%2c 0)%7d 50%25%7btransform: translate(0%2c -10px)%7d 100%25%7btransform: translate(0%2c 0)%7d %7d .triangle-float3 %7b animation: float3 6s infinite%3b %7d %3c/style%3e%3c/defs%3e%3c/svg%3e");
            background-attachment: fixed;
            background-size: cover;
            color: #f5f5f5;
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

        <div class="container mt-5">
            <h2>Create a new tour.</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" id="createATour">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter tour title" required />
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter tour description" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image URL</label>
                    <input type="file" class="form-control" id="image" name="image" placeholder="Upload image" required />
                </div>

                <div class="mb-3">
                    <label for="pax" class="form-label">Pax</label>
                    <input type="number" class="form-control" id="pax" name="pax" placeholder="Enter maximum number of participants" required />
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" required class="form-control" id="location" name="location" placeholder="Enter tour location" />
                </div>

                <div class="row g-3 mb-3">
                    <div class="col">
                        <label for="day" class="form-label">Days</label>
                        <input type="number" required class="form-control" id="day" name="day" placeholder="Number of days" />
                    </div>
                    <div class="col">
                        <label for="night" class="form-label">Nights</label>
                        <input type="number" required class="form-control" id="night" name="night" placeholder="Number of nights" />
                    </div>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" required class="form-control" id="price" name="price" placeholder="Enter price" />
                </div>

                <div class="mb-3">
                    <label for="reviewCount" class="form-label">Review Count</label>
                    <input type="number" class="form-control" id="reviewCount" name="reviewCount" placeholder="Enter number of reviews" required />
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <?php
            if (!empty($msg)) {
            ?>
                <div class="alert alert-success mt-3" role="alert">
                    <?php echo $msg; ?>
                </div>
            <?php
            }
            if (!empty($warning)) {
            ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?php echo $warning; ?>
                </div>
            <?php
            }

            ?>
        </div>
        <?php
        $stmt = $conn->prepare("SELECT * FROM tourpackages");
        $stmt->execute();
        $tourpackages = $stmt->fetchAll();

        ?>
        <?php
        if (!empty($tourpackages)) {
        ?>
            <div class="container mt-5">
                <h2>Tour Packages</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="text-light">
                                <th scope="col">#Id</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Image</th>
                                <th scope="col">Pax</th>
                                <th scope="col">Location</th>
                                <th scope="col">Day</th>
                                <th scope="col">Night</th>
                                <th scope="col">Price</th>
                                <th scope="col">Review Count</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($tourpackages as $tourpackage) {
                            ?>
                                <tr id="tourpackage<?php echo $tourpackage["id"]; ?>" class="text-light">
                                    <th scope="row"><?php echo $tourpackage["id"]; ?></th>
                                    <td><?php echo $tourpackage["title"]; ?></td>
                                    <td><?php echo $tourpackage["description"]; ?></td>
                                    <td><img src="uploads/<?php echo $tourpackage["image"]; ?>" width="100" alt="tour package image"></td>
                                    <td><?php echo $tourpackage["pax"]; ?></td>
                                    <td><?php echo $tourpackage["location"]; ?></td>
                                    <td><?php echo $tourpackage["day"]; ?></td>
                                    <td><?php echo $tourpackage["night"]; ?></td>
                                    <td><?php echo $tourpackage["price"]; ?></td>
                                    <td><?php echo $tourpackage["reviewCount"]; ?></td>
                                    <td> <button type="button" class="btn btn-danger" onclick='deleteTourPackage(<?php echo $tourpackage["id"]; ?>)'>Delete</button> </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                No tour packages found
                            </div>
                        <?php
                        }

                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    <script>
        // reset form using ajax 

        document.getElementById("createATour").addEventListener("submit", function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function() {
                    alert("tour created successfully!");
                    $("#createATour")[0].reset(); // Reset the form
                },
                error: function() {
                    alert("Error uploading file!");
                }
            });
        })

        // delete tour package
        function deleteTourPackage(id) {
            $.ajax({
                url: "delete_tourpackage.php",
                type: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    if (data === "success") {
                        alert("Tour package deleted successfully");
                        $("#tourpackage" + id).remove();
                    } else {
                        alert("Failed to delete tour package");
                    }
                }
            })
        }
    </script>
</body>

</html>