<?php
session_start();
require_once "includes/db.php";

$game_id = $_GET['id'] ?? null;

if (!$game_id) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM games WHERE id = ?");
$stmt->bind_param("i", $game_id);
$stmt->execute();
$result = $stmt->get_result();
$game = $result->fetch_assoc();

if (!$game) {
    echo "Game not found.";
    exit;
}

$isFavorited = false;

if (isset($_SESSION['user_id']) && $_SESSION['is_admin'] == 0) {
    $user_id = $_SESSION['user_id'];
    $check = $conn->prepare("SELECT id FROM favorites WHERE user_id = ? AND game_id = ?");
    $check->bind_param("ii", $user_id, $game['id']);
    $check->execute();
    $check->store_result();
    $isFavorited = $check->num_rows > 0;
    $check->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($game['title']) ?> - Game Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <link rel="stylesheet" href="css/style.css">
  
</head>
<body class="bg-light">

<div class="container detail-container">
  <div class="row g-4">
    <!-- Game Image -->
    <div class="col-md-6">
      <img src="img/<?= htmlspecialchars($game['image']) ?>" alt="<?= htmlspecialchars($game['title']) ?>" class="game-image">
    </div>

    <!-- Game Details -->
    <div class="col-md-6">
      <h2 class="fw-bold"><?= htmlspecialchars($game['title']) ?></h2>
      <p class="text-muted"><?= htmlspecialchars($game['platform']) ?></p>
      <p><strong>Genre:</strong> <?= htmlspecialchars($game['genre']) ?></p>
      <p><strong>Category:</strong> <?= htmlspecialchars(ucfirst($game['category'])) ?></p>

      <!-- Score Section -->
      <hr>
      <div class="mb-3">
        
        <div class="d-flex align-items-center justify-content-between">
           <p><strong>Description</strong> <?= htmlspecialchars(ucfirst($game['description'])) ?></p>
         
        </div>
      </div>

  <?php if (isset($_SESSION['user_id']) && $_SESSION['is_admin'] == 0): ?>
  <button 
    id="favoriteBtn"
    class="btn favorite-toggle-btn <?= $isFavorited ? 'favorited' : '' ?>"
    data-game-id="<?= $game['id'] ?>"
    data-favorited="<?= $isFavorited ? '1' : '0' ?>">
    <i class="bi <?= $isFavorited ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
    <span><?= $isFavorited ? 'Remove from Favorites' : 'Add to Favorites' ?></span>
  </button>
<?php endif; ?>



      <div class="mb-3">
        <div class="score-label">USER SCORE</div>
        <div class="d-flex align-items-center justify-content-between">
          <span>User reviews are not available yet</span>
        
        </div>
      </div>
    </div>
  </div>

  <a href="index.php" class="btn btn-outline-secondary back-link">← Back to Home</a>
</div>



<script>
  document.addEventListener("DOMContentLoaded", function () {
    const favoriteBtn = document.getElementById('favoriteBtn');
    if (favoriteBtn) {
      favoriteBtn.addEventListener('click', function () {
        const gameId = this.getAttribute('data-game-id');
        const isFavorited = this.getAttribute('data-favorited');

        fetch('favorite_toggle_ajax.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `game_id=${gameId}`
        })
        .then(response => response.json())
       .then(data => {
  if (data.success) {
    if (data.favorited) {
      favoriteBtn.classList.remove('btn-outline-danger');
      favoriteBtn.classList.add('btn-danger');
      favoriteBtn.innerHTML = '<i class="bi bi-heart-fill"></i> <span>Remove from Favorites</span>';
      favoriteBtn.setAttribute('data-favorited', '1');
      showToast("❤️ Added to Favorites");
    } else {
      favoriteBtn.classList.remove('btn-danger');
      favoriteBtn.classList.add('btn-outline-danger');
      favoriteBtn.innerHTML = '<i class="bi bi-heart"></i> <span>Add to Favorites</span>';
      favoriteBtn.setAttribute('data-favorited', '0');
      showToast("❌ Removed from Favorites");
    }
  } else {
    showToast("Something went wrong ❗", true);
  }
});
      });
    }
  });
  function showToast(message, isError = false) {
  const toast = new bootstrap.Toast(document.getElementById('favToast'));
  const toastText = document.getElementById('favToastText');
  const toastElement = document.getElementById('favToast');

  toastText.textContent = message;

  // Change color if it's an error
  toastElement.classList.remove('bg-success', 'bg-danger');
  toastElement.classList.add(isError ? 'bg-danger' : 'bg-success');

  toast.show();
}

</script>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
  <div id="favToast" class="toast align-items-center text-white bg-success border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body" id="favToastText">
        <!-- Toast message will be inserted here -->
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
