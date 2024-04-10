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

        <title>Gallery and Reviews by Bharat Travelers</title>

        <!-- 
    - favicon
  -->
        <link rel="icon" href="Admin/uploads/<?= $logo ?>" />

        <!-- 
    - custom css link
  -->
        <link rel="stylesheet" href="./assets/css/style.css" />

        <!-- 
    - google font link
  -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
        <style>
            .refund-policy {
                max-width: 800px;
                margin: 0 auto;
            }
        </style>
    </head>

    <body>
        <header class="header" data-header>
            <div class="overlay" data-overlay></div>

            <div class="header-top">
                <div class="container">
                    <a href="tel:<?= $phone; ?>" class="helpline-box">
                        <div class="icon-box">
                            <ion-icon name="call-outline"></ion-icon>
                        </div>
                        <div class="wrapper">
                            <p class="helpline-title">For Further Inquires :</p>
                            <p class="helpline-number"><?= $phone; ?></p>
                        </div>
                    </a>

                    <a href="/" class="logo">
                        <img src="Admin/uploads/<?= $logo ?>" alt="Bharat Temple Tourism" />
                    </a>

                    <div class="header-btn-group">
                        <button class="search-btn" aria-label="Search">
                            <ion-icon name="search"></ion-icon>
                        </button>

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
                                <a href="./index.php#home" class="navbar-link" data-nav-link>home</a>
                            </li>

                            <li>
                                <a href="user/login.php" class="navbar-link" data-nav-link>Account</a>
                            </li>

                            <li>
                                <a href="./index.php#destination" class="navbar-link" data-nav-link>destination</a>
                            </li>

                            <li>
                                <a href="./index.php#package" class="navbar-link" data-nav-link>packages</a>
                            </li>

                            <li>
                                <a href="./index.php#gallery" class="navbar-link" data-nav-link>gallery</a>
                            </li>

                            <li>
                                <a href="#contact" class="navbar-link" data-nav-link>contact us</a>
                            </li>
                        </ul>

                    </nav>

                    <a href="#package" class="btn btn-primary"> Book Now</a>
                </div>
            </div>
        </header>

        <main>
            <section class="hero" id="home">
                <div class="container">
                    <h2 class="h1 hero-title">Journey to explore Indian History</h2>

                    <p class="hero-text">
                        Welcome to Bharat Temple Tour, your spiritual gateway to exploring
                        the timeless beauty and divine serenity of India's most revered
                        sacred sites. Embark on a journey of faith, history, and wonder
                        with us, as we traverse the length and breadth of this ancient
                        land, visiting its magnificent temples that stand as beacons of
                        spiritual energy and architectural marvel.
                    </p>

                    <div class="btn-group">
                        <button class="btn btn-secondary" onclick="window.location.href='./index.php#package'">Book now</button>
                    </div>
                </div>
            </section>
            <section class="gallery" id="gallery">
        <div class="container">
          <p class="section-subtitle">Photo Gallery</p>

          <h2 class="h2 section-title">Photo's From Travelers</h2>

          <p class="section-text">
            Traveler's photos are more than just images; they are vibrant
            snapshots that capture the essence of a moment, the soul of a
            place, and the spirit of its people. Each picture tells a story,
            offering a glimpse into the captivating beauty and diversity our
            world holds. From the breathtaking peaks of the Himalayas to the
            serene beaches of the Caribbean, these photographs bring distant
            lands and cultures right to our fingertips.
          </p>

          <ul class="gallery-list">
            <?php
            // fetch images from database
            $sql = "SELECT * FROM gallery_images order by id desc limit 0,5";
            // using pdo
            $result = $conn->prepare($sql);
            $result->execute();
            while ($row = $result->fetch()) {
              echo '<li class="gallery-item">
              <figure class="gallery-image">
              <img
                src="Admin/uploads/' . $row["file_name"] . '"
                alt="Gallery image"
                loading="lazy"
              />
              <figcaption class="gallery-item-title">' . $row["review"] . '</figcaption>
              <div class="card-rating">
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
              <ion-icon name="star"></ion-icon>
            </div>
            </figure>
           
            </li>';
            }
            ?>
          </ul>

        </div>
      </section>
            <section class="cta" id="contact">
                <div class="container">
                    <div class="cta-content">
                        <p class="section-subtitle">Call To Action</p>

                        <h2 class="h2 section-title">
                            Ready For Unforgettable Travel. Remember Us!
                        </h2>

                        <p class="section-text">
                            Embark on a voyage where each destination promises memories that
                            will last a lifetime. With a world waiting to be explored, our
                            tailor-made travel experiences are designed to immerse you in
                            the essence of each location, offering not just a trip, but a
                            journey filled with unforgettable moments. Your adventure of a
                            lifetime is just a click away. Remember us, because we're here
                            to make it extraordinary.
                        </p>
                    </div>

                    <a href="mailto:viratsinghkaharwar8923@gmail.com" class="btn btn-primary" style="outline: 1px solid">Contact Us !</a>
                </div>
            </section>
        </main>
        <footer class="footer">
            <div class="footer-top">
                <div class="container">
                    <div class="footer-brand">
                        <a href="#" class="logo">
                            <img src="Admin/uploads/<?= $logo ?>" alt="Bharat Temple tourism" />
                        </a>

                        <p class="footer-text">
                            Your faith journey is deeply personal, and our bespoke tours cater
                            to your individual spiritual needs. Whether it's a quest for
                            peace, a pilgrimage of devotion, or a deep dive into the
                            architectural and historical significance of India's holy sites,
                            we tailor your journey to ensure it's as unique as your spiritual
                            path.
                        </p>
                    </div>

                    <div class="footer-contact">
                        <p class="contact-title">Contact Us</p>

                        <p class="contact-text">Feel free to contact and reach us !!</p>

                        <ul>
                            <li class="contact-item">
                                <ion-icon name="call-outline"></ion-icon>

                                <a href="tel:<?= $phone ?>" class="contact-link"><?= $phone ?></a>
                            </li>

                            <li class="contact-item">
                                <ion-icon name="mail-outline"></ion-icon>

                                <a href="mailto:<?= $email ?>" class="contact-link"><?= $email ?></a>
                            </li>

                            <li class="contact-item">
                                <ion-icon name="location-outline"></ion-icon>

                                <address><?= $address ?></address>
                            </li>
                        </ul>
                    </div>

                    <div class="footer-form">
                        <p class="form-text">
                            Subscribe our newsletter for more update & news !!
                        </p>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-wrapper">
                            <input type="email" name="email" class="input-field" placeholder="Enter Your Email" required />

                            <button type="submit" class="btn btn-secondary">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="container">
                    <p class="copyright">
                        &copy; 2024 <a href="https://dev-vineet.online">Official Dev Vineet</a>. All rights reserved
                    </p>

                    <ul class="footer-bottom-list">
                        <li>
                            <a href="./privacy-policy.php" class="footer-bottom-link">Privacy Policy</a>
                        </li>

                        <li>
                            <a href="./term.php" class="footer-bottom-link">Term & Condition</a>
                        </li>

                        <li>
                            <a href="./refund-policy.php" class="footer-bottom-link">Refund Policy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>

        <!-- 
    - #GO TO TOP
  -->

        <a href="#top" class="go-top" data-go-top>
            <ion-icon name="chevron-up-outline"></ion-icon>
        </a>

        <script src="./assets/js/script.js"></script>

        <!-- 
  - ionicon link
-->
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
                        }, 1000);
                    }
                })
            })
            // send newsletter subscription form to newsletter.php using ajax
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
                        },
                        error: function(err) {
                            alert('Something went wrong!', err);
                        }
                    })
                })
            })
        </script>
    </body>

    </html>