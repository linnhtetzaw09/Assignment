<?php
session_start();

include('../mysql/db_connect.php');

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: ../index.php');
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch total events count
$query_total_events = "SELECT COUNT(*) as total_events FROM events";
$result_total_events = $conn->query($query_total_events);
$total_events = $result_total_events->fetch_assoc()['total_events'];

// Fetch total registrations count
$query_total_registrations = "SELECT COUNT(*) as total_registrations FROM registers";
$result_total_registrations = $conn->query($query_total_registrations);
$total_registrations = $result_total_registrations->fetch_assoc()['total_registrations'];

// Fetch total members count
$query_total_users = "SELECT COUNT(*) as total_users FROM users";
$result_total_users = $conn->query($query_total_users);
$total_users = $result_total_users->fetch_assoc()['total_users'];

// Fetch all events from the events table
$query_events = "SELECT id, title, event_date, time, location, age_group FROM events";
$result_events = $conn->query($query_events);

if (!$result_events) {
    die("Error fetching events: " . $conn->error);
} 

// Fetch all users from the users table
$query_users = "SELECT id, name, email, preferred_sport, skill_level, is_admin FROM users";
$result_users = $conn->query($query_users);

if (!$result_users) {
    die("Error fetching users: " . $conn->error);
}

$noadmin_users = "SELECT id, name, email, preferred_sport, skill_level, is_admin FROM users WHERE is_admin = 0";
$login_users = $conn->query($noadmin_users);


// Fetch registrations from pending_users and registers
$query_pending = "SELECT * FROM pending_users";
$result_pending = $conn->query($query_pending);

$query_approved = "SELECT * FROM registers";
$result_approved = $conn->query($query_approved);

$pendingRegistrations = [];
$approvedRegistrations = [];

if ($result_pending->num_rows > 0) {
    while ($row = $result_pending->fetch_assoc()) {
        $pendingRegistrations[] = $row;
    }
}

if ($result_approved->num_rows > 0) {
    while ($row = $result_approved->fetch_assoc()) {
        $approvedRegistrations[] = $row;
    }
}

// Combine and sort the results
$allRegistrations = array_merge($pendingRegistrations, $approvedRegistrations);
usort($allRegistrations, function($a, $b) {
    return strtotime($b['updated_at']) - strtotime($a['updated_at']);
});

// Assign a new sequential ID based on the combined and sorted registrations
foreach ($allRegistrations as $key => $register) {
    $allRegistrations[$key]['new_id'] = $key + 1;
}


?>

<?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
<?php endif; ?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- fav icon -->
    <link rel="icon" href="../assets/img/fav/favicon.png" type="image/png" sizes="16x16">
    <!-- bootstrap css1 js1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- fontawsome css1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jquery ui css1 js1 -->
    <link rel="stylesheet" href="../assets/libs/jquery-ui-1.13.2/jquery-ui.min.css">
    <!-- lightbox2 css1 js1 -->
    <link rel="stylesheet" href="../assets/libs/lightbox2-2.11.4/dist/css/lightbox.min.css">
    <!-- custom css -->
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    

    <style>

        .btn {
            width: 100px; 
            height: 40px;
        }

        #registrationsChart {
            max-width: 100%; 
            height: auto; 
            max-height: 400px;
        }


    </style>
</head>
<body>

    <!-- start Nav bar -->
        <nav class="navbar navbar-expand-lg fixed-top">

            <a href="index.html" class="navbar-brand text-light mx-3">
                <img src="../assets/img/fav/sporticon.png" width="70" alt="favicon">
                <span class="text-uppercase h2 fw-bold mx-2">Auston <span class="h4">Sport Club</span></span>
            </a>

            <button type="button" class="navbar-toggler navbuttons" data-bs-toggle="collapse" data-bs-target="#nav">
                <div class="bg-light lines1"></div>
                <div class="bg-light lines2"></div>
                <div class="bg-light lines3"></div>
            </button>

            <div id="nav" class="navbar-collapse collapse d-flex justify-content-between align-items-center text-uppercase fw-bold">
                        <ul class="navbar-nav d-flex align-items-center mb-0">
                            <li class="nav-item"><a href="../index.php" class="nav-link mx-2 menuitems">Home</a></li>
                            <li class="nav-item"><a href="../aboutus.php" class="nav-link mx-2 menuitems">About Us</a></li>
                            <li class="nav-item"><a href="../announcement.php" class="nav-link mx-2 menuitems">News & Announcements</a></li>
                            <li class="nav-item"><a href="../events.php" class="nav-link mx-2 menuitems">Events</a></li>
                            <li class="nav-item"><a href="../contactus.php" class="nav-link mx-2 menuitems">Contact</a></li>
                            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                                <li class="nav-item"><a href="dashboard.php" class="nav-link mx-2 menuitems">Dashboard</a></li>
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
                                        <li><a href="../userProfile.php" class="dropdown-item">Edit Profile</a></li>
                                        <li><a href="../logout.php" class="dropdown-item">Logout</a></li>
                                    </ul>
                                </li>
                            <?php else: ?>
                            <li class="nav-item">
                                    <a href="../login.php" class="nav-link">
                                        <i class="bi bi-person-circle align-icon" style="font-size: 1.5rem;"></i> Login
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                            
                    </div>

        </nav>
    <!-- end Nav bar -->


