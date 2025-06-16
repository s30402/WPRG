<?php
require_once 'functions.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title'] ?? '');
  $content = trim($_POST['content'] ?? '');

  $imageFilename = null;
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    $imageFilename = uniqid() . '_' . basename($_FILES['image']['name']);
    $uploadPath = $uploadDir . $imageFilename;

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
      $errors[] = "Błąd zapisu obrazka.";
    }
  }

  if (empty($title) || empty($content)) {
    $errors[] = "Tytuł i treść są wymagane.";
  }

  if (empty($errors)) {
    $authorId = $_SESSION['user_id'];
    if (insertPost($title, $content, $imageFilename, $authorId)) {
      $success = true;
    } else {
      $errors[] = "Nie udało się dodać posta.";
    }
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Dodaj post</title>
</head>

<body>
  <h1>Dodaj nowy post</h1>

  <?php if ($success): ?>
    <p>Post dodany pomyślnie!</p>
  <?php endif; ?>

  <?php foreach ($errors as $error): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
  <?php endforeach; ?>

  <form method="post" enctype="multipart/form-data">
    <label>Tytuł:<br><input type="text" name="title" required></label><br><br>
    <label>Treść:<br><textarea name="content" rows="10" cols="50" required></textarea></label><br><br>
    <label>Obrazek:<br><input type="file" name="image"></label><br><br>
    <button type="submit">Dodaj post</button>
  </form>
</body>

</html>