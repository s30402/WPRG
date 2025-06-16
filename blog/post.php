<?php
require_once 'db.php';
session_start();

$postId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT posts.*, users.username AS author 
                       FROM posts 
                       LEFT JOIN users ON posts.author_id = users.id 
                       WHERE posts.id = :id");
$stmt->execute(['id' => $postId]);
$post = $stmt->fetch();

if (!$post) {
  die("Post nie istnieje.");
}

$commentsStmt = $pdo->prepare("SELECT * FROM comments WHERE post_id = :post_id ORDER BY created_at DESC");
$commentsStmt->execute(['post_id' => $postId]);
$comments = $commentsStmt->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
  <title><?= htmlspecialchars($post['title']) ?></title>
</head>

<body>
  <h1><?= htmlspecialchars($post['title']) ?></h1>

  <?php if ($post['image']): ?>
    <img src="uploads/<?= htmlspecialchars($post['image']) ?>" alt="Obrazek" style="max-width:400px;">
  <?php endif; ?>

  <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
  <p><small>Autor: <?= htmlspecialchars($post['author'] ?? 'Nieznany') ?> | <?= $post['created_at'] ?></small></p>

  <hr>

  <h2>Komentarze</h2>
  <?php if (count($comments) === 0): ?>
    <p>Brak komentarzy.</p>
  <?php endif; ?>

  <?php foreach ($comments as $comment): ?>
    <div style="margin-bottom: 20px;">
      <strong><?= htmlspecialchars($comment['author_name']) ?>:</strong><br>
      <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
      <small><?= $comment['created_at'] ?></small>
    </div>
  <?php endforeach; ?>

  <hr>

  <h2>Dodaj komentarz</h2>
  <form action="add_comment.php" method="post">
    <input type="hidden" name="post_id" value="<?= $postId ?>">

    <?php
    $defaultName = $_SESSION['username'] ?? '';
    ?>

    <label>Twoje imię:<br>
      <input type="text" name="author_name" required
        value="<?= htmlspecialchars($defaultName) ?>"
        <?= $defaultName ? 'readonly' : '' ?>>
    </label><br><br>


    <label>Komentarz:<br>
      <textarea name="content" rows="5" cols="50" required></textarea>
    </label><br><br>

    <button type="submit">Dodaj komentarz</button>
  </form>
</body>

</html>