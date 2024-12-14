<?php

session_start(); 
include('mysql/db_connect.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $confirmPassword = $_POST['confirm_password'];

    // Check if passwords match
    if ($_POST['password'] !== $confirmPassword) {
        echo json_encode(['success' => false, 'error' => 'Passwords do not match.']);
        exit;
    } else {
        // Check if email already exists
        $checkEmail = "SELECT id FROM users WHERE email = '$email'";
        $result = $conn->query($checkEmail);
        
        if ($result->num_rows > 0) {
            echo json_encode(['success' => false, 'error' => 'Email already exists.']);
        } else {
            // Insert into database
            $sql = "INSERT INTO users (name, email, password, created_at, updated_at) VALUES ('$name', '$email', '$password', NOW(), NOW())";
            
            if ($conn->query($sql) === TRUE) {
                echo "<script>
                    alert('Signup Successful!');
                    window.location.href = 'login.php';
                </script>";
                exit;
            } else {
                echo json_encode(['success' => false, 'error' => 'Error: ' . $conn->error]);
                exit;
            }
        }
    }
}
?>
