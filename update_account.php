<?php
session_start();
require_once "includes/db.php";

// Only allow normal users
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == 1) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update My Account</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="myaccount-bg d-flex justify-content-center align-items-center">

<div class="d-flex justify-content-center align-items-center min-vh-100" style="background: url('img/bg.jpg') center center / cover no-repeat;">
  <div class="card shadow p-4 rounded-4" style="width: 100%; max-width: 400px;">
    <h3 class="text-center mb-3">👤 Update My Account</h3>

    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <form action="update_account_process.php" method="POST">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Email (read-only)</label>
        <input type="email" class="form-control" value="<?= htmlspecialchars($email) ?>" readonly>
      </div>

      <div class="mb-3">
        <label class="form-label">New Password</label>
        <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
      </div>

      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

