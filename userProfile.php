<?php
// Start session
session_start();

// Include database connection
include('mysql/db_connect.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user profile data from the database
$query = "SELECT name, email, preferred_sport, skill_level FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch user's event history
$query_events = "SELECT e.title, e.event_date, e.time 
                 FROM events e 
                 JOIN registers r ON e.id = r.event_id
                 WHERE r.email = ? 
                 ORDER BY e.event_date DESC, e.time DESC";  
$stmt_events = $conn->prepare($query_events);
$stmt_events->bind_param("s", $user['email']);  // Use email to match user registrations
$stmt_events->execute();
$result_events = $stmt_events->get_result();

// Check if form is submitted to update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Retrieve and trim input values
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $preferred_sport = isset($_POST['preferred_sport']) ? $_POST['preferred_sport'] : null;
  $skill_level = isset($_POST['skill_level']) ? $_POST['skill_level'] : null;

  // Validate inputs
  if (!empty($name) && !empty($email) && !empty($preferred_sport) && !empty($skill_level)) {
      // Update query
      $update_query = "UPDATE users SET name = ?, email = ?, preferred_sport = ?, skill_level = ? WHERE id = ?";
      $update_stmt = $conn->prepare($update_query);
      $update_stmt->bind_param("ssssi", $name, $email, $preferred_sport, $skill_level, $user_id);

      if ($update_stmt->execute()) {
          // Update session variables if needed
          $_SESSION['name'] = $name;

          // Success message with redirect
          echo "<script>
                  alert('Profile updated successfully!');
                  window.location.href = 'userProfile.php';
                </script>";
      } else {
          // Error message
          echo "<script>alert('Error updating profile: " . $update_stmt->error . "');</script>";
      }
  } else {
      echo "<script>alert('Please fill in all fields.');</script>";
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
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
  <link rel="stylesheet" href="./css/style.css" type="text/css">
  <style>
    #profilehead{
      padding-top: 150px !important;
      margin: 0;
    }
  </style>
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

  <!-- Profile Header -->
  <div id="profilehead" class="py-5 bg-light text-center">
    <h1>Welcome, <span class="text-success"><?php echo $user['name']; ?></span></h1>
    <p class="lead text-dark">Keep on track your activities and mangae your profile.</p>
  </div>

<!-- User and Event History Section -->
<section class="profile-info py-5">
  <div class="container">
    <div class="row g-4">
      <!-- User Information Section -->
      <div class="col-lg-4 col-md-6">
        <div class="card shadow border-0">
          <div class="card-body text-center">
            <i class="bi bi-person-circle display-1 text-dark mb-3"></i>
            <h3><?php echo $user['name']; ?></h3>
            <p class="text-muted"><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
          </div>
        </div>
      </div>

      <!-- Event History Section -->
      <div class="col-lg-8 col-md-6">
        <div class="card shadow border-0">
          <div class="card-body">
            <h3 class="mb-4">Event History</h3>
            <ul class="list-group list-group-flush">
              <?php while ($event = $result_events->fetch_assoc()): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center flex-column flex-sm-row">
                  <div class="w-100">
                    <strong><?php echo $event['title']; ?></strong> - <?php echo $event['event_date']; ?>
                  </div>
                  <div class="w-100 mt-2 mt-sm-0 d-flex justify-content-end align-items-center">
                    <?php if (strtotime($event['event_date']) > time()): ?>
                      <span class="badge bg-success">Upcoming</span>
                      <button class="btn btn-outline-primary btn-sm ms-2">Unregister</button>
                    <?php else: ?>
                      <span class="badge bg-warning">Completed</span>
                      <button class="btn btn-outline-danger btn-sm ms-2">Finished</button>
                    <?php endif; ?>
                  </div>
                </li>
              <?php endwhile; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="edit" method="POST" action="userProfile.php">
                <div class="mb-3">
                    <label for="editName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="editName" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" placeholder="Enter your new name">
                </div>
                <div class="mb-3">
                    <label for="editEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="editEmail" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Enter your email">
                </div>
                <div class="mb-3">
                    <label for="preferred_sport" class="form-label">Preferred Sports</label>
                    <select class="form-select" id="preferred_sport" name="preferred_sport">
                        <option value="" disabled selected>Choose your preferred sport</option>
                        <option value="Football" <?php if ($user['preferred_sport'] == 'Football') echo 'selected'; ?>>Football</option>
                        <option value="Tennis" <?php if ($user['preferred_sport'] == 'Tennis') echo 'selected'; ?>>Tennis</option>
                        <option value="Swimming" <?php if ($user['preferred_sport'] == 'Swimming') echo 'selected'; ?>>Swimming</option>
                        <option value="Cycling" <?php if ($user['preferred_sport'] == 'Cycling') echo 'selected'; ?>>Cycling</option>
                        <option value="Basketball" <?php if ($user['preferred_sport'] == 'Basketball') echo 'selected'; ?>>Basketball</option>
                        <option value="Hiking" <?php if ($user['preferred_sport'] == 'Hiking') echo 'selected'; ?>>Hiking</option>
                        <option value="PingPong" <?php if ($user['preferred_sport'] == 'PingPong') echo 'selected'; ?>>Ping Pong</option>
                        <option value="Marathon" <?php if ($user['preferred_sport'] == 'Marathon') echo 'selected'; ?>>Marathon</option>
                    </select>
                </div>
                <div class="mb-3">
                  <label for="skill_level" class="form-label">Skill Level</label>
                  <select class="form-select" id="skill_level" name="skill_level">
                    <option value="" disabled selected>Choose your skill level</option>
                    <option value="Beginner" <?php if ($user['skill_level'] == 'Beginner') echo 'selected'; ?>>Beginner</option>
                    <option value="Intermediate" <?php if ($user['skill_level'] == 'Player') echo 'selected'; ?>>Player</option>
                    <option value="Advanced" <?php if ($user['skill_level'] == 'Advanced') echo 'selected'; ?>>Advanced</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-warning">Update Profile</button>
            </form>
            </div>
        </div>
    </div>
</div>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
