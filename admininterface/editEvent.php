<?php
session_start();
include('../mysql/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = $_POST['editEventId'];
    $eventName = $_POST['title'];
    $eventDate = $_POST['event_date'];
    $eventTime = $_POST['time'];
    $eventLocation = $_POST['location'];
    $sport = $_POST['sport'];
    $ageGroup = $_POST['age_group'];
    $eventDescription = $_POST['description'];

    $newImageUploaded = false;
    $eventImage = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/img';
        $eventImage = basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $eventImage;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $newImageUploaded = true;
        } else {
            header("Location: dashboard.php?error=Image upload failed.");
            exit();
        }
    }

    if ($newImageUploaded) {
        $stmt = $conn->prepare("UPDATE events SET 
            title = ?, event_date = ?, time = ?, location = ?, sport = ?, age_group = ?, description = ?, image = ? WHERE id = ?");
        $stmt->bind_param("ssssssssi", $eventName, $eventDate, $eventTime, $eventLocation, $sport, $ageGroup, $eventDescription, $eventImage, $eventId);
    } else {
        $stmt = $conn->prepare("UPDATE events SET 
            title = ?, event_date = ?, time = ?, location = ?, sport = ?, age_group = ?, description = ? WHERE id = ?");
        $stmt->bind_param("sssssssi", $eventName, $eventDate, $eventTime, $eventLocation, $sport, $ageGroup, $eventDescription, $eventId);
    }

    if ($stmt->execute()) {
        header("Location: dashboard.php?success=Event updated successfully.");
        exit();
    } else {
        echo "Error: " . $stmt->error;
        exit();
    }

    $stmt->close();
    $conn->close();
}

?>
