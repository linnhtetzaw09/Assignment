<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- bootstrap css1 js1 -->
    <link rel="stylesheet" href="./assets/libs/bootstrap-5.3.2-dist/css/bootstrap.min.css"/>
    <!-- custom css -->
    <link rel="stylesheet" href="./css/style.css" type="text/css">

</head>
<body class="bg-light">
    
    <section id="contact" class="p-5 contacts">
        <div class="container-fluid">
            <div class="col-md-5 mx-auto">
                <h5 class="display-4 mb-3 text-center text-white fw-bold">Stay Updated with Announcements</h5>

                <form id="signupForm" method="POST" action="signupload.php">
                    
                    <div class="form-group py-1 my-2">
                        <label for="name" class="labels fw-bold">Full Name</label>
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

                    <div class="form-group py-1">
                        <label for="email" class="labels fw-bold">Email Address</label>
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

                    <<div class="form-group py-1">
                        <label for="password" class="labels fw-bold">Password</label>
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

                    <div class="form-group py-1">
                        <label for="confirm_password" class="labels fw-bold">Confirm Password</label>
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

                    <div class="form-group py-1">
                        <label for="age" class="labels fw-bold">Age</label>
                        <input 
                            type="number" 
                            id="age" 
                            name="age" 
                            class="form-control p-3 inputs" 
                            placeholder="Enter your age" 
                            value="" 
                            required 
                            min="1" 
                            max="120"
                        />
                    </div>

                    <div class="form-group py-3">
                        <label for="preferred_sport" class="labels fw-bold my-1">Preferred Sport</label>
                        <select class="form-select" id="preferred_sport" name="preferred_sport">
                            <option value="" disabled selected>Choose your preferred sport</option>
                            <option value="Football">Football</option>
                            <option value="Tennis">Tennis</option>
                            <option value="Swimming">Swimming</option>
                            <option value="Cycling">Cycling</option>
                            <option value="Basketball">Basketball</option>
                            <option value="Hiking">Hiking</option>
                            <option value="PingPong">Ping Pong</option>
                            <option value="Marathon">Marathon</option>
                        </select>
                    </div>

                    <div class="form-group py-3">
                        <label for="skill_level" class="labels fw-bold my-1">Skill Level</label>
                        <select class="form-select" id="skill_level" name="skill_level">
                            <option value="" disabled selected>Choose your skill level</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Player">Player</option>
                            <option value="Advanced">Advanced</option>
                        </select>
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

    <script src="./assets/libs/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>

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
