<?php
session_start();
require_once "includes/db.php";

// Make sure the user is logged in and not an admin
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == 1) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch all favorited games by this user
$stmt = $conn->prepare("
  SELECT g.* FROM games g
  JOIN favorites f ON f.game_id = g.id
  WHERE f.user_id = ?
  ORDER BY f.created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$favorites = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Favorite Games</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4">❤️ My Favorite Games</h2>

  <?php if (empty($favorites)): ?>
    <p>You haven't added any favorites yet.</p>
  <?php else: ?>
    <div class="row">
      <?php foreach ($favorites as $game): ?>
        <div class="col-md-3 mb-4">
          <div class="game-card">
            <a href="game_details.php?id=<?= $game['id'] ?>" style="text-decoration: none; color: inherit;">
              <img src="img/<?= htmlspecialchars($game['image']) ?>" alt="<?= $game['title'] ?>" class="img-fluid rounded shadow">
              <p class="game-title mt-2"><?= htmlspecialchars($game['title']) ?></p>
              <p class="platform-text text-muted"><?= htmlspecialchars($game['platform']) ?></p>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <a href="index.php" class="btn btn-outline-secondary mt-4">← Back to Home</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
