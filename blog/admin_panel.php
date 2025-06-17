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

  <?php if (empty($posts)): ?>
    <div class="grid grid-cols-2 gap-4 w-[1400px] min-h-[calc(10dvh-48px)] h-auto mx-auto p-4 bg-slate-100/30">
      <p>Brak postów do wyświetlenia.</p>
    </div>
  <?php else: ?>

    <div class="grid grid-cols-2 gap-4 w-[1400px] min-h-[calc(10dvh-48px)] h-auto mx-auto p-4 bg-slate-100/30">
    
      <?php foreach ($posts as $post): ?>
        <div class="flex content-center w-full">
          <div class="aspect-video h-28 flex-shrink-0 flex items-center justify-center">
            <?php if ($post['image']): ?>
            <img src="uploads/<?= htmlspecialchars($post['image']) ?>" alt="Obrazek" 
            class="w-full h-full object-cover">
            <?php endif; ?>
          </div>

          <div class="flex flex-col justify-center px-5 text-slate-900 flex-1 gap-y-1 max-w-[calc(520px]">
            <h2 class="font-semibold text-justify break-words line-clamp-2 "><?= nl2br(htmlspecialchars(substr($post['title'], 0, 106))) ?></h2>
            
            <p class="grid grid-cols-[auto_1fr] gap-x-3 items-center mt-1">
              <small class="text-slate-900/50 w-auto">
                <?= nl2br(htmlspecialchars(substr($post['author'] ?? 'Nieznany', 0, 35))) ?> -
                <?= $post['created_at'] ?>
            </small>
              <span class="flex gap-x-3 justify-end text-sm font-medium">
                <a class="px-6 py-0.5 rounded-sm bg-blue-300" href="edit_post.php?id=<?= $post['id'] ?>">Edytuj</a>
                <a class="px-6 py-0.5 rounded-sm bg-orange-300" href="delete_post.php?id=<?= $post['id'] ?>"
                  onclick="return confirm('Na pewno chcesz usunąć?')">Usuń</a>
              </span>
            </p>
          </div>
        </div>
      <?php endforeach; ?>
      
    </div>

  <?php endif; ?>
</body>

</html>