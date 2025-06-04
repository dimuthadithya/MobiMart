<?php

include_once '../config/db.php';

$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

if ($password == $confirmPassword) {
    // Hash password before storing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Use prepared statement to prevent SQL injection
    $sql = "INSERT INTO users (email, password, role) VALUES (:email, :password, 'customer')";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    
    if ($stmt->execute()) {
        header("location: ../pages/sign_in.php");
    }
} else {
    echo "<script>alert('Passwords do not match!');</script>";
    echo "<script>window.location.href = '../pages/sign_up.php';</script>";
}
