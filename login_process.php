<?php
session_start();
require_once "includes/db.php";

// Collect and sanitize input
$email    = trim($_POST['email']);
$password = trim($_POST['password']);

if (empty($email) || empty($password)) {
    $_SESSION['error'] = "Email and password are required.";
    header("Location: login.php");
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Invalid email format.";
    header("Location: login.php");
    exit;
}

// Prepare & execute query
$stmt = $conn->prepare("SELECT id, name, password, is_admin FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $name, $hashed_password, $is_admin);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        session_regenerate_id(true); // 🛡️ Extra session security
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        $_SESSION['is_admin'] = $is_admin;

        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error'] = "Incorrect password.";
        header("Location: login.php");
        exit;
    }
} else {
    $_SESSION['error'] = "No account found with that email.";
    header("Location: login.php");
    exit;
}

$stmt->close();
$conn->close();

?>
