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
  <link rel="stylesheet" href="./styles/output.css">
</head>

<body>

  <div class="w-full h-12 py-2 px-3 grid grid-cols-2 content-center bg-green-300">

    <a href="index.php"><h1 class="col-start-auto content-center text-2xl font-semibold">Blog Project</h1></a>

    <div class="col-start-auto flex justify-end">
      <?php if (isset($_SESSION['user_id'])): ?>
          <p class="block py-0.5 px-4 content-center">Witaj, <?= htmlspecialchars($_SESSION['username']) ?></p>
          <a  class="block py-0.5 px-4 content-center" href="admin_panel.php">Panel zarządzania</a>
          <a  class="block py-0.5 px-4 content-center" href="add_post.php">Dodaj post</a>
          <a  class="block py-0.5 px-4 content-center" href="logout.php">Wyloguj</a>
      <?php else: ?>
        <a class="block py-0.5 px-4 content-center" href="login.php"><p>Zaloguj się</p></a>
        <a class="block py-0.5 px-4 content-center" href="register.php"><p>Zarejestruj się</p></a>
      <?php endif; ?>
    </div>

  </div>

  <div class="relative grid grid-cols-1 grid-rows-1 w-full h-[60dvh]">
    <?php if ($post['image']): ?>
      <img src="uploads/<?= htmlspecialchars($post['image']) ?>" alt="Obrazek" 
      class="row-start-1 col-start-1 object-cover w-full h-full">
    <?php endif; ?>
    <div class="row-start-1 col-start-1 bg-slate-900/30"></div>
    <h1 class="row-start-1 col-start-1 text-center place-self-center max-w-[1400px] text-slate-50 text-6xl font-semibold text-shadow-slate-950">
      <?= htmlspecialchars($post['title']) ?>
    </h1>
  </div>

  <div class="grid grid-cols-1 gap-4 w-[1400px] min-h-[calc(10dvh-48px)] h-auto mx-auto mb-7 p-4 bg-slate-100/30">

    <p class="text-lg font-semibold">Opis:</p>
    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
    <p><small class="font-semibold text-slate-900/50"><?= htmlspecialchars($post['author'] ?? 'Nieznany') ?> - <?= $post['created_at'] ?></small></p>

    <hr>

    <h2 class="text-xl font-semibold">Dodaj komentarz</h2>
    <form action="add_comment.php" method="post">
      <input type="hidden" name="post_id" value="<?= $postId ?>">

      <?php
      $defaultName = isset($_SESSION['username']) ? $_SESSION['username'] : 'guest';
      ?>

      <div class="relative grid gap-y-2">
        <label>
          <p class="font-medium">Nazwa:</p>
          @<input type="text" name="author_name" class="outline-0" required
            value="<?= htmlspecialchars($defaultName) ?>"
            readonly>
        </label>

        <label>
          <p class="font-medium mb-1">Komentarz:</p>
          <textarea name="content" rows="1" required placeholder="Dodaj komentarz" 
          class="w-full border-slate-900/20 border-b-2 min-h-7 outline-0"></textarea>
        </label>

        <div class="flex w-full justify-end">
          <button type="submit" 
          class="inline-block bg-green-300 px-6 py-1 rounded-sm drop-shadow-slate-300 cursor-pointer hover:bg-green-600/60"
          >Skomentuj</button>
        </div>

      </div>
    </form>

    <hr>

    <div class="grid gap-y-2">
      <h2 class="text-xl font-semibold">Komentarze</h2>
      <?php if (count($comments) === 0): ?>
        <p>Brak komentarzy.</p>
      <?php endif; ?>

      <?php foreach ($comments as $comment): ?>
      <div>
        <p class="font-medium">@<?= htmlspecialchars($comment['author_name']) ?> 
          <small class="font-semibold text-slate-900/50"><?= $comment['created_at'] ?></small>
        </p>
        <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</body>

</html>