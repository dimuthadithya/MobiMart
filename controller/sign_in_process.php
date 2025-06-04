<?php

include_once '../config/db.php';

$email = $_POST['email'];
$password = $_POST['password'];

// First get the user by email only
$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $conn->prepare($sql);
$stmt->execute(['email' => $email]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Verify the password against the hash
if ($result && password_verify($password, $result['password'])) {
    session_start();
    $_SESSION['email'] = $email;
    $_SESSION['user_id'] = $result['user_id'];
    $_SESSION['user_type'] = $result['role'];

    header("location: ../index.php?login=success");
    exit();
} else {
    echo "<script>alert('Invalid login credentials!');</script>";
    echo "<script>window.location.href = '../pages/sign_in.php';</script>";
}
