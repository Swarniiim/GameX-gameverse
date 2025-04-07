<?php
session_start();
require_once "../includes/db.php";

// Restrict to admin only
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit;
}

// Fetch all game info
$games = $conn->query("SELECT id, title, genre, platform, category FROM games ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Delete Game</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-dark text-white">

<div class="container mt-5">
  <h2 class="mb-3">🗑️ Delete Game</h2>
  <a href="admin_dashboard.php" class="btn btn-outline-light mb-3">← Back to Dashboard</a>

  <!-- Success message -->
  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= $_SESSION['success']; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>

  <!-- Game list table -->
  <table class="table table-dark table-hover table-bordered">
    <thead>
      <tr>
        <th>Title</th>
        <th>Genre</th>
        <th>Platform</th>
        <th>Category</th>
        <th style="width: 150px;">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($game = $games->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($game['title']) ?></td>
          <td><?= htmlspecialchars($game['genre']) ?></td>
          <td><?= htmlspecialchars($game['platform']) ?></td>
          <td><?= htmlspecialchars(ucfirst($game['category'])) ?></td>
          <td>
            <a href="delete_game.php?id=<?= $game['id'] ?>"
               class="btn btn-sm btn-danger"
               onclick="return confirm('Are you sure you want to delete this game?');">
              Delete
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
