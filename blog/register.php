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
</head>

<body>
  <h1>Rejestracja</h1>

  <?php if ($success): ?>
    <p style="color:green;">Konto utworzone! <a href="login.php">Zaloguj się</a></p>
  <?php else: ?>

    <?php foreach ($errors as $error): ?>
      <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endforeach; ?>

    <form method="post">
      <label>Nazwa użytkownika:<br><input type="text" name="username" required></label><br><br>
      <label>Hasło:<br><input type="password" name="password" required></label><br><br>
      <label>Powtórz hasło:<br><input type="password" name="confirm" required></label><br><br>
      <button type="submit">Zarejestruj</button>
    </form>

  <?php endif; ?>
</body>

</html>