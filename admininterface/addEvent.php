<?php
session_start();
include('../mysql/db_connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_name = $_POST['title'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['time'];
    $event_location = $_POST['location'];
    $event_sport = $_POST['sport'];
    $event_age_group = $_POST['age_group']; 
    $event_description = $_POST['description'];

    // Handle file upload for the image (optional)
    $event_image = null; 
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/img';
        $event_image = basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $event_image;

        // Move uploaded file to the target directory
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            die("Error uploading the file.");
        }
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO events (title, event_date, time, location, sport, age_group, description, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $event_name, $event_date, $event_time, $event_location, $event_sport, $event_age_group, $event_description, $event_image);

    if ($stmt->execute()) {
        // Redirect back to the manage events section
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
