<?php
require_once 'db.php';
require_once 'functions.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  die("Brak dostępu.");
}

$postId = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
$stmt->execute(['id' => $postId]);
$post = $stmt->fetch();

if (!$post) {
  die("Post nie istnieje.");
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title'] ?? '');
  $content = trim($_POST['content'] ?? '');

  $imageFilename = $post['image'];
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    $imageFilename = uniqid() . '_' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageFilename);
  }

  if ($title && $content) {
    $stmt = $pdo->prepare("UPDATE posts SET title = :title, content = :content, image = :image WHERE id = :id");
    $stmt->execute([
      'title' => $title,
      'content' => $content,
      'image' => $imageFilename,
      'id' => $postId
    ]);
    $success = true;
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
    $stmt->execute(['id' => $postId]);
    $post = $stmt->fetch();
  } else {
    $errors[] = "Tytuł i treść są wymagane.";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Edytuj post</title>
</head>

<body>
  <h1>Edytuj post</h1>
  <p><a href="admin_panel.php">← Powrót do panelu</a></p>

  <?php if ($success): ?>
    <p style="color:green;">Zaktualizowano!</p>
  <?php endif; ?>

  <?php foreach ($errors as $error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
  <?php endforeach; ?>

  <form method="post" enctype="multipart/form-data">
    <label>Tytuł:<br><input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required></label><br><br>
    <label>Treść:<br><textarea name="content" rows="10" cols="60" required><?= htmlspecialchars($post['content']) ?></textarea></label><br><br>
    <?php if ($post['image']): ?>
      <p><img src="uploads/<?= htmlspecialchars($post['image']) ?>" style="max-width:200px;"></p>
    <?php endif; ?>
    <label>Zmień obrazek:<br><input type="file" name="image"></label><br><br>
    <button type="submit">Zapisz zmiany</button>
  </form>
</body>

</html>