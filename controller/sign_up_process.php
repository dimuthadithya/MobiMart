<?php

include_once '../config/db.php';

$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

if ($password == $confirmPassword) {
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    $result = $conn->query($sql);
    if ($result) {
        header("location: ../pages/sign_in.php");
    }
} else {
    echo "<script>alert('Passwords do not match!');</script>";
    echo "<script>window.location.href = '../pages/sign_up.php';</script>";
}
