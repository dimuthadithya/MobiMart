<?php
session_start();
include_once '../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/sign_in.php?error=not_logged_in");
    exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fullName = trim($_POST['fullName']);
    $streetAddress = trim($_POST['streetAddress']);
    $city = trim($_POST['city']);
    $district = trim($_POST['district']);
    $phone = trim($_POST['phone']);
    $userId = $_SESSION['user_id'];

    // Validate inputs
    $errors = [];

    if (empty($fullName)) {
        $errors[] = "Full name is required";
    }

    if (empty($streetAddress)) {
        $errors[] = "Street address is required";
    }

    if (empty($city)) {
        $errors[] = "City is required";
    }

    if (empty($district)) {
        $errors[] = "District is required";
    }

    if (empty($phone)) {
        $errors[] = "Phone number is required";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Invalid phone number format";
    }

    // If there are no errors, proceed with saving the address
    if (empty($errors)) {
        try {
            // Check if this is the user's first address
            $checkSql = "SELECT COUNT(*) as address_count FROM addresses WHERE user_id = :user_id";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->execute(['user_id' => $userId]);
            $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

            // If it's the first address, set it as default
            $isDefault = ($result['address_count'] == 0) ? true : false;

            // Insert the new address
            $sql = "INSERT INTO addresses (user_id, full_name, street_address, city, district, phone, is_default) 
                    VALUES (:user_id, :full_name, :street_address, :city, :district, :phone, :is_default)";

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'user_id' => $userId,
                'full_name' => $fullName,
                'street_address' => $streetAddress,
                'city' => $city,
                'district' => $district,
                'phone' => $phone,
                'is_default' => $isDefault
            ]);

            // Redirect back to checkout page with success message
            header("Location: ../pages/checkout.php?success=address_added");
            exit();
        } catch (PDOException $e) {
            // Log the error and redirect with error message
            error_log("Error: " . $e->getMessage());
            header("Location: ../pages/checkout.php?error=db_error");
            exit();
        }
    } else {
        // Redirect back with error messages
        $errorString = implode(",", $errors);
        header("Location: ../pages/checkout.php?error=validation&messages=" . urlencode($errorString));
        exit();
    }
} else {
    // If not POST request, redirect to checkout
    header("Location: ../pages/checkout.php");
    exit();
}
