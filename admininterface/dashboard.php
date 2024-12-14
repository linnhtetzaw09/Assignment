<?php
session_start();

include('../backend/db_connection.php');

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: ../home.php');
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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
$query_events = "SELECT id, event_name, date, time, location, activities, age_group, description FROM events";
$result_events = $conn->query($query_events);

if (!$result_events) {
    die("Error fetching events: " . $conn->error);
} 

// Fetch all users from the users table
$query_users = "SELECT id, name, email, preferred_sport, skill_level FROM users";
$result_users = $conn->query($query_users);

if (!$result_users) {
    die("Error fetching users: " . $conn->error);
}


// Fetch registrations from pending_registers and registers
$query_pending = "SELECT * FROM pending_registers";
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
    <link rel="stylesheet" href="../assets/libs/bootstrap-5.3.2-dist/css/bootstrap.min.css"/>
    <!-- fontawsome css1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jquery ui css1 js1 -->
    <link rel="stylesheet" href="../assets/libs/jquery-ui-1.13.2/jquery-ui.min.css">
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

            <div id="nav" class="navbar-collapse collapse justify-content-end text-uppercase fw-bold">
                <ul class=" navbar-nav">
                    <li class="nav-item"><a href="../index.php" class="nav-link mx-2 menuitems">Home</a></li>
                    <li class="nav-item"><a href="../aboutus.php" class="nav-link mx-2 menuitems">About Us</a></li>
                    <li class="nav-item"><a href="../announcement.php" class="nav-link mx-2 menuitems">News & Announcements</a></li>
                    <li class="nav-item"><a href="../events.php" class="nav-link mx-2 menuitems">Events</a></li>
                    <li class="nav-item"><a href="../contactus.php" class="nav-link mx-2 menuitems">Contact</a></li>
                </ul>
            </div>

        </nav>
    <!-- end Nav bar -->


    <div class="container mt-5 pt-5">
    <h1 class="mb-4 mt-5 text-center text-primary">Admin Interface</h1>
    
    <!-- Statistics Section -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text fs-4 fw-bold">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Events</h5>
                    <p class="card-text fs-4 fw-bold">{{ $totalEvents }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Event Form -->
    <div class="mt-5">
        <h2 class="text-secondary">New Event</h2>

        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="p-4 bg-light rounded shadow-sm">
            
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $event->title }}</td>
                            <td class="align-middle">{{ $event->event_date }}</td>
                            <td class="align-middle">{{ $event->time }}</td>
                            <td class="align-middle">{{ $event->location }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning " data-id="{{ $event->id }}" onclick="editEvent(this)">Edit</button>
                                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
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
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $user->name }}</td>
                            <td class="align-middle">{{ $user->email }}</td>
                            <td class="align-middle">{{ $user->preferred_sport }}</td>
                            <td class="align-middle">{{ $user->skill_level }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-id="{{ $user->id }}" onclick="editUser(this)">Edit</button>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="userForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="preferred_sport" class="form-label">Preferred Sport</label>
                        <input type="text" class="form-control" id="preferred_sport" name="preferred_sport">
                    </div>
                    <div class="mb-3">
                        <label for="skill_level" class="form-label">Skill Level</label>
                        <input type="text" class="form-control" id="skill_level" name="skill_level">
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

    <!-- User Registration Section -->
<div class="mt-5">
    <h3 class="mt-5 text-secondary">User Registration</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark text-center">
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Phone</th>
                    <th>Event ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="text-center">
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $eu->name }}</td>
                        <td class="align-middle">{{ $eu->age }}</td>
                        <td class="align-middle">{{ $eu->phone }}</td>
                        <td class="align-middle">{{ $eu->event_id }}</td>
                        <td>
                            <a class="btn btn-sm btn-warning" data-id="{{ $eu->id }}" onclick="editRegisterUser(this)">Edit</a>
                            <form action="{{ route('registrations.destroy', $eu->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>
</div>


</div>

<!-- Edit Event Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="eventEditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                        <input type="file" class="form-control" id="edit_image" name="image">
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
     integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

function editEvent(button) {
    const eventId = button.getAttribute('data-id');

    fetch(`/admin/events/${eventId}/edit`)
        .then(response => response.json())
        .then(data => {
            // Populate the modal with the event data
            document.getElementById('edit_title').value = data.title;
            document.getElementById('edit_event_date').value = data.event_date;
            document.getElementById('edit_time').value = data.time;
            document.getElementById('edit_location').value = data.location;
            document.getElementById('edit_sport').value = data.sport;
            document.getElementById('edit_age_group').value = data.age_group;
            document.getElementById('edit_description').value = data.description;

            // Update the form action to the correct route for the event
            const form = document.getElementById('eventEditForm');
            form.action = `/admin/events/${eventId}`;

            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('editEventModal'));
            modal.show();
        });
}

function editUser(button) {
        const userId = button.getAttribute('data-id');

        fetch(`/admin/users/${userId}/edit`)
            .then(response => response.json())
            .then(data => {
                // Populate form fields with user data
                document.getElementById('name').value = data.name;
                document.getElementById('email').value = data.email;
                document.getElementById('preferred_sport').value = data.preferred_sport || '';
                document.getElementById('skill_level').value = data.skill_level || '';

                // Set form action to the update URL
                const form = document.getElementById('userForm');
                form.action = `/admin/users/${data.id}`;

                // Show the modal
                $('#editUserModal').modal('show');
            });
}

function editRegisterUser(button) {
    const userId = button.getAttribute('data-id'); // Get the user ID from the button

    fetch(`/registrations/${userId}/edit`)
    .then(response => {
        if (!response.ok) {
            console.error('HTTP Error:', response.status, response.statusText);
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        document.getElementById('name').value = data.name;
        document.getElementById('age').value = data.age;
        document.getElementById('phone').value = data.phone;
        document.getElementById('event_id').value = data.event_id;

        const form = document.getElementById('eventRegisterForm');
        form.action = `/registrations/${userId}`;

        const modal = new bootstrap.Modal(document.getElementById('editRegisterUser'));
        modal.show();
    })
    .catch(error => {
        console.error('Error fetching user data:', error);
    });

}

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
                type: 'pie',
                data: {
                    labels: labels, // Event names
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
