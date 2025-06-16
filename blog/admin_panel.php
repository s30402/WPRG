<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  die("Brak dostępu. Tylko administrator.");
}

$stmt = $pdo->query("SELECT posts.*, users.username AS author 
                     FROM posts 
                     LEFT JOIN users ON posts.author_id = users.id 
                     ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Panel administratora</title>
</head>

<body>
  <h1>Panel administratora</h1>
  <p><a href="index.php">← Powrót do strony głównej</a></p>

  <?php foreach ($posts as $post): ?>
    <div style="margin-bottom: 25px;">
      <h2><?= htmlspecialchars($post['title']) ?></h2>
      <p><small>Autor: <?= htmlspecialchars($post['author']) ?> | <?= $post['created_at'] ?></small></p>
      <p>
        <a href="edit_post.php?id=<?= $post['id'] ?>">✏️ Edytuj</a> |
        <a href="delete_post.php?id=<?= $post['id'] ?>" onclick="return confirm('Na pewno chcesz usunąć?')">🗑️ Usuń</a>
      </p>
    </div>
  <?php endforeach; ?>
</body>

</html>