<?php
session_start();

include('mysql/db_connect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>about us</title>
    <!-- fav icon -->
    <link rel="icon" href="./assets/img/fav/favicon.png" type="image/png" sizes="16x16">
    <!-- bootstrap css1 js1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="./assets/libs/bootstrap-5.3.2-dist/css/bootstrap.min.css"/> -->
    <!-- fontawsome css1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- lightbox2 css1 js1 -->
    <link rel="stylesheet" href="./assets/libs/lightbox2-2.11.4/dist/css/lightbox.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!-- custom css -->
    <link rel="stylesheet" href="./css/style.css" type="text/css">

    <style>
        #aboutus {
            padding-top: 150px !important; 
            margin-top: 0;
        }

        #mission-vision .lines {
            height: 3px;
            background-color: #333;
            width: 80px;
            margin: 0 auto;
        }

        .mission-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        outline: none; /* Remove outline when focused */
    }

    /* Scale effect on hover or focus */
    .mission-card:hover,
    .mission-card:focus-within {
        transform: scale(1.1);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    /* Reset the scale of other cards */
    .mission-card:hover ~ .mission-card,
    .mission-card:focus-within ~ .mission-card {
        transform: scale(0.95);
        box-shadow: none;
    }


    </style>

</head>
<body class="bg-secondary">

        <!-- start back to top -->
        <div class="fixed-bottom">
            <a href="aboutus.php" class="btn-backtotops"><i class="fas fa-arrow-up"></i></a>
        </div>
    <!-- end back to top -->

    <!-- start stick note -->

        <div class="sticknotes">
            <a href="javascript:void(0;)" class="one">Leadership</a>
            <a href="javascript:void(0;)" class="two">Skill</a>
            <a href="javascript:void(0;)" class="three">Teamwork</a>
            <a href="javascript:void(0;)" class="four">Wellbeing</a>
        </div>

    <!-- start stick note -->

    <!-- start Nav bar -->
        <nav class="navbar navbar-expand-lg fixed-top">

            <a href="index.html" class="navbar-brand text-light mx-3">
                <img src="./assets/img/fav/sporticon.png" width="70" alt="favicon">
                <span class="text-uppercase h2 fw-bold mx-2">Auston <span class="h4">Sport Club</span></span>
            </a>

            <button type="button" class="navbar-toggler navbuttons" data-bs-toggle="collapse" data-bs-target="#nav">
                <div class="bg-light lines1"></div>
                <div class="bg-light lines2"></div>
                <div class="bg-light lines3"></div>
            </button>

            <div id="nav" class="navbar-collapse collapse d-flex justify-content-between align-items-center text-uppercase fw-bold">

                        <ul class="navbar-nav d-flex align-items-center mb-0">
                            <li class="nav-item"><a href="index.php" class="nav-link mx-2 menuitems">Home</a></li>
                            <li class="nav-item"><a href="aboutus.php" class="nav-link mx-2 menuitems">About Us</a></li>
                            <li class="nav-item"><a href="announcement.php" class="nav-link mx-2 menuitems">News & Announcements</a></li>
                            <li class="nav-item"><a href="events.php" class="nav-link mx-2 menuitems">Events</a></li>
                            <li class="nav-item"><a href="contactus.php" class="nav-link mx-2 menuitems">Contact</a></li>
                            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                                <li class="nav-item"><a href="./admininterface/dashboard.php" class="nav-link mx-2 menuitems">Dashboard</a></li>
                            <?php endif; ?>
                        </ul>
                        
                        <ul class="navbar-nav d-flex align-items-center mb-0">
                            <?php if (isset($_SESSION['name'])): ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-person-circle align-icon" style="font-size: 1.5rem;"></i>
                                        <span class="text-white" style="margin-left: 10px;"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a href="userProfile.php" class="dropdown-item">Edit Profile</a></li>
                                        <li><a href="logout.php" class="dropdown-item">Logout</a></li>
                                    </ul>
                                </li>
                            <?php else: ?>
                            <li class="nav-item">
                                    <a href="login.php" class="nav-link">
                                        <i class="bi bi-person-circle align-icon" style="font-size: 1.5rem;"></i> Login
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                            
            </div>

        </nav>
    <!-- end Nav bar -->

    <!-- start about us section -->

        <section id="aboutus" class="py-5 aboutus">
            <div class="container">
                <div class="row about">

                    <div class="col col-sm-6 text-white">
                        
                        <div class="col-md-12">
                            <h2 class="text-uppercase text-black">Who are we ??</h2>
                            <div class="lines"></div>
                            <div class="lines"></div>
                            <div class="lines"></div>
                        </div>

                        <h5 class="fw-bold">We are the Sports Club Team under the Student Council of Auston University, dedicated to promoting health, wellness, and community spirit through engaging sports activities and events. </h5>
                        <p class="fw-bold">Our club provides students with opportunities to participate in various sports, fostering teamwork, discipline, and personal growth. We aim to create a supportive environment where members can develop their skills, enjoy healthy competition, and connect with fellow students who share a passion for sports. Join us as we build a vibrant, active, and unified campus community!</p>
                        <a href="#members" class="btn btn-danger rounded-0">See Members</a>

                    </div>

                </div>
            </div>
        </section>

    <!-- end about us section -->

    <!-- start mission, vision, and core values section -->
<section id="mission-vision" class="py-5 bg-light text-dark">
    <div class="container">
        <div class="row">
            <!-- Mission Section -->
            <div class="col-md-4 text-center mb-4">
                <div tabindex="0" class="p-4 bg-white rounded shadow-sm mission-card">
                    <h2 class="text-uppercase fw-bold">Our Mission</h2>
                    <div class="lines mb-3"></div>
                    <p class="fw-bold">To inspire and empower students to lead active and healthy lives through inclusive sports activities, fostering teamwork, and promoting personal and professional growth within the Auston University community.</p>
                </div>
            </div>
            
            <!-- Vision Section -->
            <div class="col-md-4 text-center mb-4">
                <div tabindex="0" class="p-4 bg-white rounded shadow-sm mission-card">
                    <h2 class="text-uppercase fw-bold">Our Vision</h2>
                    <div class="lines mb-3"></div>
                    <p class="fw-bold">To be a leading example of a student-driven sports club that fosters a culture of excellence, unity, and wellness in every aspect of campus life, inspiring future generations to value the importance of sports and well-being.</p>
                </div>
            </div>

            <!-- Core Values Section -->
            <div tabindex="0" class="col-md-4 text-center mb-4">
                <div class="p-4 bg-white rounded shadow-sm mission-card">
                    <h2 class="text-uppercase fw-bold">Our Core Values</h2>
                    <div class="lines mb-3"></div>
                    <ul class="list-unstyled fw-light text-center fw-bold">
                        <li><i class="bi bi-check-circle text-success"></i> Integrity</li>
                        <li><i class="bi bi-check-circle text-success"></i> Inclusivity</li>
                        <li><i class="bi bi-check-circle text-success"></i> Teamwork</li>
                        <li><i class="bi bi-check-circle text-success"></i> Wellness</li>
                        <li><i class="bi bi-check-circle text-success"></i> Leadership</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end mission, vision, and core values section -->


    <!-- start teammembers section -->

    <section id="members" class="py-3 bg-dark text-white">
        <!-- Title -->
        <div class="text-center mb-4 m-3 pt-1">
            <h1 class="display-4 fw-bold">Our Sports Club Team Members</h1>
        </div>
    
        <div class="container">
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        
                <!-- President Card -->
                <div class="col">
                    <div class="card bg-secondary text-white h-100">
                        <img src="./assets/img/users/agent-1.jpg" class="team-img" alt="President">
                        <div class="card-body">
                            <h5 class="card-title">President</h5>
                            <p class="text-uppercase fst-italic mb-1" style="font-size: 13px;">Action:</p>
                            <p>Setting goals, representing the club to the university, and ensuring the club’s activities align with its mission.</p>
                        </div>
                    </div>
                </div>
        
                <!-- Vice President Card -->
                <div class="col">
                    <div class="card bg-secondary text-white h-100">
                        <img src="./assets/img/users/agent-2.jpg" class="team-img" alt="Vice President">
                        <div class="card-body">
                            <h5 class="card-title">Vice President</h5>
                            <p class="text-uppercase fst-italic mb-1" style="font-size: 13px;">Action:</p>
                            <p>Assists the president and often steps in if the president is unavailable.</p>
                        </div>
                    </div>
                </div>
        
                <!-- Secretary Card -->
                <div class="col">
                    <div class="card bg-secondary text-white h-100">
                        <img src="./assets/img/users/agen-s-3-2.jpg" class="team-img" alt="Secretary">
                        <div class="card-body">
                            <h5 class="card-title">Secretary</h5>
                            <p class="text-uppercase fst-italic mb-1" style="font-size: 13px;">Action:</p>
                            <p>Responsible for administrative tasks, maintaining records, and handling official correspondence.</p>
                        </div>
                    </div>
                </div>
        
                <!-- Treasurer Card -->
                <div class="col">
                    <div class="card bg-secondary text-white h-100">
                        <img src="./assets/img/users/agen-s-3-1.jpg" class="team-img" alt="Treasurer">
                        <div class="card-body">
                            <h5 class="card-title">Treasurer</h5>
                            <p class="text-uppercase fst-italic mb-1" style="font-size: 13px;">Action:</p>
                            <p>Manages the club’s finances, budgeting, and securing sponsorships.</p>
                        </div>
                    </div>
                </div>
        
                <!-- Team Captain Card -->
                <div class="col">
                    <div class="card bg-secondary text-white h-100">
                        <img src="./assets/img/users/agen-s-3-3.jpg" class="team-img" alt="Team Captain">
                        <div class="card-body">
                            <h5 class="card-title">Team Captain</h5>
                            <p class="text-uppercase fst-italic mb-1" style="font-size: 13px;">Action:</p>
                            <p>Leads practices, motivates teammates, and serves as a liaison between team and club leadership.</p>
                        </div>
                    </div>
                </div>
        
                <!-- Events Coordinator Card -->
                <div class="col">
                    <div class="card bg-secondary text-white h-100">
                        <img src="./assets/img/users/agen-s-3-4.jpg" class="team-img" alt="Events Coordinator">
                        <div class="card-body">
                            <h5 class="card-title">Events Coordinator</h5>
                            <p class="text-uppercase fst-italic mb-1" style="font-size: 13px;">Action:</p>
                            <p>Schedules events, competitions, and social gatherings for the club.</p>
                        </div>
                    </div>
                </div>
        
                <!-- PR Officer Card -->
                <div class="col">
                    <div class="card bg-secondary text-white h-100">
                        <img src="./assets/img/users/team_popup.jpg" class="team-img" alt="PR Officer">
                        <div class="card-body">
                            <h5 class="card-title">Public Relations (PR) Officer</h5>
                            <p class="text-uppercase fst-italic mb-1" style="font-size: 13px;">Action:</p>
                            <p>Manages social media, member experience, and conflict resolution.</p>
                        </div>
                    </div>
                </div>
        
                <!-- Volunteer Card -->
                <div class="col">
                    <div class="card bg-secondary text-white h-100">
                        <img src="./assets/img/users/volunteer.jpg" class="team-img volunteer" alt="Volunteer">
                        <div class="card-body">
                            <h5 class="card-title">Volunteer</h5>
                            <p class="text-uppercase fst-italic mb-1" style="font-size: 13px;">Action:</p>
                            <p>Assists in event organization, logistics, and training sessions.</p>
                        </div>
                    </div>
                </div>
        
            </div>
        </div>
    </section>
    
        
    <!-- end teammembers section -->
    
    <!-- start footer section -->

    <footer id="teamfooter" class="bg-dark px-5">
        <div class="container-fluid">

            <div class="row text-white py-4">

                <div class="col-md-4 col-sm-6">
                    <h5 class="mb-3"><img src="https://auston.edu.mm/wp-content/uploads/2020/07/viber_image_2020-07-09_19-02-51-1024x576.jpg" width="100%" alt="footericon"></h5>
                </div>

                <div class="col-md-4 col-sm-6 text-center">
                    <h5 class="mb-3">Need Help?</h5>
                    <ul class="list-unstyled">
                        <li><a href="javascript:void(0);" class="footerlinks">Customer Services</a></li>
                        <li><a href="javascript:void(0);" class="footerlinks">Online Chat</a></li>
                        <li><a href="javascript:void(0);" class="footerlinks">Support</a></li>
                        <li><a href="javascript:void(0);" class="footerlinks">auston.edu.mm</a></li>
                    </ul>
                </div>

                <div class="col-md-4 col-sm-6">
                    <h5 class="mb-3">Contact Us</h5>
                
                    <ul class="list-unstyled">
                        <li><a href="javascript:void(0);" class="nav-link"><i class="fas fa-map-marker-alt me-2"></i> Yangon Campus</a></li>
                        <li><a href="javascript:void(0);" class="nav-link">Shop House No.17 - 18, Junction Square, Kamayut Township, Yangon</a></li>
                    </ul>
                
                    <ul class="list-unstyled">
                        <li><a href="javascript:void(0);" class="nav-link"><i class="fas fa-map-marker-alt me-2"></i> Mandalay Campus</a></li>
                        <li><a href="javascript:void(0);" class="nav-link">No.Nagyi 6/7, 107 Street, Between 65*67 Street, Myo Thit(1) Quarter, Chanmyathazi, Mandalay</a></li>
                    </ul>
                
                    <ul class="list-unstyled">
                        <li><a href="javascript:void(0);" class="nav-link"><i class="fas fa-phone-alt me-2"></i> Hotline : 09 969707000 | 09 765433569</a></li>
                    </ul>
                </div>
                
                
                </div>

            </div>

            <div class="text-light d-flex justify-content-between border-top pt-4">
                <p>&copy; <span id="getyear" class="me-1"></span>Copy right. Inc, All right reserved</p>
                <ul class="list-unstyled d-flex">
                    <li><a href="javascript:void(0);" class="nav-link"><i class="fab fa-linkedin"></i></a></li>
                    <li class="ms-3"><a href="javascript:void(0);" class="nav-link"><i class="fab fa-instagram"></i></a></li>
                    <li class="ms-3"><a href="javascript:void(0);" class="nav-link"><i class="fab fa-facebook"></i></a></li>
                </ul>
            </div>

        </div>
    </footer>

    <!-- end footer section -->

    <!-- bootstrap css1 js1 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="./assets/libs/bootstrap-5.3.2-dist/js/bootstrap.min.js" type="text/javascript"></script> -->
    <!-- jquery js1 -->
    <script src="./assets/libs/jquery/jquery-3.7.1.min.js" type="text/javascript"></script>
    <!-- jquery ui css1 js1 -->
    <script src="./assets/libs/jquery-ui-1.13.2/jquery-ui.min.js" type="text/javascript"></script>
    <!-- lightbox2 css1 js1 -->
    <script src="./assets/libs/lightbox2-2.11.4/dist/js/lightbox.min.js" type="text/javascript"></script>
    <!-- custom js -->
    <script src="./js/app.js" type="text/javascript"></script>
     
   
</body>
</html>
