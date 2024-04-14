<?php
require_once "Admin/config.php";
session_start();
$isLoggedIn = false;
// check user login or not 
if (isset($_SESSION['id'])) {
    $isLoggedIn = true;
}
// fetch site data from table admin 
$stmt = $conn->prepare("SELECT * FROM admin");
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$address = $data['address'];
$phone = $data['phone'];
$yt = $data['youtube'];
$fb = $data['facebook'];
$x = $data['twitter'];
$email = $data['contactEmail'];
$logo = $data['logo'];
$searchTerm = $_GET['search'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preload" as="image" href="Admin/uploads/<?= $logo ?>" />
    <link rel="preload" as="image" href="assets/images/hero-banner.jpg" />
    <meta name="description" content="Explore the rich cultural heritage of Bharat through its ancient temples. Plan your trip to experience spirituality and architectural marvels.">
    <meta name="keywords" content="Bharat, temple, tourism, cultural heritage, spirituality, architecture">
    <meta name="author" content="Official Dev Vineet">
    <meta property="og:title" content="Bharat Temple Tourism">
    <meta property="og:description" content="Explore the rich cultural heritage of Bharat through its ancient temples. Plan your trip to experience spirituality and architectural marvels.">
    <meta property="og:image" content="Admin/uploads/<?= $logo ?>">
    <meta property="og:url" content="https://bharattempletourism.com/bharat-temple-tourism">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Bharat Temple Tourism">
    <meta name="twitter:description" content="Explore the rich cultural heritage of Bharat through its ancient temples. Plan your trip to experience spirituality and architectural marvels.">
    <meta name="twitter:image" content="Admin/uploads/<?= $logo ?>">
    <title>Bharat Temple Tour Search Page for : <?= $searchTerm ?></title>
    <link rel="icon" href="Admin/uploads/<?= $logo ?>" />
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        .column-gap {
            gap: 1rem;
        }

        .column-gap span {
            text-transform: capitalize;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <!-- Back to Home button -->
        <div class="row">
            <h2 class="text-center col-md-6 row column-gap">
                Search Results:<span class="text-primary"><?= $searchTerm ?></span>
            </h2>
           <div class="container col-md-6"> <a href="index.php" class="btn btn-primary d-block" style="display:block;margin-left:auto;width:max-content" >Back to Home</a></div>
        </div>
        <div class="row" style="display: flex; align-items: center; justify-content: space-between;">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="filterBy">Filter By:</label>
                    <select class="form-control" id="filterBy">
                        <option value="price" selected>Price (low to high)</option>
                        <option value="review">Review (high to low)</option>
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" value="<?= $searchTerm ?>" id="searchTerm" placeholder="Search...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" id="searchButton" type="button">Search</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="packages mt-3" id="result">
                    <!-- Results will be dynamically added here -->
                </ul>
            </div>
        </div>
    </div>

    <!-- jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Fetch data when the document is ready
        $(document).ready(function() {
            fetchData();
        });

        // Function to fetch data based on selected filter and search term
        function fetchData() {
            var filter = $('#filterBy').val();
            var searchTerm = $('#searchTerm').val();
            // chnage url query params only 
            window.history.replaceState({}, '', `searchPage.php?search=${searchTerm.trim()}&filter=${filter.trim()}`);

            $.ajax({
                type: "POST",
                url: "product.php",
                data: {
                    filterBy: filter.trim(),
                    searchTerm: searchTerm.trim()
                },
                success: function(data) {
                    $("#result").html(data);
                }
            });
        }
        // Event listener for the search input
        $('#searchTerm').keyup(function(e) {
            if (e.keyCode == 13) {
                fetchData();
            }
        })
        // Event listener for the search button
        $('#searchButton').click(function() {
            fetchData(); // Call fetchData when the search button is clicked
        });
        // change data when filter is changed
        $('#filterBy').change(function() {
            fetchData();
        })
    </script>
</body>

</html>