<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit;}
require_once "../includes/db.php";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title']);
  $genre = trim($_POST['genre']);
  $category = trim($_POST['category']);
  $description=trim($_POST['description']);

  // Handle platform checkboxes
  $platforms = isset($_POST['platforms']) ? implode(', ', $_POST['platforms']) : '';

  // Handle image upload
  $imageName = '';
  if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $imageName = time() . '_' . basename($_FILES['image']['name']);
    $targetPath = "../img/" . $imageName;
    move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
  }

  // Insert into database
  $stmt = $conn->prepare("INSERT INTO games (title, genre, platform, image, category,description) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $title, $genre, $platforms, $imageName, $category, $description);

  if ($stmt->execute()) {
    $_SESSION['success'] = "Game added successfully.";
  } else {
    $_SESSION['error'] = "Error adding game.";
  }

  header("Location: add_game.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Game</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 admin-bg">

  <div class="form-container">
    <h2>Add New Game</h2>
      <!-- Back to dashboard button -->
  <a href="admin_dashboard.php" class="btn btn-outline-light mb-3">← Back to Dashboard</a>

    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Game Title</label>
        <input type="text" name="title" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Genre</label>
        <input type="text" name="genre" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Platform</label><br>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="platforms[]" value="PC" id="platformPC">
          <label class="form-check-label" for="platformPC">PC</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="platforms[]" value="PlayStation 5" id="platformPS5">
          <label class="form-check-label" for="platformPS5">PlayStation 5</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="platforms[]" value="Xbox Series X" id="platformXbox">
          <label class="form-check-label" for="platformXbox">Xbox</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="platforms[]" value="Nintendo Switch" id="platformSwitch">
          <label class="form-check-label" for="platformSwitch">Switch</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="platforms[]" value="Mobile" id="platformMobile">
          <label class="form-check-label" for="platformMobile">Mobile</label>
        </div>
      </div>
      <div class="mb-3">
  <label class="form-label">Game Section</label>
  <select name="category" class="form-select" required>
    <option value="new">New Release</option>
    <option value="upcoming">Upcoming Game</option>
    <option value="top">Top Rated</option>
  </select>
</div>

          <div class="mb-3">
        <label class="form-label">Description</label>
        <input type="text" name="description" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Upload Game Image</label>
        <input type="file" name="image" class="form-control" accept="image/*" required>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-info text-white">Add Game</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
