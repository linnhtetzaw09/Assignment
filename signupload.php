<?php
session_start();
include('mysql/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $age = (int)$_POST['age'];
    $preferredSport = trim($_POST['preferred_sport']);
    $skillLevel = trim($_POST['skill_level']);

    // Validate input
    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword) || empty($age) || empty($preferredSport) || empty($skillLevel)) {
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'error' => 'Invalid email format.']);
        exit;
    }

    if ($password !== $confirmPassword) {
        echo json_encode(['success' => false, 'error' => 'Passwords do not match.']);
        exit;
    }

    if (strlen($password) < 8 || 
        !preg_match('/[A-Z]/', $password) || 
        !preg_match('/[a-z]/', $password) || 
        !preg_match('/[0-9]/', $password) || 
        !preg_match('/[@$!%*?&#]/', $password)) {
        echo json_encode(['success' => false, 'error' => 'Password must be at least 8 characters long, include an uppercase letter, a lowercase letter, a number, and a special character.']);
        exit;
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'Email already exists.']);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    $stmt->close();

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, age, preferred_sport, skill_level, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param('sssiss', $name, $email, $hashedPassword, $age, $preferredSport, $skillLevel);

    if ($stmt->execute()) {
        header('Location: login.php');
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Error inserting user.']);
        exit;
    }
}
?>
