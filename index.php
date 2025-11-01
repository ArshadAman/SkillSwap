<?php
include_once './utils/header.php';
?>
<!-- Main Content Start -->
<main class="content-padding py-5">
    <section class="headline d-flex flex-wrap justify-content-center gap-5">
        <div class="left">
            <img src="/assets/elements/landing_1.png" alt="">
        </div>
        <div class="right d-flex flex-column justify-content-center">
            <h1 class="fs-custom-1 fw-bold">Learn. Teach.</h1>
            <h1 class="fs-custom-1 fw-bold">Grow. Together.</h1>
            <p class="fs-5 color-text">Connect with learners and teachers around the world<br>to swap skills and
                knowledge.</p>
            <a class="btn btn-primary rounded-pill px-5 py-2 mt-3" href="auth.php">Get Started</a>
        </div>
    </section>
    <section class="why py-5 content-padding">
        <h1 class="fs-1 fw-bold">Why Choose SkillSwap</h1>
        <p class="color-text fs-5">SkillSwap offers a unique platform for skill exchange, connecting learners and
            teachers globally.</p>
        <div class="cards d-flex flex-wrap gap-4 justify-content-center mt-4">
            <div class="card border-purple">
                <div class="card-body">
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <h5 class="card-title fw-bold">Global Community</h5>
                    <p class="card-text color-text">Join a vibrant community of learners and<br>teachers from around the
                        world.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="icon"><i class="fas fa-globe"></i></div>
                    <h5 class="card-title fw-bold">Diverse Skills</h5>
                    <p class="card-text color-text">Explore a wide range of skills, from<br>coding to cooking, and
                        everything in<br>between.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <h5 class="card-title fw-bold">Flexible Learning</h5>
                    <p class="card-text color-text">Learn at your own pace, with flexible<br>scheduling and personalized
                        learning<br>paths.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="how py-5 content-padding">
        <h1 class="fs-3 fw-medium mb-3 pb-3">How it works</h1>
        <ul type="none" class="d-flex gap-3">
            <li class="px-4 py-5 border border-purple rounded-4">
                <h5 class="">Create Your Profile</h5>
                <p class="color-text">Showcase your profile and interests.</p>
            </li>
            <li class="px-4 py-5 border border-purple rounded-4">
                <h5 class="">Find Your Match</h5>
                <p class="color-text">Connect with learners around the globe.</p>
            </li>
            <li class="px-4 py-5 border border-purple rounded-4">
                <h5 class="">Start Swapping</h5>
                <p class="color-text">Excahnge Knowledge and Grow Together</p>
            </li>
        </ul>
    </section>
    <section class="testimonial py-5 content-padding">
        <h1 class="fs-3 fw-medium mb-3 pb-3">Testimonials</h1>
        <div class="cards d-flex flex-wrap gap-4 justify-content-center mt-4">
            <div class="card border-purple">
                <div class="card-body">
                    <img src="https://media.licdn.com/dms/image/v2/D5603AQHlKFzdvjc17g/profile-displayphoto-shrink_800_800/B56ZYO.nj8HoAk-/0/1744008020068?e=1763596800&v=beta&t=5OnvJGIfT37-_qEP4Gf5SCJtEZUIAdZhZGpjQ-7g1tI"
                        alt="" class="round-image-fix">
                    <p class="card-text color-text">Join a vibrant community of learners and<br>teachers from around the
                        world. Lorem ipsum <br>dolor sit amet consectetur adipisicing elit. <br> Vel error et modi
                        quaerat</p>
                    <small class="text-black">Arshad, Developer</small>
                </div>
            </div>
            <div class="card border-purple">
                <div class="card-body">
                    <img src="https://media.licdn.com/dms/image/v2/D5603AQFh1mc1bwA6hQ/profile-displayphoto-shrink_200_200/profile-displayphoto-shrink_200_200/0/1712118037136?e=1763596800&v=beta&t=LbIm8qvteiAt8iI2iW4A26HyzQ-TpFPRY6NkpaHnCMA"
                        alt="" class="round-image-fix">
                    <p class="card-text color-text">Join a vibrant community of learners and<br>teachers from around the
                        world. Lorem ipsum <br>dolor sit amet consectetur adipisicing elit. <br> Vel error et modi
                        quaerat</p>
                    <small class="text-black">Sucharita, Designer</small>
                </div>
            </div>
        </div>
    </section>

    <section class="CTA py-5 content-padding d-flex flex-column align-items-center gap-3">
        <h1 class="fs-custom-1 fw-medium mb-3 text-center">Ready To Swap?</h1>
        <a href="auth.php" class="btn btn-primary rounded-pill px-4">Get Started</a>
    </section>
</main>
<?php
include_once './utils/footer.php';
?>