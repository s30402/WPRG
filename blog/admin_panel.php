<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'author'])) {
    die("Brak dostępu. Tylko administrator lub autor.");
}

$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($role === 'admin') {
    $stmt = $pdo->query("SELECT posts.*, users.username AS author 
                         FROM posts 
                         LEFT JOIN users ON posts.author_id = users.id 
                         ORDER BY created_at DESC");
} else if ($role === 'author') {
    $stmt = $pdo->prepare("SELECT posts.*, users.username AS author 
                           FROM posts 
                           LEFT JOIN users ON posts.author_id = users.id 
                           WHERE posts.author_id = ? 
                           ORDER BY created_at DESC");
    $stmt->execute([$userId]);
    $posts = $stmt->fetchAll();
}

?>

<!DOCTYPE html>
<html>

<head>
  <title><?= $role === 'admin' ? 'Panel administratora' : 'Panel autora' ?></title>
  <link rel="stylesheet" href="./styles/output.css">
</head>

<body>
  <h1><?= $role === 'admin' ? 'Panel administratora' : 'Panel autora' ?></h1>
  <p><a href="index.php">← Powrót do strony głównej</a></p>

  <?php if (empty($posts)): ?>
    <p>Brak postów do wyświetlenia.</p>
  <?php else: ?>
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
  <?php endif; ?>
</body>

</html>