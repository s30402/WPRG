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
  <link rel="stylesheet" href="./styles/output.css">
</head>

<body>

  <div class="w-full h-12 py-2 px-3 grid grid-cols-2 content-center bg-blue-200">

    <h1 class="col-start-auto content-center text-2xl">Blog</h1>

    <div class="col-start-auto flex justify-end">
      <?php if (isset($_SESSION['user_id'])): ?>
          <p class="block py-0.5 px-4 content-center">Witaj, <?= htmlspecialchars($_SESSION['username']) ?></p>
          <a  class="block py-0.5 px-4 content-center" href="add_post.php">Dodaj post</a>
          <a  class="block py-0.5 px-4 content-center" href="logout.php">Wyloguj</a>
      <?php else: ?>
        <a class="block py-0.5 px-4 content-center" href="login.php"><p>Zaloguj się</p></a>
        <a class="block py-0.5 px-4 content-center" href="register.php"><p>Zarejestruj się</p></a>
      <?php endif; ?>
    </div>

  </div>

  <div class="grid grid-cols-2 gap-4 w-[1400px] min-h-[calc(10dvh-48px)] h-auto mx-auto p-4 bg-slate-100/30">
    <?php foreach ($posts as $post): ?>

      <div class="grid col-auto mb-4">

        <div class="flex flex-col gap-y-1">
          <?php if ($post['image']): ?>
            <img src="uploads/<?= htmlspecialchars($post['image']) ?>" alt="Obrazek" 
            class="aspect-video object-cover w-full h-fit mb-1">
          <?php endif; ?>

          <h2 class="text-3xl font-semibold">
            <a href="post.php?id=<?= $post['id'] ?>">
              <?= nl2br(htmlspecialchars(substr($post['title'], 0, 47))) ?>
            </a>
          </h2>

          <p class="text-lg font-semibold text-slate-900/50">
            <small><?= htmlspecialchars($post['author'] ?? 'Nieznany') ?> -
            <?= $post['created_at'] ?></small>
          </p>

          <p class="text-lg font-medium text-slate-900/90">
            Opis: <?= nl2br(htmlspecialchars(substr($post['content'], 0, 130))) ?>...
          </p>
        </div>

      </div>

    <?php endforeach; ?>
  </div>

</body>

</html>