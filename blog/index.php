<?php
require_once 'db.php';
session_start();

$stmt = $pdo->query("SELECT posts.*, users.username AS author 
                     FROM posts 
                     LEFT JOIN users ON posts.author_id = users.id 
                     ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Blog</title>
</head>

<body>
  <h1>Wszystkie posty</h1>

  <?php if (isset($_SESSION['user_id'])): ?>
    <p>Witaj, <?= htmlspecialchars($_SESSION['username']) ?> |
      <a href="add_post.php">Dodaj post</a> |
      <a href="logout.php">Wyloguj</a>
    </p>
  <?php else: ?>
    <p><a href="login.php">Zaloguj się</a></p>
    <p><a href="register.php">Zarejestruj się</a></p>
  <?php endif; ?>

  <?php foreach ($posts as $post): ?>
    <div style="margin-bottom:30px;">
      <h2>
        <a href="post.php?id=<?= $post['id'] ?>">
          <?= htmlspecialchars($post['title']) ?>
        </a>
      </h2>
      <?php if ($post['image']): ?>
        <img src="uploads/<?= htmlspecialchars($post['image']) ?>"
          alt="Obrazek" style="max-width:200px;">
      <?php endif; ?>
      <p><?= nl2br(htmlspecialchars(substr($post['content'], 0, 200))) ?>...</p>
      <p><small>Autor: <?= htmlspecialchars($post['author'] ?? 'Nieznany') ?> |
          <?= $post['created_at'] ?></small></p>
    </div>
  <?php endforeach; ?>
</body>

</html>