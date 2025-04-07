<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: update_game.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM games WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$game = $result->fetch_assoc();

if (!$game) {
    echo "Game not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Game</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

<div class="container mt-5">
  <h2>Edit Game: <?= htmlspecialchars($game['title']) ?></h2>
  <form action="update_process.php" method="POST">
    <input type="hidden" name="id" value="<?= $game['id'] ?>">

    <div class="mb-3">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($game['title']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Genre</label>
      <input type="text" name="genre" class="form-control" value="<?= htmlspecialchars($game['genre']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Platform</label>
      <input type="text" name="platform" class="form-control" value="<?= htmlspecialchars($game['platform']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Category</label>
      <select name="category" class="form-select">
        <option value="new" <?= $game['category'] == 'new' ? 'selected' : '' ?>>New</option>
        <option value="upcoming" <?= $game['category'] == 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
        <option value="top" <?= $game['category'] == 'top' ? 'selected' : '' ?>>Top Rated</option>
      </select>
    </div>
            <div class="mb-3">
      <label class="form-label">Description</label>
      <input type="text" name="description" class="form-control" value="<?= htmlspecialchars($game['description']) ?>" required>
    </div>
     
    

    <button type="submit" class="btn btn-success">Update Game</button>
    <a href="update_game.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>

</body>
</html>
