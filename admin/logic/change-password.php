<?php

include('../../config/DB-connection.php');
session_start();

// 🔹 Check login
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header('Location: ../../login.php');
    exit();
}

// 🔹 Check role
if ($_SESSION['role'] !== 'Admin') {
    header("Location: ../profile.php?mess1=Unauthorized access");
    exit();
}

// 🔹 Check request method
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../profile.php?mess1=Invalid request");
    exit();
}

$user_id = $_SESSION['id'];

$current_password = $_POST['current_password'];
$new_password     = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// 🔹 Check passwords match
if ($new_password !== $confirm_password) {
    header("Location: ../profile.php?mess1=New passwords do not match");
    exit();
}

// 🔹 Get user password
$query = "SELECT password FROM admin WHERE admin_id='$user_id'";
$result = mysqli_query($connection, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    header("Location: ../profile.php?mess1=User not found");
    exit();
}

$row = mysqli_fetch_assoc($result);
$db_password = $row['password'];

// 🔹 Verify current password
if (!password_verify($current_password, $db_password)) {
    header("Location: ../profile.php?mess1=Current password is incorrect");
    exit();
}

// 🔹 Hash new password
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// 🔹 Update password
$update = "UPDATE admin SET password='$hashed_password' WHERE admin_id='$user_id'";
$run = mysqli_query($connection, $update);

if ($run) {
    header("Location: ../profile.php?mess1=Password updated successfully");
    exit();
} else {
    header("Location: ../profile.php?mess1=Database error");
    exit();
}