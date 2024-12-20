<?php
session_start();

include('mysql/db_connect.php');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sport Club Events</title>
    <!-- fav icon -->
    <link rel="icon" href="./assets/img/fav/favicon.png" type="image/png" sizes="16x16">
    <!-- bootstrap css1 js1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- fontawsome css1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jquery ui css1 js1 -->
    <link rel="stylesheet" href="./assets/libs/jquery-ui-1.13.2/jquery-ui.min.css">
    <!-- lightbox2 css1 js1 -->
    <link rel="stylesheet" href="./assets/libs/lightbox2-2.11.4/dist/css/lightbox.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!-- custom css -->
    <link rel="stylesheet" href="./css/style.css" type="text/css">
    
    <style>

        /* Filter Section Styling */
.filter-section {
    background-color: #f8f9fa; /* Subtle light gray background */
    border: 1px solid #ddd; /* Soft border for structure */
    border-radius: 6px; /* Rounded corners */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Minimal shadow for depth */
}

/* Form Group Styling */
.form-group {
    display: flex;
    flex-direction: column;
    min-width: 200px;
}

/* Label Styling */
.form-label {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 6px;
    color: #333; /* Dark text for clarity */
}

/* Select and Input Styling */
.form-control {
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    transition: border-color 0.2s;
}

.form-control:focus {
    border-color: #007bff; /* Highlighted border on focus */
    box-shadow: 0 0 4px rgba(0, 123, 255, 0.3);
    outline: none;
}

/* Button Styling */
.btn-dark {
    background-color: #343a40; /* Dark gray for a clean button look */
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.btn-dark:hover {
    background-color: #23272b; /* Slightly darker on hover */
}

.filter{
    margin-top: 23px;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    #filterForm {
        flex-direction: column; /* Stack items vertically on smaller screens */
        gap: 20px;
    }

    .form-group {
        min-width: 100%; /* Full width for smaller devices */
    }
}


    </style>

</head>
<body>

    <!-- start back to top -->
        <div class="fixed-bottom">
            <a href="index.php" class="btn-backtotops"><i class="fas fa-arrow-up"></i></a>
        </div>
    <!-- end back to top -->

    <!-- start header section -->

        <header id="home">
            
            <!-- start Nav bar -->
                <nav class="navbar navbar-expand-lg fixed-top mx-auto">

                    <a href="index.php" class="navbar-brand text-light mx-3">
                        <img src="./assets/img/fav/sporticon.png" width="70" alt="favicon">
                        <span class="text-uppercase text-warning h2 fw-bold mx-2">Auston <span class="h4 text-white">Sport Club</span></span>
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

            <!-- start banner -->
                <div class="text-light text-center text-md-end banners">
                    <h1 class="display-5 bannerheaders fw-bold">Welcome to <span class="display-4 text-uppercase fw-bolder text-warning">Auston</span> Sport Club Home Page</h1>
                    <p class="lead bannerparagraphs fw-bold">“Talent wins games, but teamwork and intelligence win championships.” __ Michael Jordan</p>
                </div>
            <!-- start banner -->


        </header>

    <!-- end header section -->

    <div class="filter-section p-4 mb-0">

    <h2 class="text-center mb-3">Can Explore Your Interest !!</h2>
    <form id="filterForm" method="GET" action="filter.php" class="d-flex justify-content-center align-items-center gap-4 flex-wrap">
    <!-- Sports Type -->
    <div class="form-group">
        <label for="sportType" class="form-label">Sport Type</label>
        <select id="sportType" name="sport_type" class="form-control">
            <option value="">Select Sport</option>
            <option value="Football">Football</option>
            <option value="Tennis">Tennis</option>
            <option value="Swimming">Swimming</option>
            <option value="Basketball">Basketball</option>
            <option value="Ping Pong">Ping Pong</option>
            <option value="Hiking">Hiking</option>
            <option value="Marathon">Marathon</option>
            <option value="Badminton">Badminton</option>
        </select>
    </div>

    <!-- Location -->
    <div class="form-group">
        <label for="location" class="form-label">Location</label>
        <select id="location" name="location" class="form-control">
            <option value="">Select Location</option>
            <option value="Mandalarthiri Stadium, Mandalay">Mandalarthiri Stadium, Mandalay</option>
            <option value="Mandalarthiri Tennis Court, Mandalay">Mandalarthiri Tennis Court, Mandalay</option>
            <option value="Club Sports Arena, Mandalay">Club Sports Arena, Mandalay</option>
            <option value="Club Aquatic Center, Mandalay">Club Aquatic Center, Mandalay</option>
            <option value="Amarapura Icon, Mandalay">Amarapura Icon, Mandalay</option>
            <option value="Auston Campus, Mandalay">Auston Campus, Mandalay</option>
        </select>
    </div>

    <!-- Month -->
    <div class="form-group">
            <label for="month" class="form-label">Month</label>
            <select id="month" name="month" class="form-control">
                <option value="">Select Month</option>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
            </select>
    </div>

    <!-- Age Group -->
    <div class="form-group">
        <label for="ageGroup" class="form-label">Age Group</label>
        <select id="ageGroup" name="age_group" class="form-control">
            <option value="">Select Age Group</option>
            <option value="16 - 35 years">16 - 35 years</option>
            <option value="18 - 50 years">18 - 50 years</option>
            <option value="16 - unlimited years">16 - Unlimited years</option>
        </select>
    </div>

    <!-- Filter Button -->
    <div class="form-group filter">
        <button type="submit" name="filter" class="btn btn-dark px-4">Filter</button>
    </div>
    </form>

    </div>

