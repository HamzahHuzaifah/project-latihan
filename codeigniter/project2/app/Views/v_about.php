<?= $this->extend('layouts/template-home'); ?>
<?= $this->section('content'); ?>
<main class="main">
    <!-- About Section -->
    <section id="about" class="about section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>About</h2>
            <p>I am a graduate of SMAN 36 Jakarta who is currently working part-time at the Jakarta Islamic Center Educational Institution as an administration in the TPQ division and studying at Nahdlatul Ulama University Jakarta.</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4 justify-content-center">
                <div class="col-lg-4">
                    <img src="assets/img/my-profile-img.jpg" class="img-fluid" alt="">
                </div>
                <div class="col-lg-8 content">
                    <h2>Administration &amp; Web Developer.</h2>
                    <p class="fst-italic py-3">
                        As an ordinary student majoring in information systems, I am just learning the basics in the world of coding and lectures.
                    </p>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul>
                                <li><i class="bi bi-chevron-right"></i> <strong>Birthday:</strong> <span>1 January 2004</span></li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Website:</strong>
                                    <span>www.example.com</span></li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Phone:</strong> <span>+62 812 8446 0237</span></li>
                                <li><i class="bi bi-chevron-right"></i> <strong>City:</strong> <span>Jakarta,
                                        Indonesia</span></li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul>
                                <li><i class="bi bi-chevron-right"></i> <strong>Age:</strong> <span>22</span></li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Degree:</strong> <span>Bachelor</span>
                                </li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Email:</strong>
                                    <span>hamzahhuzaifahh@gmail.com</span></li>
                                <li><i class="bi bi-chevron-right"></i> <strong>Freelance:</strong>
                                    <span>Available</span></li>
                            </ul>
                        </div>
                    </div>
                    <p class="py-3">
                        Some of my assignments related to my major or not are as follows:
                        <br>
                        - Creating a CRUD Webstie (Create, Read, Undo, and Delete) with the PHP coding language for the DATA BASIS SYSTEMS semester final exam.
                        <br>
                        - Creating a static Web using the JavaScript (JS) programming language combined with HTML + CSS in the final exam of the BASIC BASICS OF SCRAPING semester.
                    </p>
                </div>
            </div>

        </div>

    </section><!-- /About Section -->
</main>
<?= $this->endSection(); ?>