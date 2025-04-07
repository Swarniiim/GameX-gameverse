<?php
session_start();
require_once "includes/db.php";

header('Content-Type: application/json');

// Validate user
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == 1) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];
$game_id = $_POST['game_id'] ?? null;

if (!$game_id) {
    echo json_encode(['success' => false, 'message' => 'Missing game ID']);
    exit;
}

// Check if already favorited
$stmt = $conn->prepare("SELECT id FROM favorites WHERE user_id = ? AND game_id = ?");
$stmt->bind_param("ii", $user_id, $game_id);
$stmt->execute();
$stmt->store_result();
$isFavorited = $stmt->num_rows > 0;
$stmt->close();

if ($isFavorited) {
    $del = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND game_id = ?");
    $del->bind_param("ii", $user_id, $game_id);
    $del->execute();
    echo json_encode(['success' => true, 'favorited' => false]);
} else {
    $ins = $conn->prepare("INSERT INTO favorites (user_id, game_id) VALUES (?, ?)");
    $ins->bind_param("ii", $user_id, $game_id);
    $ins->execute();
    echo json_encode(['success' => true, 'favorited' => true]);
}
exit;
