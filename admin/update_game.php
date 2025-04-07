<?php
session_start();
require_once "../includes/db.php";

// Admin check
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit;
}

// Fetch all games
$result = $conn->query("SELECT * FROM games ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Game</title>
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

<div class="container mt-5">
  <?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $_SESSION['success']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>

  <h2 class="mb-4">🎮 Update Game</h2>
  <a href="admin_dashboard.php" class="btn btn-outline-light mb-3">← Back to Dashboard</a>
  <table class="table table-dark table-bordered">
    <thead>
      <tr>
        <th>Title</th>
        <th>Platform</th>
        <th>Genre</th>
        <th>Category</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($game = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($game['title']) ?></td>
          <td><?= htmlspecialchars($game['platform']) ?></td>
          <td><?= htmlspecialchars($game['genre']) ?></td>
          <td><?= htmlspecialchars($game['category']) ?></td>
          <td><?= htmlspecialchars($game['description']) ?></td>
          <td>
            <a href="edit_game.php?id=<?= $game['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>
