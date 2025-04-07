<?php
require_once "includes/db.php";

$q = $_GET['q'] ?? '';
$genre = $_GET['genre'] ?? '';
$platform = $_GET['platform'] ?? '';

$sql = "SELECT * FROM games WHERE 1=1";
$params = [];
$types = "";

if ($q) {
  $sql .= " AND title LIKE ?";
  $params[] = "%" . $q . "%";
  $types .= "s";
}
if ($genre) {
  $sql .= " AND genre = ?";
  $params[] = $genre;
  $types .= "s";
}
if ($platform) {
  $sql .= " AND platform LIKE ?";
  $params[] = "%" . $platform . "%";
  $types .= "s";
}

$stmt = $conn->prepare($sql);
if (!empty($params)) {
  $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$games = $result->fetch_all(MYSQLI_ASSOC);

if (empty($games)) {
  echo "<p class='mt-3'>No games found matching your search.</p>";
} else {
  echo "<div class='row'>";
  foreach ($games as $game) {
    echo "<div class='col-md-3 mb-4'>";
    echo "<a href='game_details.php?id=" . $game['id'] . "' style='text-decoration: none; color: inherit;'>";
    echo "<div class='game-card'>";
    echo "<img src='img/" . htmlspecialchars($game['image']) . "' alt='" . htmlspecialchars($game['title']) . "' class='img-fluid rounded'>";
    echo "<p class='game-title mt-2'>" . htmlspecialchars($game['title']) . "</p>";
    echo "<p class='platform-text text-muted'>" . htmlspecialchars($game['platform']) . "</p>";
    echo "</div></a></div>";
  }
  echo "</div>";
}
