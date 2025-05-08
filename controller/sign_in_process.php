<?php

include_once '../config/db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = :email AND password = :password";
$stmt = $conn->prepare($sql);
$stmt->execute(['email' => $email, 'password' => $password]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($result) > 0) {
    session_start();
    $_SESSION['email'] = $email;
    $_SESSION['user_id'] = $result[0]['user_id'];

    header("location: ../index.php?login=success");
    exit();
} else {
    echo "<script>alert('Invalid login credentials!');</script>";
    echo "<script>window.location.href = '../pages/sign_in.php';</script>";
}
