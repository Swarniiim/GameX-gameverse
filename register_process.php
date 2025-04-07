<?php
// Start session
session_start();
require_once "includes/db.php";

$name     = trim($_POST['name']);
$email    = trim($_POST['email']);
$password = trim($_POST['password']);

if (empty($name) || empty($email) || empty($password)) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: register.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Invalid email format.";
    header("Location: register.php");
    exit;
}

if (strlen($password) < 6) {
    $_SESSION['error'] = "Password must be at least 6 characters.";
    header("Location: register.php");
    exit;
}

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['error'] = "Email is already registered.";
    header("Location: register.php");
    exit;
}
$stmt->close();

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashed_password);

if ($stmt->execute()) {
    $_SESSION['success'] = "Registration successful. Please log in.";
    header("Location: login.php");
    exit;
} else {
    $_SESSION['error'] = "Something went wrong. Try again.";
    header("Location: register.php");
    exit;
}

$stmt->close();
$conn->close();

?>
