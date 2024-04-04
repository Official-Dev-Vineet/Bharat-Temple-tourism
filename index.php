<?php
require_once "Admin/config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bharat Temple Tourism</title>

  <!-- 
    - favicon
  -->
  <link rel="icon" href="/assets/images/favIcon.jpg" />

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
</head>

<body id="top">
  <!-- 
    - #HEADER
  -->

  <header class="header" data-header>
    <div class="overlay" data-overlay></div>

    <div class="header-top">
      <div class="container">
        <a href="tel:+917983920962" class="helpline-box">
          <div class="icon-box">
            <ion-icon name="call-outline"></ion-icon>
          </div>

          <div class="wrapper">
            <p class="helpline-title">For Further Inquires :</p>
            <p class="helpline-number">+91-7983920962</p>
          </div>
        </a>

        <a href="#" class="logo">
          <img src="./assets/images/logo.svg" alt="Tourly logo" />
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
            <a href="#" class="social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-youtube"></ion-icon>
            </a>
          </li>
        </ul>

        <nav class="navbar" data-navbar>
          <div class="navbar-top">
            <a href="#" class="logo">
              <img src="./assets/images/logo-blue.svg" alt="Tourly logo" />
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
              <a href="#" class="navbar-link" data-nav-link>about us</a>
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

        <button class="btn btn-primary">Book Now</button>
      </div>
    </div>
  </header>

  <main>
    <article>
      <!-- 
        - #HERO
      -->

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
            <button class="btn btn-primary">Learn more</button>

            <button class="btn btn-secondary">Book now</button>
          </div>
        </div>
      </section>

      <!-- 
        - #TOUR SEARCH
      -->

      <section class="tour-search">
        <div class="container">
          <form action="" class="tour-search-form">
            <div class="input-wrapper">
              <label for="destination" class="input-label">Search Destination*</label>

              <input type="text" name="destination" id="destination" required placeholder="Enter Destination" class="input-field" />
            </div>

            <div class="input-wrapper">
              <label for="people" class="input-label">Pax Number*</label>

              <input type="number" name="people" id="people" required placeholder="No.of People" class="input-field" />
            </div>

            <div class="input-wrapper">
              <label for="checkin" class="input-label">Checkin Date**</label>

              <input type="date" name="checkin" id="checkin" required class="input-field" />
            </div>

            <div class="input-wrapper">
              <label for="checkout" class="input-label">Checkout Date*</label>

              <input type="date" name="checkout" id="checkout" required class="input-field" />
            </div>

            <button type="submit" class="btn btn-secondary">
              Inquire now
            </button>
          </form>
        </div>
      </section>

      <!-- 
        - #POPULAR
      -->

      <section class="popular" id="destination">
        <div class="container">
          <p class="section-subtitle">Uncover place</p>

          <h2 class="h2 section-title">Popular destination</h2>

          <p class="section-text">
            Explore the beauty of India's most popular destinations.<br />
            Discover the culture, heritage, and cuisine of your choice. <br />
            Embark on a journey of adventure and discovery.
          </p>

          <ul class="popular-list">
            <?php
            // fetch popular destinations from database
            $sql = "SELECT * FROM `populardestination`";
            // pdo 
            $result = $conn->prepare($sql);
            $result->execute();


            while ($data = $result->fetch(PDO::FETCH_ASSOC)) {
              echo '<li>
    <div class="popular-card">
      <figure class="card-img">
        <img
          src="Admin/' . $data['image'] . '"
          alt="' . $data['title'] . '"
          loading="lazy"
        />
      </figure>

      <div class="card-content">
        <div class="card-rating">
          <ion-icon name="star"></ion-icon>
          <ion-icon name="star"></ion-icon>
          <ion-icon name="star"></ion-icon>
          <ion-icon name="star"></ion-icon>
          <ion-icon name="star"></ion-icon>
        </div>

        <p class="card-subtitle">
          <a href="#">' . $data['location'] . '</a>
        </p>

        <h3 class="h3 card-title">
          <a href="#">' . $data['title'] . '</a>
        </h3>

        <p class="card-text">
          ' . $data['description'] . '
        </p>
      </div>
    </div>
  </li>';
            }


            ?>
          </ul>
        </div>
      </section>

      <!-- 
        - #PACKAGE
      -->

      <section class="package" id="package">
        <div class="container">
          <p class="section-subtitle">Popular Packeges</p>

          <h2 class="h2 section-title">Checkout Our Packages</h2>

          <p class="section-text">
            Embark on a journey of discovery with our meticulously crafted
            tour packages, designed to cater to every type of traveler.
            Whether you're seeking adventure, relaxation, cultural immersion,
            or all of the above, our tours promise experiences that are
            nothing short of extraordinary.
          </p>

          <ul class="package-list">
            <?php
            // fetch data from tourpackages 
            $sql = "SELECT * FROM `tourpackages` order by id desc";
            $result = $conn->prepare($sql);
            $result->execute();
            while ($data = $result->fetch(PDO::FETCH_ASSOC)) {
            ?>
              <li>
                <div class="package-card">
                  <figure class="card-banner">
                    <img src="Admin/uploads/<?= $data['image'] ?>" alt="<?= $data['title'] ?>" loading="lazy" />
                  </figure>

                  <div class="card-content">
                    <h3 class="h3 card-title">
                      <?= $data['title'] ?>
                    </h3>

                    <p class="card-text">
                      <?= $data['description'] ?>:
                    </p>

                    <ul class="card-meta-list">
                      <li class="card-meta-item">
                        <div class="meta-box">
                          <ion-icon name="time"></ion-icon>
                          <p class="text"><?= $data['day'] ?>D/<?= $data['night'] ?>N</p>
                        </div>
                      </li>

                      <li class="card-meta-item">
                        <div class="meta-box">
                          <ion-icon name="people"></ion-icon>
                          <p class="text">pax: <?= $data['pax'] ?></p>
                        </div>
                      </li>
                      <li class="card-meta-item">
                        <div class="meta-box">
                          <ion-icon name="location"></ion-icon>
                          <p class="text"><?= $data['location'] ?></p>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="card-price">
                    <div class="wrapper">
                      <p class="reviews">(<?= $data['reviewCount'] ?> reviews)</p>
                      <div class="card-rating">
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                      </div>
                    </div>
                    <p class="price">
                      $<?= $data['price'] ?>
                      <span>/ per person</span>
                    </p>
                    <button class="btn btn-secondary">Book Now</button>
                  </div>
                </div>
              </li>
            <?php
            }
            ?>
          </ul>
        </div>
      </section>

      <!-- 
        - #GALLERY
      -->

      <section class="gallery" id="gallery">
        <div class="container">
          <p class="section-subtitle">Photo Gallery</p>

          <h2 class="h2 section-title">Photo's From Travellers</h2>

          <p class="section-text">
            Traveler’s photos are more than just images; they are vibrant
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
            $sql = "SELECT * FROM gallery_images";
            // using pdo
            $result = $conn->prepare($sql);
            $result->execute();
            while ($row = $result->fetch()) {
              echo '<li class="gallery-item">
              <figure class="gallery-image">
              <img
                src="Admin/uploads/' . $row["file_name"] . '"
                alt="Gallery image"
              />
            </figure></li>';
            }
            ?>
          </ul>
        </div>
      </section>

      <!-- 
        - #CTA
      -->

      <section class="cta" id="contact">
        <div class="container">
          <div class="cta-content">
            <p class="section-subtitle">Call To Action</p>

            <h2 class="h2 section-title">
              Ready For Unforgatable Travel. Remember Us!
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
    </article>
  </main>

  <!-- 
    - #FOOTER
  -->

  <footer class="footer">
    <div class="footer-top">
      <div class="container">
        <div class="footer-brand">
          <a href="#" class="logo">
            <img src="./assets/images/logo.svg" alt="Tourly logo" />
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
          <h4 class="contact-title">Contact Us</h4>

          <p class="contact-text">Feel free to contact and reach us !!</p>

          <ul>
            <li class="contact-item">
              <ion-icon name="call-outline"></ion-icon>

              <a href="tel:+01123456790" class="contact-link">+01 (123) 4567 90</a>
            </li>

            <li class="contact-item">
              <ion-icon name="mail-outline"></ion-icon>

              <a href="mailto:info.tourly.com" class="contact-link">info.tourly.com</a>
            </li>

            <li class="contact-item">
              <ion-icon name="location-outline"></ion-icon>

              <address>3146 Koontz, California</address>
            </li>
          </ul>
        </div>

        <div class="footer-form">
          <p class="form-text">
            Subscribe our newsletter for more update & news !!
          </p>

          <form action="" class="form-wrapper">
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
            <a href="#" class="footer-bottom-link">Privacy Policy</a>
          </li>

          <li>
            <a href="#" class="footer-bottom-link">Term & Condition</a>
          </li>

          <li>
            <a href="#" class="footer-bottom-link">Refund Policy</a>
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

  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>