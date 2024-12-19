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
    <!-- <link rel="stylesheet" href="./assets/libs/bootstrap-5.3.2-dist/css/bootstrap.min.css"/> -->
    <!-- fontawsome css1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jquery ui css1 js1 -->
    <link rel="stylesheet" href="./assets/libs/jquery-ui-1.13.2/jquery-ui.min.css">
    <!-- lightbox2 css1 js1 -->
    <link rel="stylesheet" href="./assets/libs/lightbox2-2.11.4/dist/css/lightbox.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!-- custom css -->
    <link rel="stylesheet" href="./css/style.css" type="text/css">

    <!-- <style>
        #contact{
            padding-top: 150px;
            margin: 0;
        }
    </style> -->

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

<!-- start contact section -->

<section id="contact" class="p-5 contacts">
        <div class="container-fluid">
            <div class="col-md-5 mx-auto">
                <h5 class="display-4 mb-3 text-center text-white fw-bold">Stay Updated with Announcements</h5>

                <form id="signupForm" method="POST" action="signupload.php">
                    
                    <div class="form-group py-3 my-2">
                        <label for="name" class="labels">Full Name <span class="text-danger">* required</span></label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="form-control p-3 inputs" 
                            placeholder="Enter your name" 
                            value="" 
                            required 
                            autocomplete="off"
                        />
                    </div>

                    <div class="form-group py-3">
                        <label for="email" class="labels">Email Address <span class="text-danger">* required</span></label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control p-3 inputs" 
                            placeholder="Enter your email" 
                            value="" 
                            required 
                            autocomplete="off"
                        />
                    </div>

                    <<div class="form-group py-3">
                        <label for="password" class="labels">Password <span class="text-danger">* required</span></label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-control p-3 inputs" 
                            placeholder="Enter your password" 
                            required 
                            autocomplete="off"
                            minlength="8"
                            pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}"
                            title="Password must be at least 8 characters long, include at least one uppercase letter, one lowercase letter, one number, and one special character."
                        />
                    </div>

                    <div class="form-group py-3">
                        <label for="confirm_password" class="labels">Confirm Password <span class="text-danger">* required</span></label>
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            class="form-control p-3 inputs" 
                            placeholder="Confirm your password" 
                            required 
                            autocomplete="off"
                            oninput="this.setCustomValidity(this.value !== document.getElementById('password').value ? 'Passwords do not match' : '')"
                        />
                    </div>

                    <div class="my-4">
                        <div class="form-check">
                            <input type="checkbox" id="accept" name="accept" class="form-check-input" required />
                            <label for="accept" class="form-check-label text-light">I agree to receive notifications</label>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn text-uppercase fw-bold rounded-0 submit-btns">Sign Up</button>
                    </div>
                </form>

                <?php if (isset($error)) { echo "<p class='text-danger'>$error</p>"; } ?>
                
                <p class="text-center text-white mt-3">Already have an account? <a href="login.php" class="text-decoration-none">Login here</a></p>
            </div>
        </div>
    </section>
    
    <!-- end contact section -->


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
    <!-- <script src="./assets/libs/bootstrap-5.3.2-dist/js/bootstrap.min.js" type="text/javascript"></script> -->
    <!-- jquery js1 -->
    <script src="./assets/libs/jquery/jquery-3.7.1.min.js" type="text/javascript"></script>
    <!-- jquery ui css1 js1 -->
    <script src="./assets/libs/jquery-ui-1.13.2/jquery-ui.min.js" type="text/javascript"></script>
    <!-- lightbox2 css1 js1 -->
    <script src="./assets/libs/lightbox2-2.11.4/dist/js/lightbox.min.js" type="text/javascript"></script>
    <!-- custom js -->
    <script src="./js/app.js" type="text/javascript"></script>

    <script>
        $(document).on('submit', '#signupForm', function(e) {
            e.preventDefault();

            $.ajax({
                url: 'signupload.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    var res = JSON.parse(response); 
                    if (res.success) {
                        window.location.href = 'login.php'; 
                    } else {
                        alert('Failed to sign up: ' + res.error); 
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', xhr, status, error); 
                    alert('An error occurred. Please try again.');
                }
            });
        });
    </script>
    
</body>
</html>
