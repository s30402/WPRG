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
      if (!in_array($_SESSION['role'], ['admin', 'author'])) {
        $stmt = $pdo->prepare("UPDATE users SET role = 'author' WHERE id = ?");
        $stmt->execute([$authorId]);
        $_SESSION['role'] = 'author';
      }
      $success = true;
      header("Location: index.php");
      exit;
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
  <link rel="stylesheet" href="./styles/output.css">
</head>

<body>

  <div class="w-full h-12 py-2 px-3 grid grid-cols-2 content-center bg-orange-300">

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

  <?php if ($success): ?>
    <p>Post dodany pomyślnie!</p>
  <?php endif; ?>

  <?php foreach ($errors as $error): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
  <?php endforeach; ?>

  <form method="post" enctype="multipart/form-data">

    <div class="relative grid grid-cols-1 grid-rows-1 w-full h-[60dvh]">
      <img id="preview-image" src="#" alt="Podgląd zdjęcia"
        class="hidden row-start-1 col-start-1 object-cover w-full h-full" />
      <div class="row-start-1 col-start-1 bg-slate-900/30"></div>
      <h1 class="row-start-1 col-start-1 text-center place-self-center max-w-[1400px] text-slate-50 text-6xl font-semibold text-shadow-slate-950">
        
      </h1>
    </div>

    <div class="grid grid-cols-1 gap-4 w-[1400px] min-h-[calc(10dvh-48px)] h-auto mx-auto mb-7 p-4 bg-slate-100/30">
      <p class="text-lg font-semibold">Tytuł:</p>
      <p>
        <input type="text" name="title" required placeholder="Dodaj nagłówek"
        class="w-full border-slate-900/20 border-b-2 min-h-7 outline-0">
      </p>
      <p class="text-lg font-semibold">Treść:</p>
      <p>
        <textarea name="content" rows="1" required placeholder="Dodaj opis" 
        class="w-full border-slate-900/20 border-b-2 min-h-7 outline-0"></textarea>
      </p>
      <p class="text-lg font-semibold">Zdjęcie:</p>
      <p><input type="file" name="image"></p>
      
      <div class="flex w-full justify-end">
        <button type="submit" 
        class="inline-block bg-orange-300 px-6 py-1 rounded-sm drop-shadow-slate-300 cursor-pointer hover:bg-green-600/60"
        >Opublikuj</button>
      </div>
    </div>

  </form>

  <script>
    document.querySelector('input[type="file"][name="image"]').addEventListener('change', function(event) {
      const file = event.target.files[0];
      const preview = document.getElementById('preview-image');
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          preview.src = e.target.result;
          preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
      } else {
        preview.src = '#';
        preview.classList.add('hidden');
      }
    });
  </script>

</body>

</html>