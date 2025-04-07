<?php
session_start();
require_once "includes/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == 1) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$name = trim($_POST['name']);
$password = trim($_POST['password']);

if (empty($name)) {
    $_SESSION['error'] = "Name is required.";
    header("Location: update_account.php");
    exit;
}

if (strlen($name) > 100) {
    $_SESSION['error'] = "Name is too long.";
    header("Location: update_account.php");
    exit;
}

if (!empty($password)) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET name = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $hashed_password, $user_id);
} else {
    $stmt = $conn->prepare("UPDATE users SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $user_id);
}

if ($stmt->execute()) {
    $_SESSION['user_name'] = $name;
    $_SESSION['success'] = "Account updated successfully!";
    header("Location: index.php");
    exit;
} else {
    $_SESSION['error'] = "Failed to update account.";
    header("Location: update_account.php");
    exit;
}?>