<?php
session_start();

// Only allow admin access
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
  header("Location: ../index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-dark text-white d-flex justify-content-center align-items-center vh-100">

  <div class="container text-center">
    <h1 class="mb-4">🎮 Admin Dashboard</h1>

    <div class="row justify-content-center">
      <div class="col-md-3 mb-3">
        <a href="add_game.php" class="btn btn-success w-100">➕ Add Game</a>
      </div>
      <div class="col-md-3 mb-3">
        <a href="update_game.php" class="btn btn-warning w-100">✏️ Update Game</a>
      </div>
      <div class="col-md-3 mb-3">
        <a href="delete_game_list.php" class="btn btn-danger w-100">🗑️ Delete Game</a>
      </div>
    </div>

    <div class="mt-4">
      <a href="../index.php" class="btn btn-outline-light">← Back to Site</a>
    </div>
  </div>

</body>
</html>
