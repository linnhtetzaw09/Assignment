<?php
session_start();
include('../mysql/db_connect.php');

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $eventId = $_POST['editEventId'];
    $eventName = $_POST['editEventName'];
    $eventDate = $_POST['editEventDate'];
    $eventTime = $_POST['editEventTime'];
    $eventLocation = $_POST['editEventLocation'];
    $sport = $_POST['editSport'];
    $ageGroup = $_POST['editAgeGroup'];
    $eventDescription = $_POST['editEventDescription'];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("UPDATE events SET 
        title = ?, 
        event_date = ?, 
        time = ?, 
        location = ?, 
        sport = ?, 
        age_group = ?, 
        description = ?
        WHERE id = ?");
    $stmt->bind_param("sssssssi", $eventName, $eventDate, $eventTime, $eventLocation, $sport, $ageGroup, $eventDescription, $eventId);

    if ($stmt->execute()) {
        // Redirect back with success message
        header("Location: dashborad.php");
        exit();
    } else {
        // Redirect back with error message
        header("Location: dashboard.php?error=Failed to update the event.");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>