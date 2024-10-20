

<!doctype html>
<html lang="en">
<head>
    <title>Title</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- AOS CSS (Animate On Scroll) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <!-- Custom CSS -->
    <link rel="stylesheet" href="../views/css/home2.css">


</head>

    <body class="index-page">
    <header id="header" class="header d-flex align-items-center sticky-top">
          <a href="home.php" class="logo d-flex align-items-center me-auto">
            <img src="../views/img/logo.png" class="logo-img">
        </a>
            <!-- navbar  -->
            <div class="container-fluid container-xl position-relative d-flex align-items-center">
                <nav id="navmenu" class="navmenu navbar navbar-expand-sm">
                  
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
                            <li class="nav-item"><a href="#b1" class="nav-link">About Us</a></li>
                            <li class="nav-item"><a href="#b2" class="nav-link">News</a></li>
                            <li class="nav-item"><a href="#b4" class="nav-link">Events</a></li>
                            <li class="nav-item"><a href="#b3" class="nav-link">Contact Us</a></li>
							<li class="nav-item"><a href="convocation.php" class="nav-link active">Convocation</a></li>
                            <li class="nav-item"><a href="donation.php" class="nav-link">Donation</a></li>
                            <li class="nav-item">
                                <!-- Button trigger modal -->
                                <a href="../controller/Alumni/login.php"><button type="button" class="btn btn-primary" data-bs-toggle="modal" >
                                    LOGIN
                                </button></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>

        <main class="main">
            <!--  first Section -->
              <section id="first" class="first section">
                  <img src="../views/img/sAcademic.jpg" alt="" data-aos="fade-in">
                  <div class="container">
                      <h2 data-aos="fade-up" data-aos-delay="100">Welcome to<br>the UMP Alumni Connect</h2>
                      <p data-aos="fade-up" data-aos-delay="200">Unleash the Power of Connection - Where Memories Meet the Future!</p>
                  </div>
              </section><!-- /First Section -->

              <!-- About Section -->
              <section id="about" class="about section">
                  <div class="container">
                      <div class="row gy-4">
                          <div id="b1" class="col-lg-6 order-1 order-lg-1" data-aos="fade-up" data-aos-delay="100">
                              <img src="../views/img/sGraduation3.png" class="img-fluid border-image" alt="">
                          </div>
                          <div class="col-lg-6 order-2 order-lg-2 content" data-aos="fade-up" data-aos-delay="200">
                              <h3>About Us</h3>
                              <p style="font-size:21px;">
                                  Welcome to GradConnect, the ultimate hub for University of Mpumalanga alumni to reignite old friendships and forge new connections.
                                  Our mission is to create a vibrant social networking platform where alumni can share experiences, mentorship, and opportunities.
                                  Join us in building a strong community that celebrates the past and shapes the future together!
                              </p>
                          </div>
                      </div>
                  </div>
              </section>
            <!-- /About Section -->


 <!-- Section Title -->
 <div class="container section-title" data-aos="fade-up">
       <h2 id="#b2">News</h2>
      
       <p class="">Recent News</p>
     </div><!-- End Section Title -->


    <!-- News Section -->
    <section id="News" class="section News">

     <div class="container">

       <div class="row gy-4">

       <?php include '../controller/Alumni/news.php'; ?>

       </div>

     </div>

   </section><!-- /News Section -->


    <!-- Features Section -->
    <section id="features" class="features section">

     <div class="container">
     <h3>GradConnect offers</h3>
       <div class="row gy-4">

         <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="700">
           <div class="features-item">
             <i class="bi bi-x-diamond" style="color: #11dbcf;"></i>
             <h3>Networking Opportunities:</h3>
           </div>
         </div><!-- End Feature Item -->

         <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="800">
           <div class="features-item">
             <i class="bi bi-camera-video" style="color: #4233ff;"></i>
             <h3>Career Development:</h3>
           </div>
         </div><!-- End Feature Item -->

         <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="900">
           <div class="features-item">
             <i class="bi bi-command" style="color: #b2904f;"></i>
             <h3>Events and Reunions</h3>
           </div>
         </div><!-- End Feature Item -->

         <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="1000">
           <div class="features-item">
             <i class="bi bi-dribbble" style="color: #b20969;"></i>
             <h3>News and Updates</h3>
           </div>
         </div><!-- End Feature Item -->

       </div>

     </div>

   </section><!-- /Features Section -->

   <!-- Events Section -->
   <section id="events" class="events section">

     <!-- Section Title -->
     <div class="container section-title" data-aos="fade-up">
       <h2 id="b4">Events</h2>
       <p class="">Upcoming Events</p>
     </div><!-- End Section Title -->

     <div class="container">

       <div class="row">

       <?php include '../controller/Alumni/events.php'; ?>
       </div>

     </div>

   </section><!-- /events Section -->
 
        <!-- Contact Section -->
        <section id="contact" class="contact section">
            <div class="container">
                <div class="section-title">
                    <h2 id="b3">Contact</h2>
                    <p>Contact Us</p>
                </div>

                <div class="row">
                    <div class="col-lg-6" data-aos="fade-up">
                        <div class="info-box mb-4">
                            <i class="bx bx-map"></i>
                            <h3>Our Address</h3>
                            <p>University of Mpumalanga, Mbombela, South Africa</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="info-box mb-4">
                            <i class="bx bx-envelope"></i>
                            <h3>Email Us</h3>
                            <a href="mailto:gradconnect@ump.ac.za"><p>gradconnect@ump.ac.za</p></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="info-box mb-4">
                            <i class="bx bx-phone-call"></i>
                            <h3>Call Us</h3>
                            <a href="tel:+27 123 456 789"><p>+27 123 456 789</p></a>
                        </div>
                    </div>
                </div>

                <div class="row" data-aos="fade-up" data-aos-delay="300">
                  
                    <div class="col-lg-6">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d57648.576621495056!2d30.940575907517456!3d-25.437058642542734!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1ee835ddde836b49%3A0xfe875f0851caa5cf!2sUniversity%20of%20Mpumalanga!5e0!3m2!1sen!2sza!4v1723289943907!5m2!1sen!2sza"
                           width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    

                    <div class="col-lg-6">
                        <div>
                          <h2>Leave Us A Message</h2>
                        </div>
                        <form action="contact.php" method="post" role="form" class="php-email-form">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </section>
        <!-- /Contact Section -->
              
       </main>

   <!--footer-->
<footer id="footer" class="footer position-relative">
<?php include 'includes/footer.php'; ?>

</footer>
<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
    <!-- Bootstrap JS v5.3.2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRkC4Pz2FWGx/Rh7Kj9B/7mC8kNf7hK9rRNdVxgk7" crossorigin="anonymous"></script>

    <!-- AOS JS (Animate On Scroll) -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
     <script>
  function togglePasswordVisibility() {
    const passwordField = document.getElementById("password");
    const togglePasswordIcon = document.getElementById("togglePassword");
    
    if (passwordField.type === "password") {
      passwordField.type = "text";
      togglePasswordIcon.classList.remove("fa-eye");
      togglePasswordIcon.classList.add("fa-eye-slash");
    } else {
      passwordField.type = "password";
      togglePasswordIcon.classList.remove("fa-eye-slash");
      togglePasswordIcon.classList.add("fa-eye");
    }
  }
</script>

    </body>

</html>