<!-- Event Container -->
<div id="eventsContainer" class="row mt-4">
    
</div>

    <!-- start property section -->

        <section id="activities" class="py-5">
            <div class="container-fluid">

                <!-- start title -->
                <div class="text-center mb-5">
                    <div class="col">
                        <h3 class="titles">Activities</h3>
                    </div>
                </div>
                <!-- end title -->

                <ul class="list-inline text-center text-uppercase fw-bold">
                    <li class="list-inline-item activitylists activeitems" data-filter="all">All <span class="mx-3 mx-md-5 text-muted">/</span></li>
                    <li class="list-inline-item activitylists" data-filter="football">Football <span class="mx-3 mx-md-5 text-muted">/</span></li>
                    <li class="list-inline-item activitylists" data-filter="tennis">Tennis <span class="mx-3 mx-md-5 text-muted">/</span></li>
                    <li class="list-inline-item activitylists" data-filter="basketball">Basketball <span class="mx-3 mx-md-5 text-muted">/</span></li>
                    <li class="list-inline-item activitylists" data-filter="swimming">Swimming</li>
                </ul>

                <div class="container-fluid">
                    <div class="d-flex flex-wrap justify-content-center">
                        <div class="filters football"><a href="./assets/img/gallery/football1.jpg" data-lightbox="property" data-title="Image 1"><img src="./assets/img/gallery/football1.jpg" width="200" alt="image1"/></a></div>
                        <div class="filters football"><a href="./assets/img/gallery/football2.jpg" data-lightbox="property" data-title="Image 2"><img src="./assets/img/gallery/football2.jpg" width="200" alt="image2"/></a></div>
                        <div class="filters football"><a href="./assets/img/gallery/football3.jpg" data-lightbox="property" data-title="Image 3"><img src="./assets/img/gallery/football3.jpg" width="200" alt="image3"/></a></div>
                        <div class="filters football"><a href="./assets/img/gallery/football4.jpg" data-lightbox="property" data-title="Image 4"><img src="./assets/img/gallery/football4.jpg" width="200" alt="image4"/></a></div>
                        <div class="filters football"><a href="./assets/img/gallery/football5.jpg" data-lightbox="property" data-title="Image 5"><img src="./assets/img/gallery/football5.jpg" width="200" alt="image5"/></a></div>
                        <div class="filters tennis"><a href="./assets/img/gallery/tennis1.jpg" data-lightbox="property" data-title="Image 6"><img src="./assets/img/gallery/tennis1.jpg" width="200" alt="image6"/></a></div>
                        <div class="filters tennis"><a href="./assets/img/gallery/tennis2.jpg" data-lightbox="property" data-title="Image 7"><img src="./assets/img/gallery/tennis2.jpg" width="200" alt="image7"/></a></div>
                        <div class="filters tennis"><a href="./assets/img/gallery/tennis3.jpg" data-lightbox="property" data-title="Image 8"><img src="./assets/img/gallery/tennis3.jpg" width="200" alt="image8"/></a></div>
                        <div class="filters tennis"><a href="./assets/img/gallery/tennis4.jpg" data-lightbox="property" data-title="Image 9"><img src="./assets/img/gallery/tennis4.jpg" width="200" alt="image9"/></a></div>
                        <div class="filters tennis"><a href="./assets/img/gallery/tennis5.jpg" data-lightbox="property" data-title="Image 10"><img src="./assets/img/gallery/tennis5.jpg" width="200" alt="image10"/></a></div>
                        <div class="filters tennis"><a href="./assets/img/gallery/tennis6.jpg" data-lightbox="property" data-title="Image 11"><img src="./assets/img/gallery/tennis6.jpg" width="200" alt="image11"/></a></div>
                        <div class="filters tennis"><a href="./assets/img/gallery/tennis7.jpg" data-lightbox="property" data-title="Image 12"><img src="./assets/img/gallery/tennis7.jpg" width="200" alt="image12"/></a></div>
                        <div class="filters basketball"><a href="./assets/img/gallery/basket1.jpg" data-lightbox="property" data-title="Image 13"><img src="./assets/img/gallery/basket1.jpg" width="200" alt="image13"/></a></div>
                        <div class="filters basketball"><a href="./assets/img/gallery/basket2.jpg" data-lightbox="property" data-title="Image 14"><img src="./assets/img/gallery/basket2.jpg" width="200" alt="image14"/></a></div>
                        <div class="filters basketball"><a href="./assets/img/gallery/basket3.jpg" data-lightbox="property" data-title="Image 15"><img src="./assets/img/gallery/basket3.jpg" width="200" alt="image15"/></a></div>
                        <div class="filters basketball"><a href="./assets/img/gallery/basket4.jpg" data-lightbox="property" data-title="Image 16"><img src="./assets/img/gallery/basket4.jpg" width="200" alt="image16"/></a></div>
                        <div class="filters swimming"><a href="./assets/img/gallery/swim1.jpg" data-lightbox="property" data-title="Image 17"><img src="./assets/img/gallery/swim1.jpg" width="200" alt="image17"/></a></div>
                        <div class="filters swimming"><a href="./assets/img/gallery/swim2.jpg" data-lightbox="property" data-title="Image 18"><img src="./assets/img/gallery/swim2.jpg" width="200" alt="image18"/></a></div>
                        <div class="filters swimming"><a href="./assets/img/gallery/swim3.jpg" data-lightbox="property" data-title="Image 19"><img src="./assets/img/gallery/swim3.jpg" width="200" alt="image19"/></a></div>
                    </div>
                </div>

            </div>
        </section>

    <!-- end property section -->


    <!-- start adv section -->

        <section class="py-5 missions">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-5">
                        <img src="./assets/img/banner/sportsall.png" class="fromlefts advimages" alt="sports">
                    </div>

                    <div class="col-lg-7 text-white text-center text-lg-end fromrights advtexts">
                        <h1>How we started our Sport Club in University</h1>
                        <p>We started Auston University’s Sports Club to create a space for students to enjoy sports, build teamwork, and connect outside academics. With support from the Student Council, we organized football, basketball, swimming, and tennis activities, making the club a thriving community for health and camaraderie.</p>
                    </div>

                </div>
            </div>
        </section>

    <!-- end adv section -->


     <!-- start champion section -->

        <section id="champions" class="py-3 champions">

            <div class="container-fluid">

                <!-- start title -->
                <div class="text-center mb-3">
                    <div class="col">
                        <h3 class="text-white titles">Our School Champions</h3>
                    </div>
                </div>
                <!-- end title -->

                <div class="row">
                    <div class="col-md-6 mx-auto">

                      <div id="stdcarousels" class="carousel slide" data-bs-ride="carousel"> 

                        <ol class="carousel-indicators fw-lighter">
                            <li class="active" data-bs-target="#stdcarousels" data-bs-slide-to="0"></li>
                            <li data-bs-target="#stdcarousels" data-bs-slide-to="1"></li>
                            <li data-bs-target="#stdcarousels" data-bs-slide-to="2"></li>
                        </ol>

                        <div class="carousel-inner">
                            
                            <div class="carousel-item text-center active">
                                <img src="./assets/img/users/user1.jpg" class="rounded-circle" alt="user1">
                                <blockquote class="text-light">
                                    <p class="fw-bold">Tennis Champion</p>
                                    <p>University Sprots Tournament</p>
                                </blockquote>
                                <h5 class="text-uppercase fw-bold mb-3 text-white">Ms. July</h5>
                                <ul class="list-inline mb-5">
                                    <li class="list-inline-item"><i class="fas fa-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="fas fa-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="fas fa-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="fas fa-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="fas fa-star text-warning"></i></li>
                                </ul>
                            </div>

                            <div class="carousel-item text-center">
                                <img src="./assets/img/users/user2.jpg" class="rounded-circle" alt="user2">
                                <blockquote class="text-light">
                                    <p class="fw-bold">Silver Meadal Swimming Champion</p>
                                    <p>University Sprots Tournament</p>
                                </blockquote >
                                <h5 class="text-uppercase fw-bold mb-3 text-white">Mr. Anton</h5>
                                <ul class="list-inline mb-5">
                                    <li class="list-inline-item"><i class="fas fa-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="fas fa-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="fas fa-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="fas fa-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="fas fa-star text-warning"></i></li>
                                </ul>
                            </div>

                            <div class="carousel-item text-center">
                                <img src="./assets/img/users/user3.jpg" class="rounded-circle" alt="user3">
                                <blockquote class="text-light">
                                    <p class="fw-bold">Basketball Champion</p>
                                    <p>University Sprots Tournament</p>
                                </blockquote>
                                <h5 class="text-uppercase fw-bold mb-3 text-white">Ms. Yoon</h5>
                                <ul class="list-inline mb-5">
                                    <li class="list-inline-item"><i class="fas fa-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="fas fa-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="fas fa-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="fas fa-star text-warning"></i></li>
                                    <li class="list-inline-item"><i class="fas fa-star text-warning"></i></li>
                                </ul>
                            </div>

                        </div>

                      </div>

                    </div>
                </div>

            </div>

        </section>

    <!-- end champion section -->


    <!-- start footer section -->

        <footer class="bg-dark px-5">
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
    <!-- jquery js1 -->
    <script src="./assets/libs/jquery/jquery-3.7.1.min.js" type="text/javascript"></script>
    <!-- jquery ui css1 js1 -->
    <script src="./assets/libs/jquery-ui-1.13.2/jquery-ui.min.js" type="text/javascript"></script>
    <!-- lightbox2 css1 js1 -->
    <script src="./assets/libs/lightbox2-2.11.4/dist/js/lightbox.min.js" type="text/javascript"></script>
    <!-- custom js -->
    <script src="./js/app.js" type="text/javascript"></script>
    
    <script>
        
        $(document).ready(function() {
    // Handle form submission
    $('#filterForm').submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        let formData = $(this).serialize(); // Serialize form data
        formData += '&filter=true'; // Append the filter parameter

        // Make AJAX request
        $.ajax({
            url: 'filter.php',
            type: 'GET',
            data: formData,
            success: function(response) {
                // Insert the response into the eventsContainer
                $('#eventsContainer').html(response);
            },
            error: function() {
                alert('Something went wrong.');
            }
        });
    });
});



    </script>
    
</body>
</html>