<?php
require_once 'db.php';
session_start();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';
  $confirm = $_POST['confirm'] ?? '';

  if (!$username || !$password || !$confirm) {
    $errors[] = "Wszystkie pola są wymagane.";
  } elseif ($password !== $confirm) {
    $errors[] = "Hasła się nie zgadzają.";
  } else {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);

    if ($stmt->fetch()) {
      $errors[] = "Taki użytkownik już istnieje.";
    } else {
      $hashed = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
      $stmt->execute([
        'username' => $username,
        'password' => $hashed
      ]);
      $success = true;
    }
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Rejestracja</title>
  <link rel="stylesheet" href="./styles/output.css">
</head>

<body>
  <div class="relative grid w-full h-dvh">

    <div class="grid place-self-center px-8 py-6 bg-white rounded-lg gap-y-4 drop-shadow-2xl">
      <h1 class="text-3xl font-semibold text-center">Rejestracja</h1>

      <?php if ($success): ?>
        <p class="text-green-700">Konto utworzone! <a href="login.php" class="underline text-blue-600">Zaloguj się</a></p>
      <?php else: ?>

      <?php foreach ($errors as $error): ?>
        <p class="text-red-700"><?= htmlspecialchars($error) ?></p>
      <?php endforeach; ?>

      <form method="post" class="grid gap-y-3">

        <label>
          <p class="mb-1">Nazwa użytkownika:</p>
          <input type="text" name="username" required
            class="w-64 border-slate-900/20 border-b-1 min-h-7 outline-0 bg-white">
        </label>

        <label>
          <p class="mb-1">Hasło:</p>
          <input type="password" name="password" required
            class="w-64 border-slate-900/20 border-b-1 min-h-7 outline-0 bg-white">
        </label>

        <label>
          <p class="mb-1">Powtórz hasło:</p>
          <input type="password" name="confirm" required
            class="w-64 border-slate-900/20 border-b-1 min-h-7 outline-0 bg-white">
        </label>

        <p class="mt-4">
          <button type="submit"
            class="w-full bg-orange-300 px-6 py-2 rounded-sm font-medium drop-shadow-slate-300 cursor-pointer hover:bg-orange-500/60">
            Zarejestruj się
          </button>
        </p>
      </form>

      <p class="mt-2 text-center text-slate-600 text-sm">
        Masz już konto?
        <a href="login.php" class="underline text-blue-600">Zaloguj się</a>
      </p>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>