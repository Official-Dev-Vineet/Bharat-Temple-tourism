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

$tourId = $_GET['id'];
// fetch data from tourpackages table

$sql = "select * from tourpackages where tourId= :tourId";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':tourId', $tourId, PDO::PARAM_STR);
$stmt->execute();

$result = $stmt->fetch();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preload" as="image" href="Admin/uploads/<?= $logo ?>" />
    <link rel="preload" as="image" href="admin/<?= $result['image'] ?>" />
    <meta name="description" content="<?= $result['description'] ?>">
    <meta name="keywords" content="Bharat, temple, tourism, cultural heritage, spirituality, architecture">
    <meta name="author" content="Official Dev Vineet">
    <meta property="og:title" content="<?= $result['title'] ?>">
    <meta property="og:description" content="<?= $result['description'] ?>">
    <meta property="og:image" content="Admin/<?= $result['image'] ?>">
    <meta property="og:url" content="https://<?= htmlspecialchars($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $result['title'] ?>">
    <meta name="twitter:description" content="<?= $result['description'] ?>">
    <meta name="twitter:image" content="Admin/<?= $result['image'] ?>">
    <title>Bharat Temple Tourism</title>
    <link rel="icon" href="Admin/uploads/<?= $logo ?>" />
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <!-- Bootstrap CSS -->

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .grid {
            padding: 5rem 0;
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 1rem;
        }

        .grid .image {
            width: 100%;
            height: 300px;
            border-radius: 50%;
            overflow: hidden;
        }

        .grid .image img {
            max-width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .grid .content *:not(h2) {
            text-align: left !important;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .grid .image {
                height: auto;
                border-radius: 30px;
            }

            .grid .image img {
                width: 100%;
                height: auto;
                object-fit: cover;
            }

            .grid .content {
                padding-top: 1rem;
            }
        }

        .details-content {
            max-width: 1300px;
            margin: 0 auto;
            padding: 20px;
        }

        .details-content h2 {
            color: #333;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .details-content ul {
            list-style-type: none;
            padding-left: 0;
        }

        .details-content ul li {
            margin-bottom: 10px;
            border-left: 5px solid #007bff;
            /* Blue color for the left border */
            padding-left: 10px;
        }

        .details-content ul li span:first-child {
            display: block;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }

        .details-content ul li i {
            margin-right: 10px;
            color: #dc3545;
            /* Red color for the icon */
        }

        .details-content ul li span {
            display: inline-block;
            vertical-align: middle;
        }

        @media (max-width: 768px) {
            .details-content {
                padding: 0px;
            }

            .details-content ul li i {
                margin-right: 5px;
            }
        }

        @media (max-width: 768px) {
            .details-content ul li {
                border-left-width: 3px;
                /* Reduce the left border width for smaller screens */
            }
        }

        .booknow-button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .booknow-button:hover {
            background-color: #0056b3;
        }

        .person-counter {
            display: inline-block;
            margin-left: 10px;
            margin-right: 10px;
        }

        .counter-button {
            background-color: #28a745;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .counter-button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body id="top">
    <header class="header" data-header>
        <div class="overlay" data-overlay></div>
        <div class="header-top">
            <div class="container">

                <a href="/" class="logo">
                    <img src="Admin/uploads/<?= $logo ?>" alt="Bharat Temple Tourism" />
                </a>

                <div class="header-btn-group">
                    <a href="tel:<?= $phone; ?>" class="helpline-box">
                        <div class="icon-box">
                            <ion-icon name="call-outline"></ion-icon>
                        </div>
                        <div class="wrapper">
                            <p class="helpline-title">For Further Inquires :</p>
                            <p class="helpline-number"><?= $phone; ?></p>
                        </div>
                    </a>
                    <button class="nav-open-btn" aria-label="Open Menu" data-nav-open-btn>
                        <ion-icon name="menu-outline"></ion-icon>
                    </button>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <ul class="social-list">
                    <li>
                        <a href="<?= $fb ?>" class="social-link">
                            <ion-icon name="logo-facebook"></ion-icon>
                        </a>
                    </li>

                    <li>
                        <a href="<?= $x ?>" class="social-link">
                            <ion-icon name="logo-twitter"></ion-icon>
                        </a>
                    </li>

                    <li>
                        <a href="<?= $yt ?>" class="social-link">
                            <ion-icon name="logo-youtube"></ion-icon>
                        </a>
                    </li>
                </ul>
                <nav class="navbar" data-navbar>
                    <div class="navbar-top">
                        <a href="#" class="logo">
                            <img src="Admin/uploads/<?php echo $logo ?>" alt="Bharat Temple tourism" />
                        </a>

                        <button class="nav-close-btn" aria-label="Close Menu" data-nav-close-btn>
                            <ion-icon name="close-outline"></ion-icon>
                        </button>
                    </div>
                    <ul class="navbar-list">
                        <li>
                            <a href="#home" class="navbar-link" data-nav-link>home</a>
                        </li>
                        <li>
                            <a href="#destination" class="navbar-link" data-nav-link>destination</a>
                        </li>

                        <li>
                            <a href="#package" class="navbar-link" data-nav-link>packages</a>
                        </li>

                        <li>
                            <a href="#gallery" class="navbar-link" data-nav-link>gallery</a>
                        </li>

                        <li>
                            <a href="#contact" class="navbar-link" data-nav-link>contact us</a>
                        </li>
                    </ul>

                </nav>

                <a href="User/" class="btn btn-primary">Login</a>
            </div>
        </div>
    </header>

    <main>
        <article>
            <section class="hero" id="home" style="background-image: url(admin/<?= $result['image']; ?>);">
                <div class="container">
                    <h2 class="h1 hero-title"><?= $result['title']; ?></h2>
                    <div class="btn-group">
                        <button class="btn btn-secondary" onclick="window.location.href='#details'">View Details</button>
                    </div>
                </div>
            </section>

            <section class="details" id="details">
                <div class="container">
                    <div class="details-content">
                        <div class="grid">
                            <div class="image">
                                <img src="admin/<?= $result['image']; ?>" alt="<?= $result['title']; ?>">
                            </div>
                            <div class="content">
                                <h2 class="h2 section-title"><?= $result['title']; ?></h2>
                                <p class="section-text"><strong>Description:</strong> <?= $result['description']; ?> </p>
                                <p class="section-text"><strong>Location:</strong> <?= $result['location']; ?> <i class="fa-solid fa-location-dot"></i></p>
                                <p class="section-text"><strong>Pax:</strong> <?= $result['reviewCount']; ?> <i class="fa-solid fa-user-group"></i> </p>
                                <p class="section-text"><strong>Review:</strong> <?= $result['reviewCount']; ?>(<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>) </p>
                                <p class="section-text">Price : <?= $result['price'] ?> <i class="fa-solid fa-indian-rupee-sign"></i></p>
                            </div>
                            <button class="booknow-button" onclick="window.location.href='user/Dashboard/Book-a-tour.php?tourId=<?= $result['tourId']; ?>'">Book Now</button>
                        </div>
                    </div>
                    <div class="container">
                        <div class="details-content">
                            <h2 class="h2" style="text-align: left;"><strong>Tour schedule:</strong></h2>
                            <ul><?php
                                $includePoints = explode("\n", $result['schedule']);
                                $sno = 1;
                                foreach ($includePoints as $point) {
                                    echo '<li><span><strong>Day-' . $sno . '</strong></span><span>' . trim($point) . '</span></li>';
                                    $sno++;
                                }
                                ?></ul>
                        </div>
                    </div>
                    <div class="container">
                        <div class="details-content">
                            <h2 class="h2" style="text-align: left;"><strong>Includes:</strong></h2>
                            <ul><?php
                                $includePoints = explode("\n", $result['include']);
                                foreach ($includePoints as $point) {
                                    echo '<li><i class="fa-solid fa-check" style="color: #28a745; "></i><span>' . trim($point) . '</span></li>';
                                }
                                ?></ul>
                        </div>
                    </div>
                    <div class="container ">
                        <div class="details-content">
                            <h2 class="h2" style="text-align: left;"><strong>Excludes:</strong></h2>
                            <ul><?php
                                $includePoints = explode("\n", $result['exclude']);
                                foreach ($includePoints as $point) {
                                    echo '<li><i class="fa-solid fa-xmark"></i><span>' . trim($point) . '</span></li>';
                                }
                                ?></ul>
                        </div>

                    </div>
                </div>
            </section>
            <section class="cta" id="contact">
                <div class="container">
                    <div class="cta-content">
                        <p class="section-subtitle">Call To Action</p>
                        <h2 class="h2 section-title">Ready For Unforgettable Travel. Remember Us ! </h2>
                        <p class="section-text">Embark on a voyage where each destination promises memories that will last a lifetime. With a world waiting to be explored,
                            our tailor-made travel experiences are designed to immerse you in the essence of each location,
                            offering not just a trip,
                            but a journey filled with unforgettable moments. Your adventure of a lifetime is just a click away. Remember us,
                            because we're here
                            to make it extraordinary. </p>
                    </div><a href="mailto:viratsinghkaharwar8923@gmail.com" class="btn btn-primary" style="outline: 1px solid">Contact Us !</a>
                </div>
            </section>
        </article>
    </main>
    <footer class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="footer-brand"><a href="#" class="logo"><img src="Admin/uploads/<?= $logo ?>" alt="Bharat Temple tourism" /></a>
                    <p class="footer-text">Your faith journey is deeply personal,
                        and our bespoke tours cater to your individual spiritual needs. Whether it's a quest for
                        peace,
                        a pilgrimage of devotion,
                        or a deep dive into the architectural and historical significance of India's holy sites,
                        we tailor your journey to ensure it's as unique as your spiritual
                        path. </p>
                </div>
                <div class="footer-contact">
                    <p class="contact-title">Contact Us</p>
                    <p class="contact-text">Feel free to contact and reach us ! !</p>
                    <ul>
                        <li class="contact-item"><ion-icon name="call-outline"></ion-icon><a href="tel:<?= $phone ?>" class="contact-link"><?= $phone ?></a></li>
                        <li class="contact-item"><ion-icon name="mail-outline"></ion-icon><a href="mailto:<?= $email ?>" class="contact-link"><?= $email ?></a></li>
                        <li class="contact-item"><ion-icon name="location-outline"></ion-icon>
                            <address><?= $address ?></address>
                        </li>
                    </ul>
                </div>
                <div class="footer-form">
                    <p class="form-text">Subscribe our newsletter for more update & news ! ! </p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-wrapper"><input type="email" name="email" class="input-field" placeholder="Enter Your Email" required /><button type="submit" class="btn btn-secondary">Subscribe</button></form>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p class="copyright">&copy;

                    2024 <a href="https://dev-vineet.online">Official Dev Vineet</a>. All rights reserved </p>
                <ul class="footer-bottom-list">
                    <li><a href="./privacy-policy.php" class="footer-bottom-link">Privacy Policy</a></li>
                    <li><a href="./term.php" class="footer-bottom-link">Term & Condition</a></li>
                    <li><a href="./refund-policy.php" class="footer-bottom-link">Refund Policy</a></li>
                </ul>
            </div>
        </div>
    </footer><a href="#top" class="go-top" data-go-top><ion-icon name="chevron-up-outline"></ion-icon></a>
    <script src="./assets/js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));

                if (target.length) {
                    event.preventDefault();

                    $('html, body').animate({
                            scrollTop: target.offset().top
                        }

                        , 1000);
                }
            })

        })
        $(document).ready(function() {
            $('.form-wrapper').on('submit', function(event) {
                event.preventDefault();

                $.ajax({

                    url: 'newsletter.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(data) {
                            alert(data);
                            // reset form 
                            $('.form-wrapper')[0].reset();
                        }

                        ,
                    error: function(err) {
                        alert('Something went wrong!', err);
                    }
                })
            })

        })

        function share(link) {
            navigator.share({

                title: 'Bharat Temple Tourism',
                text: 'Check out this website',
                url: link,
            }).then(() => {
                console.log('Thanks for sharing!');

            }).catch((error) => {
                console.error('Error sharing:', error);

            }).finally(() => {
                console.log('Thanks for sharing!');
            })
        }
    </script>
</body>

</html>