<?php
session_start();
include('mysql/db_connect.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM events WHERE 1=1";

// Apply filters if set
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['filter'])) {
    $sport_type = !empty($_GET['sport_type']) ? mysqli_real_escape_string($conn, $_GET['sport_type']) : '';
    $location = !empty($_GET['location']) ? mysqli_real_escape_string($conn, $_GET['location']) : '';
    $age_group = !empty($_GET['age_group']) ? mysqli_real_escape_string($conn, $_GET['age_group']) : '';


    // Apply the filters to the query
    if (!empty($sport_type)) {
        $query .= " AND sport = '$sport_type'";
    }
    if (!empty($location)) {
        $query .= " AND location = '$location'";
    }
    if (!empty($age_group)) {
        $query .= " AND age_group = '$age_group'";
    }
}

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo '<div id="eventsContainer" class="row mt-4">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4 mb-3">';
        echo '  <div class="card">';
        echo '    <img src="./uploadimage/' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="' . htmlspecialchars($row['sport']) . '">';
        echo '    <div class="card-body">';
        echo '      <h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>';
        echo '      <p class="card-text">Date: ' . htmlspecialchars($row['event_date']) . '</p>';
        echo '      <p class="card-text">Location: ' . htmlspecialchars($row['location']) . '</p>';
        echo '      <p class="card-text">Sport: ' . htmlspecialchars($row['sport']) . '</p>';
        echo '      <p class="card-text">Age Group: ' . htmlspecialchars($row['age_group']) . '</p>';
        echo '      <a href="./events.php" class="btn btn-primary register-btn" data-event-id="' . htmlspecialchars($row['id']) . '">Register Now</a>';
        echo '    </div>';
        echo '  </div>';
        echo '</div>';
    }
    echo '</div>'; // Close eventsContainer
} else {
    echo '<p>No events found matching your criteria.</p>';
}

$conn->close();
?>




<!-- echo "Sport Type: $sport_type, Location: $location, Age Group: $age_group\n"; -->
