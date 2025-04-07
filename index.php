<?php
session_start();
require_once "includes/db.php";

// Fetch games by category
$newReleases = $conn->query("SELECT * FROM games WHERE category = 'new' ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
$upcomingGames = $conn->query("SELECT * FROM games WHERE category = 'upcoming' ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
$topRated = $conn->query("SELECT * FROM games WHERE category = 'top' ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Game Review Hub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">GameReviewHub</a>
    <div class="d-flex">
      <?php if (isset($_SESSION['user_name'])): ?>
        <span class="navbar-text text-white me-3">Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?>!</span>

        <?php if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] == 0): ?>
          <a href="my_favorites.php" class="btn btn-outline-light btn-sm me-2">❤️ My Favorites</a>
          <a href="update_account.php" class="btn btn-outline-light btn-sm me-2">My Account</a>
        <?php endif; ?>

        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
          <a href="admin/admin_dashboard.php" class="btn btn-warning btn-sm me-2">Admin Panel</a>
        <?php endif; ?>

        <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
      <?php else: ?>
        <a href="login.php" class="btn btn-outline-light btn-sm me-2">Login</a>
        <a href="register.php" class="btn btn-primary btn-sm">Sign Up</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- Flash message -->
<?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show container mt-3" role="alert" id="flashMessage">
    <?= $_SESSION['success']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  <script>
    setTimeout(() => {
      const msg = document.getElementById('flashMessage');
      if (msg) msg.style.display = 'none';
    }, 3000);
  </script>
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<!-- Hero Section -->
<div class="hero-section text-center mb-5">
  <h1 class="games-title animated-glow">🎮 Game X</h1>
  <p class="tagline">Your trusted video game review platform</p>
</div>

<!-- Live Search + Filter Form -->
<div class="container mt-4">
  <form id="liveSearchForm" class="row g-3">
    <div class="col-md-4">
      <input type="text" name="q" class="form-control" placeholder="Search games by title...">
    </div>
    <div class="col-md-3">
      <select name="genre" class="form-select">
        <option value="">All Genres</option>
        <option value="Action">Action</option>
        <option value="RPG">RPG</option>
        <option value="Adventure">Adventure</option>
      </select>
    </div>
    <div class="col-md-3">
      <select name="platform" class="form-select">
        <option value="">All Platforms</option>
        <option value="PC">PC</option>
        <option value="PlayStation 5">PlayStation 5</option>
        <option value="Xbox Series X">Xbox</option>
        <option value="Mobile">Mobile</option>
      </select>
    </div>
   
  </form>
</div>

<!-- AJAX Search Results -->
<div class="container mt-4" id="searchResults"></div>

<!-- Game Sections -->
<?php
function renderSection($title, $games, $id) {
  echo "<div class='container mb-5'>";
  echo "<div class='d-flex justify-content-between align-items-center mb-2'>";
  echo "<h4>$title</h4>";
  echo "<div class='scroll-buttons'>";
  echo "<button class='scroll-btn' onclick=\"scrollCarousel('$id', -1)\">&#10094;</button>";
  echo "<button class='scroll-btn' onclick=\"scrollCarousel('$id', 1)\">&#10095;</button>";
  echo "</div></div><hr>";

  echo "<div class='game-carousel' id='carousel-$id'>";
  foreach ($games as $game) {
    echo "<a href='game_details.php?id=" . $game['id'] . "' style='text-decoration: none; color: inherit;'>";
    echo "<div class='game-card'>";
    echo "<img src='img/" . htmlspecialchars($game['image']) . "' alt='" . htmlspecialchars($game['title']) . "'>";
    echo "<p class='game-title'>" . htmlspecialchars($game['title']) . "</p>";
    echo "<p class='platform-text'>" . htmlspecialchars($game['platform']) . "</p>";
    echo "</div></a>";
  }
  echo "</div></div>";
}
?>

<?php renderSection('New Releases', $newReleases, 'new'); ?>
<?php renderSection('Upcoming Games', $upcomingGames, 'upcoming'); ?>
<?php renderSection('Top Rated', $topRated, 'top'); ?>

<!-- Scroll Function -->
<script>
  function scrollCarousel(section, direction) {
    const container = document.getElementById("carousel-" + section);
    const scrollAmount = 300 * direction;
    container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
  }
</script>

<!-- AJAX Search -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('liveSearchForm');
  const inputs = form.querySelectorAll('input, select');

  function liveSearch() {
    const formData = new FormData(form);
    const query = new URLSearchParams(formData).toString();

    fetch('ajax_search.php?' + query)
      .then(res => res.text())
      .then(data => {
        document.getElementById('searchResults').innerHTML = data;
      });
  }

  // Trigger search on typing or changing a filter
  inputs.forEach(input => {
    input.addEventListener('input', liveSearch);  // for typing
    input.addEventListener('change', liveSearch); // for dropdowns
  });
});
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
