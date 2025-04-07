<?php
session_start();
require_once "../includes/db.php";

// Admin access only
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit;
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM games WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Game deleted successfully!";
    } else {
        $_SESSION['success'] = "Failed to delete game.";
    }
}

header("Location: delete_game_list.php");
exit;
