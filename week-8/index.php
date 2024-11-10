<?php
include 'service/config.php';
session_start();

// Fetch the logged-in user's name if they are logged in
$userName = '';
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT full_name FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    $userName = $user['full_name'];
}

// Handle course enrollment if user is logged in and clicked enroll
if (isset($_GET['course_id']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $course_id = $_GET['course_id'];
    
    // Enroll the user in the course
    $stmt = $pdo->prepare("INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $course_id]);
    echo "<script>alert('Enrolled successfully!');</script>";
}

// Fetch categories, courses, and testimonials
$categories_query = $pdo->query("SELECT * FROM categories");
$categories = $categories_query->fetchAll(PDO::FETCH_ASSOC);

$testimonials_query = $pdo->query("SELECT * FROM testimonials");
$testimonials = $testimonials_query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeIn</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:wght@100;300;400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="images/icon-browser.ico" type="image/x-icon">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <a href="index.php"><img src="images/icon-code.svg" alt="CodeIn"></a>
            </div>
            <div class="main-menu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#blog">Blog</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="#" class="welcome">Welcome, <?php echo htmlspecialchars($userName); ?></a></li>
                        <li><a href="logout.php" class="btn">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php" class="btn"><i class="fas fa-user"></i> Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-heading text-xxl">
                    Your coding journey begins now!
                </h1>
                <p class="hero-text">
                    Discover your potential with us with expert-led courses, real-world projects, and a community of
                    learners.
                </p>
                <div class="hero-buttons">
                    <a href="#" class="btn btn-primary">Get Started</a>
                    <a href="#" class="btn"><i class="fas fa-info-circle"></i> Learn More</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="images/hero-bg.jpg" alt="Hero Image">
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="partners">
        <h2 class="text-lg text-center">Trusted by Leading Companies</h2>
        <div class="logo-container">
            <div class="logo-box">
                <img src="images/google.svg" class="partner-logo">
            </div>
            <div class="logo-box">
                <img src="images/amazon.svg" class="partner-logo">
            </div>
            <div class="logo-box">
                <img src="images/ethereum.svg" class="partner-logo">
            </div>
            <div class="logo-box">
                <img src="images/line.svg" class="partner-logo">
            </div>
            <div class="logo-box">
                <img src="images/netflix.svg" class="partner-logo">
            </div>
            <div class="logo-box">
                <img src="images/spotify.svg" class="partner-logo">
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about bg-light">
        <div class="container-sm">
            <h2 class="about-heading text-lg text-center">
                Get to Know More About Us!
            </h2>
            <div class="about-content">
                <div class="slideshow-container">
                    <!-- Slide 1 -->
                    <div class="mySlides fade">
                        <a href="https://www.youtube.com/watch?v=NtfbWkxJTHw" target="_blank">
                            <img src="images/about-video.jpg" alt="about video 1" class="video-preview">
                        </a>
                    </div>

                    <!-- Slide 2 -->
                    <div class="mySlides fade">
                        <a href="https://www.youtube.com/watch?v=yJ8TBVRsa2I" target="_blank">
                            <img src="images/about-video-2.jpg" alt="about video video 2" class="video-preview">
                        </a>
                    </div>

                    <!-- Slide 3 -->
                    <div class="mySlides fade">
                        <a href="https://www.youtube.com/watch?v=HggHXFnPOY4" target="_blank">
                            <img src="images/about-video-3.jpg" alt="about video 3" class="video-preview">
                        </a>
                    </div>

                    <!-- Navigation Arrows -->
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                </div>
            </div>
        </div>
    </section>


    <!-- Features Section -->
    <section class="features">
        <div class="container-sm">
            <h3 class="text-lg text-center">
                Why We Are Different
            </h3>
            <div class="features-content">
                <div class="features-group">
                    <div class="features-group-header">
                        <h4 class="text-md">
                            Interactive Coding Courses
                        </h4>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="features-group-body">
                        <p>
                            Whether you're just starting or looking to enhance your skills,
                            you can dive into hands-on projects, exercises,
                            and real-world applications to sharpen your coding expertise.
                        </p>
                    </div>
                </div>

                <div class="features-group">
                    <div class="features-group-header">
                        <h4 class="text-md">
                            Expert-Led Tutorials
                        </h4>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="features-group-body">
                        <p>
                            Our expert-led tutorials cover in-demand technologies and provide practical knowledge to
                            help you stay ahead of the curve.
                        </p>
                    </div>
                </div>

                <div class="features-group">
                    <div class="features-group-header">
                        <h4 class="text-md">
                            Personalized Learning Paths
                        </h4>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="features-group-body">
                        <p>
                            Tailor your learning experience with personalized learning paths
                            that guide you step by step through
                            the programming languages and tools that are most relevant to your career goals.
                        </p>
                    </div>
                </div>

                <div class="features-group">
                    <div class="features-group-header">
                        <h4 class="text-md">
                            Interactive Coding Courses
                        </h4>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="features-group-body">
                        <p>
                            Whether you're just starting or looking to enhance your skills,
                            you can dive into hands-on projects, exercises,
                            and real-world applications to sharpen your coding expertise.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="programs">
        <div class="container-sm">
            <h3 class="text-lg text-center">Available Programs</h3>
            <p class="text-center">Explore the variety of training programs offered and choose your path to success.</p>

            <!-- Filters for Learning Paths -->
            <div class="filter-options">
                <?php foreach ($categories as $category): ?>
                    <button class="filter-btn" onclick="filterCourses('<?php echo strtolower($category['name']); ?>')">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Courses Container -->
            <div id="courses" class="courses-container">
                <?php foreach ($categories as $category): ?>
                    <?php
                    $category_id = $category['id'];
                    $courses_query = $pdo->prepare("SELECT * FROM courses WHERE category_id = ?");
                    $courses_query->execute([$category_id]);
                    $courses = $courses_query->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($courses as $course): ?>
                        <div class="course-card" data-category="<?php echo strtolower($category['name']); ?>">
                            <h4><?php echo htmlspecialchars($course['title']); ?></h4>
                            <p>Level: <?php echo htmlspecialchars($course['level']); ?></p>
                            <p>Trainer: <?php echo htmlspecialchars($course['trainer']); ?></p>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="index.php?course_id=<?php echo $course['id']; ?>" class="btn">Enroll</a>
                            <?php else: ?>
                                <p><a href="login.php" class="btn">Login to Enroll</a></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


    <!-- Testimonials Section -->
    <section class="testimonials bg-dark" id="blog">
        <div class="container">
            <h3 class="testimonials-heading text-lg text-center">See their successful stories.</h3>
            <div class="testimonials-grid">
                <?php foreach ($testimonials as $testimonial): ?>
                    <div class="card">
                        <p><?php echo htmlspecialchars($testimonial['content']); ?></p>
                        <p><?php echo htmlspecialchars($testimonial['name']); ?></p>
                        <p><?php echo htmlspecialchars($testimonial['position']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing">
        <div class="container-sm">
            <h3 class="pricing-heading text-xl text-center">Pricing</h3>
            <p class="pricing-subheading text-md text-center">
                Start your coding journey with our flexible pricing plans.
            </p>
            <div class="pricing-grid">

                <!-- Pricing Card 1 - Free Plan -->
                <div class="card bg-light">
                    <div class="pricing-card-header">
                        <h4 class="pricing-heading text-lg">Simple</h4>
                        <p class="pricing-card-subheading">
                            Access basic learning resources, join the community, and track your progress.
                        </p>
                        <p class="pricing-card-price">
                            <span class="text-lg">Free</span>
                            *No credit card needed
                        </p>
                    </div>
                    <div class="pricing-card-body">
                        <ul>
                            <li><i class="fas fa-check"></i> Basic Course Access</li>
                            <li><i class="fas fa-check"></i> Community Support Forums</li>
                            <li><i class="fas fa-check"></i> Basic In-Browser Code Editor</li>
                            <li><i class="fas fa-check"></i> Real-Time Monitoring</li>
                            <li><i class="fas fa-check"></i> Interactive Quizzes</li>
                            <li><i class="fas fa-check"></i> Access Free Resources</li>
                            <li><i class="fas fa-check"></i> Basic Learning Paths</li>
                        </ul>
                        <a href="#" class="btn btn-primary btn-block">Get Started</a>
                    </div>
                </div>

                <!-- Pricing Card 2 - Premium Plan -->
                <div class="card bg-black">
                    <div class="pricing-card-header">
                        <h4 class="pricing-card-heading text-lg">Premium</h4>
                        <p class="pricing-card-subheading">
                            Full access to advanced courses, personal mentorship, and exclusive tools.
                        </p>
                        <p class="pricing-card-price">
                            <span class="text-lg">$15</span> /month
                        </p>
                    </div>
                    <div class="pricing-card-body">
                        <p>Everything from the free plan plus:</p>
                        <ul>
                            <li><i class="fas fa-check"></i> Unlimited Course Access</li>
                            <li><i class="fas fa-check"></i> 1-on-1 Mentorship with Experts</li>
                            <li><i class="fas fa-check"></i> Exclusive Real-World Projects</li>
                            <li><i class="fas fa-check"></i> Live Coding Sessions</li>
                            <li><i class="fas fa-check"></i> Advanced In-Browser Code Editor</li>
                            <li><i class="fas fa-check"></i> Priority Support</li>
                            <li><i class="fas fa-check"></i> Certificate of Completion</li>
                            <li><i class="fas fa-check"></i> 24/7 Priority Support</li>
                            <li><i class="fas fa-check"></i> Team Collaboration Tools</li>
                        </ul>
                        <a href="#" class="btn btn-primary btn-block">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer bg-black">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a href="index.html">
                        <img src="images/icon-code.svg" alt="logo" class="white-logo">
                    </a>
                    <div class="card">
                        <h4>Subscribe to Newsletter</h4>
                        <p class="text-sm">
                            Subscribe now to receive latest updates and news
                            about our courses and projects.
                        </p>
                        <form>
                            <input type="email" id="email" placeholder="Enter your email" />
                            <button type="submit" class="btn btn-primary btn-block">
                                Subscribe
                            </button>
                        </form>
                    </div>
                    <i class="fab fa-linkedin"></i>
                    <i class="fab fa-twitter"></i>
                </div>
                <div>
                    <h4>Company</h4>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Our Process</a></li>
                        <li><a href="#">Join Our Team</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Resources</h4>
                    <ul>
                        <li><a href="#">News</a></li>
                        <li><a href="#">Research</a></li>
                        <li><a href="#">Recent Courses</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Contact</h4>
                    <ul>
                        <li>
                            <a href="#">contact@codein.com</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>

</html>