<div class="container mt-5 pt-5">
    <h1 class="mb-4 mt-5 text-center text-primary text-uppercase">Admin Interface</h1>
    
    <!-- Statistics Section -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text fs-4 fw-bold"><?php echo $total_users; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Events</h5>
                    <p class="card-text fs-4 fw-bold"><?php echo $total_events; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Registers</h5>
                    <p class="card-text fs-4 fw-bold"><?php echo $total_registrations; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Event Form -->
    <div class="mt-5">
        <h2 class="text-secondary">New Events</h2>

        <form action="addEvent.php" method="POST" enctype="multipart/form-data" class="p-4 bg-light rounded shadow-sm">
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Event Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="col-md-3">
                    <label for="event_date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="event_date" name="event_date" required>
                </div>
                <div class="col-md-3">
                    <label for="time" class="form-label">Time</label>
                    <input type="time" class="form-control" id="time" name="time" required>
                </div>
                <div class="col-md-6">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" required>
                </div>
                <div class="col-md-6">
                    <label for="sport" class="form-label">Sport</label>
                    <input type="text" class="form-control" id="sport" name="sport" required>
                </div>
                <div class="col-md-6">
                    <label for="age_group" class="form-label">Age Group</label>
                    <input type="text" class="form-control" id="age_group" name="age_group" required>
                </div>
                <div class="col-md-6">
                    <label for="image" class="form-label">Event Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3 w-100">Add Event</button>
        </form>
    </div>

    <!-- Existing Events Section -->
    <div class="mt-5">
        <h3 class="mt-5 text-secondary">Existing Events</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No.</th>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th>Age Group</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php if ($result_events->num_rows > 0): ?>
                        <?php while ($event = $result_events->fetch_assoc()): ?>
                            <tr>
                                <td class="align-middle"><?php echo htmlspecialchars($event['id']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($event['title']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($event['event_date']); ?></td>
                                <td class="align-middle">
                                    <?php
                                        $time = new DateTime($event['time']);
                                        echo $time->format('h:i A'); 
                                    ?>
                                </td>
                                <td class="align-middle"><?php echo htmlspecialchars($event['location']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($event['age_group']); ?></td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-primary btn-actions edit-btn" data-bs-toggle="modal" data-bs-target="#editEventModal" data-id="<?= $event['id']; ?>">
                                             Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger btn-actions delete-btn" data-id="<?= $event['id']; ?>">
                                             Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">No events found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Admin Management Section -->
    <div class="mt-5">
        <h2 class="text-secondary">All Admins</h2>

        <!-- Users Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No.</th>
                        <th>Admin Name</th>
                        <th>Email</th>
                        <th>Preferred Sport</th>
                        <th>Skill Level</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php if ($result_users->num_rows > 0): ?>
                        <?php $counter = 1; ?>
                        <?php while ($user = $result_users->fetch_assoc()): ?>
                            <?php if ($user['is_admin'] == 1):  ?>
                                <tr>
                                    <td class="align-middle"><?php echo $counter++; ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($user['preferred_sport']); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($user['skill_level']); ?></td>
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-sm btn-primary view-btn" 
                                            data-bs-toggle="modal" data-bs-target="#viewMemberModal" data-id="<?= $user['id']; ?>">
                                             View
                                        </button>
                                        <button class="btn btn-sm btn-danger remove-btn" data-id="<?= $user['id']; ?>">
                                             Remove
                                        </button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No members found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
    
    <!-- User Management Section -->
    <div class="mt-5">
        <h2 class="text-secondary">User Management</h2>

        <!-- Users Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Preferred Sport</th>
                        <th>Skill Level</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php if ($login_users->num_rows > 0): ?>
                        <?php $counter = 1; ?>
                        <?php while ($user = $login_users->fetch_assoc()): ?>
                                <tr>
                                <td class="align-middle"><?php echo $counter++; ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($user['name']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($user['email']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($user['preferred_sport']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($user['skill_level']); ?></td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-sm btn-primary view-btn" 
                                        data-bs-toggle="modal" data-bs-target="#viewMemberModal" data-id="<?= $user['id']; ?>">
                                         View
                                    </button>
                                    <button class="btn btn-sm btn-danger remove-btn" data-id="<?= $user['id']; ?>">
                                         Remove
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No members found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- User Registration Section -->
<div class="mt-5">
    <h3 class="mt-5 text-secondary">Control Registration</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark text-center">
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Phone</th>
                    <th>Event ID</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php if (count($allRegistrations) > 0): ?>
                    <?php foreach ($allRegistrations as $register): ?>
                        <tr>
                            <td class="align-middle"><?= htmlspecialchars($register['new_id']); ?></td>
                            <td class="align-middle"><?= htmlspecialchars($register['name']); ?></td>
                            <td class="align-middle"><?= htmlspecialchars($register['age']); ?></td>
                            <td class="align-middle"><?= htmlspecialchars($register['phone']); ?></td>
                            <td class="align-middle"><?= htmlspecialchars($register['event_id']); ?></td>
                            <td class="align-middle">
                                <?php 
                                    $dateTime = new DateTime($register['updated_at']);
                                    echo $dateTime->format('d M h:i A');
                                ?>
                            </td>
                            <td>
                                <?php if ($register['status'] == 'Approved'): ?>
                                    <span class="text-success">Approved</span>
                                <?php else: ?>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-primary btn-approve" data-id="<?= $register['id']; ?>">Approve</button>
                                        <button class="btn btn-sm btn-danger btn-reject" data-id="<?= $register['id']; ?>">Reject</button>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No registrations found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


</div>

<!-- Edit Event Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="eventEditForm" action="editEvent.php" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editEventId" name="editEventId">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Event Title</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_event_date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="edit_event_date" name="event_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_time" class="form-label">Time</label>
                        <input type="time" class="form-control" id="edit_time" name="time" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="edit_location" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_sport" class="form-label">Sport</label>
                        <input type="text" class="form-control" id="edit_sport" name="sport" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_age_group" class="form-label">Age Group</label>
                        <input type="text" class="form-control" id="edit_age_group" name="age_group" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Event Image</label>
                        <input type="file" class="form-control" id="edit_image" name="image" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
    

<!-- View Member Modal -->
<div class="modal fade" id="viewMemberModal" tabindex="-1" aria-labelledby="viewMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title" id="viewMemberModalLabel">Member Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- Modal Body -->
        <div class="modal-body">
          <ul class="list-group">
            <li class="list-group-item"><strong>Name:</strong> <span id="modal-name"></span></li>
            <li class="list-group-item"><strong>Email:</strong> <span id="modal-email"></span></li>
            <li class="list-group-item"><strong>Signup Time: </strong> <span id="modal-signup-time"></span></li>
            <li class="list-group-item"><strong>Preferred Sports:</strong> <span id="modal-preferred-sport"></span></li>
            <li class="list-group-item"><strong>Skill Level:</strong> <span id="modal-skill-level"></span></li>
          </ul>
        </div>
        <!-- Modal Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="container mt-3 mb-5">
    <h1 class="text-center mb-3">Text U want to give title </h1>
    <canvas id="registrationsChart"></canvas>
</div>

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
    <!-- jquery js1 -->
    <script src="../assets/libs/jquery/jquery-3.7.1.min.js" type="text/javascript"></script>
    <!-- jquery ui css1 js1 -->
    <script src="../assets/libs/jquery-ui-1.13.2/jquery-ui.min.js" type="text/javascript"></script>
    <!-- lightbox2 css1 js1 -->
    <script src="../assets/libs/lightbox2-2.11.4/dist/js/lightbox.min.js" type="text/javascript"></script>
    <!-- custom js -->
    <script src="../js/app.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    

    <script>

document.addEventListener('DOMContentLoaded', function () {
    // Select all edit buttons
    const editButtons = document.querySelectorAll('.edit-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const eventId = this.getAttribute('data-id');

            // Use AJAX to fetch event data from the server
            fetch(`getEvent.php?id=${eventId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editEventId').value = data.id;
                    document.getElementById('edit_title').value = data.title;
                    document.getElementById('edit_event_date').value = data.event_date;
                    document.getElementById('edit_time').value = data.time;
                    document.getElementById('edit_location').value = data.location;
                    document.getElementById('edit_sport').value = data.sport;
                    document.getElementById('edit_age_group').value = data.age_group;
                    document.getElementById('edit_description').value = data.description;
                    document.getElementById('edit_image').value = data.image;
                })
                .catch(error => console.error('Error fetching event data:', error));
        });
    });
});

$(document).on('click', '.delete-btn', function() {
    var eventId = $(this).data('id'); 
    
    if (confirm('Are you sure you want to delete this event?')) {
        $.ajax({
            url: 'deleteEvent.php',
            method: 'POST',
            data: { event_id: eventId },
            success: function(response) {
                response = JSON.parse(response);  // Parse the JSON response
                if (response.success) {
                    alert('Event deleted successfully.');
                    location.reload(); // Reload the page or update dynamically
                } else {
                    alert('Failed to delete the event. Error: ' + response.error);
                }
            },
            error: function() {
                alert('An error occurred while processing the request.');
            }
        });
    }
});

$(document).on('click', '.view-btn', function() {
    var userId = $(this).data('id');
    
    // Ajax request to fetch user data
    $.ajax({
        url: 'userInfos.php',
        method: 'GET',
        data: { user_id: userId },
        success: function(response) {
            var user = JSON.parse(response); // Parse JSON response
            $('#modal-name').text(user.name);
            $('#modal-email').text(user.email);
            
            // Format Signup Time
            var signupTime = new Date(user.updated_at);
            var formattedDate = signupTime.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
            var formattedTime = signupTime.toLocaleTimeString('en-GB', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true // Display in 12-hour format
            });

            $('#modal-signup-time').text(formattedDate + ' ' + formattedTime);
            $('#modal-preferred-sport').text(user.preferred_sport);
            $('#modal-skill-level').text(user.skill_level);
        },
        error: function() {
            alert('Error fetching user details.');
        }
    });
});

$(document).on('click', '.remove-btn', function() {
    var userId = $(this).data('id'); // Get user ID from data-id attribute

    if (confirm('Are you sure you want to remove this user?')) {
        $.ajax({
            url: 'deleteUser.php', // Your PHP script to handle deletion
            method: 'POST',
            data: { user_id: userId },
            success: function(response) {
                if (response.success) {
                    alert('User removed successfully.');
                    location.reload();
                } else {
                    location.reload();
                }
            },
            error: function() {
                alert('An error occurred while processing the request.');
            }
        });
    }
});

$(document).on('click', '.btn-approve', function () {
    const registrationId = $(this).data('id');

    $.ajax({
        url: 'adminControl.php',
        type: 'POST',
        data: { id: registrationId, action: 'approve' },
        success: function (response) {
            if (response.success) {
                $(this).closest('tr').find('td:last-child').html('<span class="text-success">Approved</span>');
                alert('Registration approved successfully.');
            } else {
                alert('Approving Successful.');
                window.location.reload();
            }
        },
        error: function () {
            alert('An error occurred.');
        }
    });
});

$(document).on('click', '.btn-reject', function () {
    const registrationId = $(this).data('id');

    $.ajax({
        url: 'adminControl.php',
        type: 'POST',
        data: { id: registrationId, action: 'reject' },
        success: function (response) {
            if (response.success) {
                $(this).closest('tr').remove();
                alert('Registration rejected successfully.');
            } else {
                alert('Rejected Successfully.');
                window.location.reload(); 
            }
        },
        error: function () {
            alert('An error occurred.');
        }
    });
});

    // Utility function to generate random colors
function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// Your Chart.js code...
document.addEventListener('DOMContentLoaded', function () {
    fetch('chart.php')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.event_name); // Event names
            const counts = data.map(item => item.registration_count); // Registration counts
            
            // Use random colors for the background of the bars
            const ctx = document.getElementById('registrationsChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels, 
                    datasets: [{
                        label: 'Registrations',
                        data: counts,
                        backgroundColor: labels.map(() => getRandomColor()), // Random colors for bars
                        borderColor: 'rgba(0, 0, 0, 1)', 
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching chart data:', error));
});


    </script>

</body>
</html>
