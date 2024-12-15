<?php
session_start();

$isLoggedIn = isset($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <!-- fav icon -->
    <link rel="icon" href="./assets/img/fav/favicon.png" type="image/png" sizes="16x16">
    <!-- bootstrap css1 js1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="./assets/libs/bootstrap-5.3.2-dist/css/bootstrap.min.css"/> -->
    <!-- fontawsome css1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jquery ui css1 js1 -->
    <link rel="stylesheet" href="./assets/libs/jquery-ui-1.13.2/jquery-ui.min.css">
    <!-- lightbox2 css1 js1 -->
    <link rel="stylesheet" href="./assets/libs/lightbox2-2.11.4/dist/css/lightbox.min.css">
    <!-- custom css -->
    <link rel="stylesheet" href="./css/style.css" type="text/css">
</head>
<body>

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

    <section id="events" class="p-4 events">

        <div class="container-fluid p-3 pt-5">

            <!-- start title -->
            <div class="text-center p-3 pt-5 mt-3 mb-3">
                <div class="col">
                    <h3 class="text-light titles">Our Coming Events</h3>
                </div>
            </div>
            <!-- end title -->

            <div class="row">

            <div class="col-lg-6 col-md-9 col-sm-12 mb-3">
                <div class="card eventscards border-0">
                    <img src="./assets/img/gallery/footballbg.jpg" class="" alt="football" />
                    <h5 class="text-white text-uppercase fw-bold p-2 headings">Football Tournament 2025</h5>
                </div>
            
                <div class="btn-container">
                    <a href="#" onclick="footballEventInfo()" id="football" class="btn">About Event</a>
                    <a href="#" class="btn register-btn" data-bs-toggle="modal" data-bs-target="#registerModal" data-event-id="1" data-title="Football Tournament 2025">Register Now</a>
                </div>
            </div>
            
            <!-- Event Information Section (Initially Hidden) -->
            <div id="footballEventInfo" class="event-info">
                <h3 class="text-white">Event Information</h3>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Date:</strong> <span id="eventDate">March 15–17, 2024</span></li>
                    <li class="list-group-item"><strong>Time:</strong> <span id="eventTime">9:00 AM</span></li>
                    <li class="list-group-item"><strong>Location:</strong> <span id="eventLocation">Stadium ABC, City XYZ</span></li>
                    <li class="list-group-item"><strong>Sport:</strong> <span id="eventSport">Football</span></li>
                    <li class="list-group-item"><strong>Age Group:</strong> <span id="eventAgeGroup">18-25 years</span></li>
                    <li class="list-group-item"><strong>Description:</strong> <span id="eventDescription">A thrilling football competition for young athletes!</span></li>
                </ul>
                <button type="button" class="back-btn" data-event="footballEventInfo">Back</button>
            </div>

            <div class="col-lg-6 col-md-9 col-sm-12 mb-3">
                <div class="card eventscards border-0">
                    <img src="./assets/img/gallery/tennisbg.jpg" class="" alt="tennis" />
                    <h5 class="text-white text-uppercase fw-bold p-2 headings">Tennis Tournament 2025</h5>
                </div>

                <div class="btn-container">
                    <a href="#" onclick="tennisEventInfo()" id="tennis" class="btn">About Event</a>
                    <a href="#" class="btn register-btn" data-bs-toggle="modal" data-bs-target="#registerModal" data-event-id="2" data-title="Tennis Tournament 2025">Register Now</a>
                </div>
            </div>

            <div id="tennisEventInfo" class="event-info">
                <h3 class="text-white">Event Information</h3>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Date:</strong> <span id="eventDate">April 20–22, 2024</span></li>
                    <li class="list-group-item"><strong>Time:</strong> <span id="eventTime">8:00 AM</span></li>
                    <li class="list-group-item"><strong>Location:</strong> <span id="eventLocation">Tennis Courts XYZ</span></li>
                    <li class="list-group-item"><strong>Sport:</strong> <span id="eventSport">Tennis</span></li>
                    <li class="list-group-item"><strong>Age Group:</strong> <span id="eventAgeGroup">16-30 years</span></li>
                    <li class="list-group-item"><strong>Description:</strong> <span id="eventDescription">A competitive tennis tournament for all skill levels</span></li>
                </ul>
                <button type="button" class="back-btn" data-event="tennisEventInfo">Back</button>
            </div>

            <div class="col-lg-6 col-md-9 col-sm-12 mb-3">
                <div class="card eventscards border-0">
                    <img src="./assets/img/gallery/swimbg.jpg" class="" alt="swimming" />
                    <h5 class="text-white text-uppercase fw-bold p-2 headings">Swimming Championship 2025</h5>
                </div>

                <div class="btn-container">
                    <a href="#" onclick="swimEventInfo()" id="swim" class="btn">About Event</a>
                    <a href="#" class="btn register-btn" data-bs-toggle="modal" data-bs-target="#registerModal" data-event-id="3" data-title="Swimming Championship 2025">Register Now</a>
                </div>
            </div>

            <div id="swimEventInfo" class="event-info">
                <h3 class="text-white">Event Information</h3>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Date:</strong> <span id="eventDate">December 10 - 12, 2024</span></li>
                    <li class="list-group-item"><strong>Time:</strong> <span id="eventTime">8:00 AM</span></li>
                    <li class="list-group-item"><strong>Location:</strong> <span id="eventLocation">Club Aquatic Center</span></li>
                    <li class="list-group-item"><strong>Sport:</strong> <span id="eventSport">Swimming</span></li>
                    <li class="list-group-item"><strong>Age Group:</strong> <span id="eventAgeGroup">12-25 years</span></li>
                    <li class="list-group-item"><strong>Description:</strong> <span id="eventDescription">A race for swimmers of all levels to showcase their skills.</span></li>
                </ul>
                <button type="button" class="back-btn" data-event="swimEventInfo">Back</button>
            </div>

            <div class="col-lg-6 col-md-9 col-sm-12 mb-3">
                <div class="card eventscards border-0">
                    <img src="./assets/img/gallery/basketbg.jpg" class="" alt="basketball" />
                    <h5 class="text-white text-uppercase fw-bold p-2 headings">Basketball League 2025</h5>
                </div>

                <div class="btn-container">
                    <a href="#" onclick="basketEventInfo()" id="basket" class="btn">About Event</a>
                    <a href="#" class="btn register-btn" data-bs-toggle="modal" data-bs-target="#registerModal" data-event-id="4" data-title="Basketball League 2025">Register Now</a>
                </div>
            </div>

            <div id="basketEventInfo" class="event-info">
                <h3 class="text-white">Event Information</h3>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Date:</strong> <span id="eventDate">April 5–20, 2024</span></li>
                    <li class="list-group-item"><strong>Time:</strong> <span id="eventTime">6:00 PM</span></li>
                    <li class="list-group-item"><strong>Location:</strong> <span id="eventLocation">Club Sports Arena</span></li>
                    <li class="list-group-item"><strong>Sport:</strong> <span id="eventSport">Basketball</span></li>
                    <li class="list-group-item"><strong>Age Group:</strong> <span id="eventAgeGroup">18-30 years</span></li>
                    <li class="list-group-item"><strong>Description:</strong> <span id="eventDescription">A competitive basketball league for teams.</span></li>
                </ul>
                <button type="button" class="back-btn" data-event="basketEventInfo">Back</button>
            </div>

        </div>
        
        <!-- Registration Modal (Single for All Events) -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Register for Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if ($isLoggedIn): ?>
                    <form id="registrationForm" action="register.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" name="age" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <input type="hidden" id="event_id" name="event_id" value="">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                <?php else: ?>
                    <p class="text-center">You must be logged in to register.</p>
                    <p class="text-center"><a href="login.php">Login here</a> to continue.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
        </div>

    </section>

    <!-- start footer section -->

    <footer id="eventfooter" class="bg-dark px-5">
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
    <!-- <script src="./assets/libs/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js" type="text/javascript"></script> -->
    <!-- jquery js1 -->
    <script src="./assets/libs/jquery/jquery-3.7.1.min.js" type="text/javascript"></script>
    <!-- jquery ui css1 js1 -->
    <script src="./assets/libs/jquery-ui-1.13.2/jquery-ui.min.js" type="text/javascript"></script>
    <!-- lightbox2 css1 js1 -->
    <script src="./assets/libs/lightbox2-2.11.4/dist/js/lightbox.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!-- custom js -->
    <script src="./js/app.js" type="text/javascript"></script>

<script>
    
    document.addEventListener('DOMContentLoaded', () => {
    // Select all buttons with the 'register-btn' class
    const registerButtons = document.querySelectorAll('.register-btn');

    // Loop through the buttons and add event listeners
    registerButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Get the event ID and event title from the button's attributes
            const eventId = button.getAttribute('data-event-id');
            const eventTitle = button.getAttribute('data-title');
            
            // Update the modal title with the event title
            const modalTitle = document.getElementById('registerModalLabel');
            modalTitle.textContent = `Register for ${eventTitle}`;
            
            // Set the hidden event_id input field in the form
            const eventIdInput = document.getElementById('event_id');
            eventIdInput.value = eventId;
        });
    });
});



</script>

</body>
</html>

